<?php

namespace Axyr\EmailViewer\Servers\Disk;

use Axyr\EmailViewer\Contracts\EmailMessage;
use Axyr\EmailViewer\Contracts\EmailRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Repository implements EmailRepository
{
    public function disk(): Filesystem
    {
        return Storage::disk(config('emailviewer.servers.disk.disk_name'));
    }

    public function fullPath(string $path): string
    {
        return $this->disk()->path($path);
    }

    public function create(string $email): EmailMessage
    {
        $fileName = now()->format('YmdHisu') . '-' . md5($email) . '-email';

        $this->disk()->put($fileName, $email);

        return $this->getModelInstance($fileName, $email);
    }

    public function get(): Collection
    {
        return collect($this->disk()->allFiles())
            ->filter(fn(string $path) => Str::endsWith($path, '-email'))
            ->sortDesc();
    }

    public function paginate(int|null $perPage = null): LengthAwarePaginator
    {
        $perPage = $perPage ?: (int)config('emailviewer.default_pagination');

        $items = $this->get();
        $page = Paginator::resolveCurrentPage();
        $paginated = $items
            ->forPage($page, $perPage)
            ->map(fn(string $path) => $this->getModelInstance($path, $this->disk()->get($path)));

        return new LengthAwarePaginator($paginated, $items->count() ?: 1, $perPage, $page);
    }

    public function find(string|int $id): ?EmailMessage
    {
        if ($this->exists($id)) {
            return $this->getModelInstance($id, $this->disk()->get($id));
        }

        return null;
    }

    public function delete(string|int $id): void
    {
        if ($this->exists($id)) {
            $this->disk()->delete($id);
        }
    }

    public function exists(string|int $id): bool
    {
        return $this->disk()->exists($id);
    }

    public function prune(Carbon $since): int
    {
        $deleted = 0;

        $this->get()->each(function (string $path) use ($since, &$deleted) {
            if ($this->getTimestamp($path) <= $since->timestamp) {
                $this->disk()->delete($path);
                $deleted++;
            }
        });

        return $deleted;
    }

    protected function getTimestamp(string $path): int
    {
        if (str_contains($path, '-')) {
            // First try to parse date from first part of the filename
            [$timestamp] = explode('-', $path);
            if (is_numeric($timestamp)) {
                try {
                    return Carbon::parse(substr($timestamp, 0, 14))->timestamp;
                } catch (\Throwable $throwable) {
                }
            }
        }

        // Then just use filemtime to get the timestamp as backup
        return filemtime($this->fullPath($path));
    }

    protected function getModelInstance(string $id, string $email): EmailMessage|Model
    {
        $class = $this->getModelClass();

        return new $class($id, $email);
    }

    /**
     * @return string|Model
     */
    protected function getModelClass(): string
    {
        return config('emailviewer.servers.disk.model');
    }
}

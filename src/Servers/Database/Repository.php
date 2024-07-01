<?php

namespace Axyr\EmailViewer\Servers\Database;

use Axyr\EmailViewer\Contracts\EmailMessage;
use Axyr\EmailViewer\Contracts\EmailRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class Repository implements EmailRepository
{
    public function create(string $email): EmailMessage
    {
        $email = $this->getModelInstance(['raw' => $email]);

        $email->fill([
            'from' => $email->from(),
            'to' => $email->to(),
            'subject' => $email->subject(),
        ]);

        $email->save();

        return $email;
    }

    public function get(): Collection
    {
        return $this->getModelClass()::all();
    }

    public function paginate(int|null $perPage = null): LengthAwarePaginator
    {
        return $this->getModelClass()::query()->paginate($perPage ?: config('emailviewer.default_pagination'));
    }

    /**
     * @param mixed $id
     *
     * @return \Axyr\EmailViewer\Contracts\EmailMessage|null|\Illuminate\Database\Eloquent\Model
     */
    public function find(string|int $id): ?EmailMessage
    {
        return $this->getModelClass()::query()->find($id);
    }

    public function delete(string|int $id): void
    {
        $this->getModelClass()::query()->find($id)?->delete();
    }

    public function exists(string|int $id): bool
    {
        return (bool)$this->find($id);
    }

    public function prune(Carbon $since): int
    {
        $files = $this->getModelClass()::query()->where('created_at', '<=', $since)->get();

        $count = $files->count();

        $files->each(fn(Model $email) => $email->delete());

        return $count;
    }

    protected function getModelInstance(array $attributes): EmailMessage|Model
    {
        $class = $this->getModelClass();

        return new $class($attributes);
    }

    /**
     * @return string|Model
     */
    protected function getModelClass(): string
    {
        return config('emailviewer.servers.database.model');
    }
}

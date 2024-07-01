<?php

namespace Axyr\EmailViewer\Manager;

use Axyr\EmailViewer\Contracts\EmailMessage;
use Axyr\EmailViewer\Contracts\EmailRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

readonly class EmailManager
{
    public function __construct(private Application $app)
    {
    }

    public function get(): Collection
    {
        return $this->server()->get();
    }

    public function paginate(int|null $perPage = 25): LengthAwarePaginator
    {
        return $this->server()->paginate($perPage);
    }

    public function exists(string|int $id): bool
    {
        return $this->server()->exists($id);
    }

    public function prune(Carbon $since): int
    {
        return $this->server()->prune($since);
    }

    public function create(string $email): EmailMessage
    {
        return $this->server()->create($email);
    }

    public function find(string|int $id): ?EmailMessage
    {
        return $this->server()->find($id);
    }

    public function delete(string|int $id): void
    {
        $this->server()->delete($id);
    }

    public function server($name = null): EmailRepository
    {
        $name = $name ?: $this->getDefaultServer();
        $repository = $this->getConfig($name)['repository'];

        return app($repository);
    }

    protected function getDefaultServer(): string
    {
        return $this->app['config']["emailviewer.default"];
    }

    protected function getConfig($name): array
    {
        return $this->app['config']["emailviewer.servers.{$name}"] ?: [];
    }
}

<?php

namespace Axyr\EmailViewer\Contracts;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface EmailRepository
{
    public function create(string $email): EmailMessage;

    public function get(): Collection;

    public function paginate(int|null $perPage = null): LengthAwarePaginator;

    public function find(string|int $id): ?EmailMessage;

    public function delete(string|int $id): void;

    public function exists(string|int $id): bool;

    public function prune(Carbon $since): int;
}

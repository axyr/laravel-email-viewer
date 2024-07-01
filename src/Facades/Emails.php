<?php

namespace Axyr\EmailViewer\Facades;

use Axyr\EmailViewer\Contracts\EmailMessage;
use Axyr\EmailViewer\Contracts\EmailRepository;
use Axyr\EmailViewer\Manager\EmailManager;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static EmailRepository server($name = null)
 * @method static EmailMessage create(string $email)
 * @method static EmailMessage find(string|int $id)
 * @method static void delete(string|int $id)
 * @method static Collection get()
 * @method static LengthAwarePaginator paginate(int|null $perPage = null)
 * @method static bool exists(string|int $id)
 * @method static int prune(Carbon $since)
 */
class Emails extends Facade
{
    protected static function getFacadeAccessor()
    {
        return EmailManager::class;
    }
}

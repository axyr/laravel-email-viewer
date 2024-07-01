<?php

namespace Axyr\EmailViewer\Servers\Database;

use Axyr\EmailViewer\Concerns\ParsesEmailAttributes;
use Axyr\EmailViewer\Contracts\EmailMessage;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property ?string $from
 * @property ?string $to
 * @property ?string $subject
 * @property string $raw
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Email extends Model implements EmailMessage
{
    use ParsesEmailAttributes;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->guarded[] = $this->primaryKey;
        $this->table = config('emailviewer.servers.database.table_name') ?: $this->getTable();
    }

    public function id(): string|int
    {
        return $this->getKey();
    }

    public function raw(): string
    {
        return $this->getAttribute('raw');
    }
}

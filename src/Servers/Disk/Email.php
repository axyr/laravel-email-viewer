<?php

namespace Axyr\EmailViewer\Servers\Disk;

use Axyr\EmailViewer\Concerns\ParsesEmailAttributes;
use Axyr\EmailViewer\Contracts\EmailMessage;

class Email implements EmailMessage
{
    use ParsesEmailAttributes;

    public function __construct(private readonly string $id, private readonly string $raw)
    {
    }

    public function id(): string|int
    {
        return $this->id;
    }

    public function raw(): string
    {
        return $this->raw;
    }

}

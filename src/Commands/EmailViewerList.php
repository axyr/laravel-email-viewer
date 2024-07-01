<?php

namespace Axyr\EmailViewer\Commands;

use Axyr\EmailViewer\Contracts\EmailMessage;
use Axyr\EmailViewer\Facades\Emails;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class EmailViewerList extends Command
{
    protected $signature = 'email-viewer:list
        {--server= : The email store to list}
    ';

    protected $description = 'List Emails';

    public function handle()
    {
        $emails = Emails::server($this->option('server'))->paginate();

        $headers = [
            'id',
            'date',
            'to',
            'subject',
        ];

        $rows = $emails->map(fn(EmailMessage $email) => Arr::only($email->toArray(), $headers))->toArray();

        $this->table($headers, $rows);
    }
}

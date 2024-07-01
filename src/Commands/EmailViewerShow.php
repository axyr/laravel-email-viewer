<?php

namespace Axyr\EmailViewer\Commands;

use Axyr\EmailViewer\Facades\Emails;
use Illuminate\Console\Command;

class EmailViewerShow extends Command
{
    protected $signature = 'email-viewer:show
        { id : the unique id of the email (example: path or id) }
        { --server= : The email store to list}';

    protected $description = 'Show an email';

    public function handle(): void
    {
        $email = Emails::server($this->option('server'))->find($this->argument('id'));

        $headers = [
            'attribute',
            'value',
        ];

        $rows = array_map(fn($k, $v) => [$k, $v], array_keys($email->toArray()), $email->toArray());

        $this->table($headers, $rows);
    }
}

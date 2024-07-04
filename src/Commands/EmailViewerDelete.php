<?php

namespace Axyr\EmailViewer\Commands;

use Axyr\EmailViewer\Facades\Emails;
use Illuminate\Console\Command;

class EmailViewerDelete extends Command
{
    protected $signature = 'email-viewer:delete
        { --id= : The unique id of the email (example: path or id) }
        { --since= : Delete all emails since n days ago }
        { --server= : The email store to list }';

    protected $description = 'Show an email';

    public function handle(): void
    {
        $server = Emails::server($this->option('server'));

        if ($id = $this->option('id')) {
            $server->delete($id);
            $this->info("Email {$id} deleted.");
        } elseif ($since = (int)$this->option('since')) {
            $deleted = $server->prune(now()->subDays($since));
            $this->info("{$deleted} email(s) deleted.");
        } else {
            $this->info('Nothing to to delete.');
        }
    }
}

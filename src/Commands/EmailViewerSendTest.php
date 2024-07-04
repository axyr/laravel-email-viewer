<?php

namespace Axyr\EmailViewer\Commands;

use Axyr\EmailViewer\Emails\TestEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EmailViewerSendTest extends Command
{
    protected $signature = 'email-viewer:send-test
        { --from= : The sender email address }
        { --to= : The recipient email address }
        { --subject= : The email subjectt }';

    protected $description = 'Send a test email';

    public function handle(): void
    {
        $from = $this->option('from') ?: config('mail.from.address');
        $to = $this->option('from') ?: config('mail.from.address');
        $subject = $this->option('subject') ?: 'Laravel Email Viewer Test Email';

        $email = new TestEmail();
        $email->from($from);
        $email->subject($subject);

        Mail::to($to)->send($email);
    }
}

<?php

namespace Axyr\EmailViewer\Tests\Commands;

use Axyr\EmailViewer\Commands\EmailViewerSendTest;
use Axyr\EmailViewer\Emails\TestEmail;
use Axyr\EmailViewer\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class EmailViewerSendTestTest extends TestCase
{
    public function testItSendsATestEmail()
    {
        Mail::fake();

        Artisan::call(EmailViewerSendTest::class);

        Mail::assertSent(TestEmail::class);
    }

}

<?php

namespace Axyr\EmailViewer\Tests\Listeners;

use Axyr\EmailViewer\Emails\TestEmail;
use Axyr\EmailViewer\Servers\Disk\Repository;
use Axyr\EmailViewer\Tests\TestCase;
use Illuminate\Support\Facades\Mail;

class EmailWriterListenerTest extends TestCase
{
    public function testItDoesNotStoreAnEmailWhenEmailViewerIsDisabled(): void
    {
        config()->set('emailviewer.enabled', false);

        Mail::to(fake()->email())->send(new TestEmail);

        $this->assertCount(0, app(Repository::class)->get());
    }

    public function testItStoresAnEmailWhenEmailViewerIsEnabled(): void
    {
        config()->set('emailviewer.enabled', true);

        Mail::to(fake()->email())->send(new TestEmail);

        $this->assertCount(1, app(Repository::class)->get());
    }

    public function testItStoresTheBccAsFakeHeader(): void
    {
        // Bcc is not stored as an email header.
        // To allow inspection in the viewer, we will store is as a fake header X-Bcc
        config()->set('emailviewer.enabled', true);

        $email = (new TestEmail)->bcc('test@test.nl', 'Test');
        Mail::to(fake()->email())->send($email);

        $storedEmail = app(Repository::class)->paginate()->first();

        $this->assertEquals('"Test" <test@test.nl>', $storedEmail->bcc());
    }
}

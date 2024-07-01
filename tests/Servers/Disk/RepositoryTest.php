<?php

namespace Axyr\EmailViewer\Tests\Servers\Disk;

use Axyr\EmailViewer\Servers\Disk\Repository;
use Axyr\EmailViewer\Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testItStoresAnEmailToTheDatabase(): void
    {
        $email = app(Repository::class)->create($this->emailContent);

        $this->assertEquals($this->now->format('YmdHisu') . '-3a18860163e7a2fc1dfe71162db4a24d-email', $email->id());
        $this->assertEquals($this->emailContent, $email->raw());
        $this->assertEquals('"Mrs. Lavinia Pacocha" <mason92@hotmail.com>', $email->from());
        $this->assertEquals('Marshall Ryan <oma.crist@mclaughlin.com>, Aracely Lebsack <madilyn.jacobs@yahoo.com>', $email->to());
        $this->assertEquals('Laudantium laudantium earum id vel.', $email->subject());
        $this->assertEquals('<c72320b6a06678c066c4054d41ebe939@hotmail.com>', $email->messageId());
        $this->assertEquals('2024-07-01 10:07:35', $email->date()->format('Y-m-d H:i:s'));
        $this->assertEquals('Nickolas Schinner <mekhi.kovacek@abernathy.com>, Camila Botsford <caden54@murray.org>', $email->cc());
        $this->assertEquals('"Marcus Greenfelder" <feil.mac@yahoo.com>, "Johathan Brakus" <lula.dubuque@yahoo.com>', $email->bcc());
    }

    public function testItGetsAListOfEmails(): void
    {
        app(Repository::class)->create($this->emailContent . '1');
        app(Repository::class)->create($this->emailContent . '2');

        $this->assertCount(2, app(Repository::class)->get());
    }

    public function testItGetsAListOfPaginatedEmails(): void
    {
        config()->set('emailviewer.default_pagination', 3);

        for ($i = 0; $i < 6; $i++) {
            app(Repository::class)->create($this->emailContent . $i);
        }

        $this->assertCount(3, app(Repository::class)->paginate());
    }

    public function testItFindsAndEmail(): void
    {
        app(Repository::class)->create($this->emailContent);

        $fileName = $this->now->format('YmdHisu') . '-3a18860163e7a2fc1dfe71162db4a24d-email';

        $this->assertTrue(app(Repository::class)->exists($fileName));
        $this->assertEquals($fileName, app(Repository::class)->find($fileName)->id());
    }

    public function testItDeletesAndEmail(): void
    {
        app(Repository::class)->create($this->emailContent);

        $fileName = $this->now->format('YmdHisu') . '-3a18860163e7a2fc1dfe71162db4a24d-email';

        app(Repository::class)->delete($fileName);

        $this->assertCount(0, app(Repository::class)->get());
    }

    public function testItPrunesTheEmails(): void
    {
        app(Repository::class)->create($this->emailContent);

        Carbon::setTestNow($this->now->clone()->subDays(2));

        app(Repository::class)->create($this->emailContent);

        $this->assertEquals(1, app(Repository::class)->prune($this->now->clone()->subDay()));
        $this->assertCount(1, app(Repository::class)->get());

        $this->assertEquals(1, app(Repository::class)->prune($this->now));
        $this->assertCount(0, app(Repository::class)->get());
    }

}
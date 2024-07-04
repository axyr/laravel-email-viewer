<?php

namespace Axyr\EmailViewer\Tests\Http\Controllers;

use Axyr\EmailViewer\Servers\Disk\Repository;
use Axyr\EmailViewer\Tests\TestCase;

class JsonEmailControllerTest extends TestCase
{
    protected array $resourceKeys = [
        'id',
        'message_id',
        'from',
        'to',
        'cc',
        'bcc',
        'subject',
        'date',
        'raw',
        'text',
        'html',
        'headers',
    ];

    public function testListsPaginatedEmails(): void
    {
        config()->set('emailviewer.default_pagination', 3);

        $routeNamespace = config('emailviewer.route-prefix');

        for ($i = 0; $i < 6; $i++) {
            app(Repository::class)->create($this->emailContent . $i);
        }

        $response = $this->getJson(route($routeNamespace . '.json.index'));

        $this->assertCount(3, $response->json('data'));

        $this->assertEquals($this->resourceKeys, array_keys($response->json('data.0')));
    }

    public function testShowsAnEmail(): void
    {
        $routeNamespace = config('emailviewer.route-prefix');

        $email = app(Repository::class)->create($this->emailContent);

        $response = $this->getJson(route($routeNamespace . '.json.show', [$email->id()]));

        $this->assertEquals($this->resourceKeys, array_keys($response->json('data')));
    }

    public function testDeletesAnEmail(): void
    {
        $routeNamespace = config('emailviewer.route-prefix');

        $email = app(Repository::class)->create($this->emailContent);

        $response = $this->deleteJson(route($routeNamespace . '.json.destroy', [$email->id()]));

        $response->assertStatus(204);

        $this->assertCount(0, app(Repository::class)->get());
    }
}

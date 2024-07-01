<?php

namespace Axyr\EmailViewer\Tests;

use Axyr\EmailViewer\EmailViewerServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Orchestra\Testbench\Concerns\WithWorkbench;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithWorkbench;

    protected $enablesPackageDiscoveries = true;

    protected ?string $content = null;

    protected ?Carbon $now = null;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::deleteDirectory('');

        Carbon::setTestNow($this->now = now());

        $this->emailContent = file_get_contents(__DIR__ . '/fixtures/test-email');
    }

    protected function getPackageProviders($app)
    {
        return [
            EmailViewerServiceProvider::class,
        ];
    }
}

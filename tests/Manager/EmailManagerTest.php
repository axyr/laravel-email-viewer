<?php

namespace Axyr\EmailViewer\Tests\Manager;

use Axyr\EmailViewer\Facades\Emails;
use Axyr\EmailViewer\Servers\Database\Repository as DatabaseRepository;
use Axyr\EmailViewer\Servers\Disk\Repository as DiskRepository;
use Axyr\EmailViewer\Tests\TestCase;

class EmailManagerTest extends TestCase
{
    public function testItGetsTheSelectedServer(): void
    {
        $this->assertInstanceOf(DiskRepository::class, Emails::server('disk'));
        $this->assertInstanceOf(DatabaseRepository::class, Emails::server('database'));

        config()->set('emailviewer.default', 'disk');
        $this->assertInstanceOf(DiskRepository::class, Emails::server());

        config()->set('emailviewer.default', 'database');
        $this->assertInstanceOf(DatabaseRepository::class, Emails::server());
    }

}

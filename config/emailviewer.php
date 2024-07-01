<?php

return [
    'default' => env('EMAIL_VIEWER_DEFAULT', 'disk'),
    'enabled' => (bool)env('EMAIL_VIEWER_ENABLED', true),
    'parser' => \Axyr\EmailViewer\Parsers\PhpMimeMailParser::class,
    'listener' => \Axyr\EmailViewer\Listeners\EmailWriterListener::class,
    'route-namespace' => 'emails',
    'default_pagination' => 25,
    'servers' => [
        'disk' => [
            'disk_name' => env('EMAIL_VIEWER_DISK', env('FILESYSTEM_DISK', 'local')),
            'model' => \Axyr\EmailViewer\Servers\Disk\Email::class,
            'repository' => \Axyr\EmailViewer\Servers\Disk\Repository::class,
        ],
        'database' => [
            'table_name' => 'email_viewer_emails',
            'model' => \Axyr\EmailViewer\Servers\Database\Email::class,
            'repository' => \Axyr\EmailViewer\Servers\Database\Repository::class,
        ],
    ],
];

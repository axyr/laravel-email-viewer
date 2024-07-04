# Configuration

> This package requires the PECL [mailparse](https://www.php.net/manual/en/book.mailparse.php) extension

The Email Viewer will work out of the box after installing,
but you van change most of the default behaviour by adjusting the config setting.

First publish the configuration file:

```php
php artisan vendor:publish --provider="Axyr\EmailViewer\EmailViewerServiceProvider"
```

Below are the configuration options available to you

```php
<?php

return [
    /*
     * This option defines the default storage method.
     * You can choose between one of the Laravel 
     * filesystem disks or a database table.
     */
    'default' => env('EMAIL_VIEWER_DEFAULT', 'disk'),
    
    /*
     * When this option is set to false, the package will not copy any emails. 
     */
    'enabled' => (bool)env('EMAIL_VIEWER_ENABLED', true),
    
    /*
     * The PhpMimeMailParser uses the pecl mailparse extension.
     * Replace this class if you want to use a customer mail parser.
     */
    'parser' => \Axyr\EmailViewer\Parsers\PhpMimeMailParser::class,
    
    /*
     * The EmailWriterListener listens to the MessageSending event
     * and copies the email to the default storage.
     */
    'listener' => \Axyr\EmailViewer\Listeners\EmailWriterListener::class,
    
    /*
     * Disable this setting, if you don't want to use the default routes
     * and instead use your own route setup.
     */
    'routes-enabled' => true,
    
    /*
     * If you do want to use the default routes,
     * but want a different prefix, you can adjust this value.
     */
    'route-prefix' => 'emails',
    
    /*
     * The package controllers default items per page for the pagination results.
     */
    'default_pagination' => 25,
    
    /*
     * The possible 'servers' where you can store a copy of all the outgoing emails.
     * You can swap out the model and repository classes with your own implementations.
     */
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
```

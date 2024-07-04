# Installation

> This package requires the PECL [mailparse](https://www.php.net/manual/en/book.mailparse.php) extension

Run the composer install command from the terminal:

```php
composer require axyr/laravel-email-viewer
```

Publish the database migration and configuration file:

```php
php artisan vendor:publish --provider="Axyr\EmailViewer\EmailViewerServiceProvider"
```

By default this package provides a set of routes for the Blade UI and the Vue UI. You can disabled them in the config file.

You can access the Blade UI by visiting:

```
https://your-host.tld/emails
```

To send a test email the package provides a simple Test command.
By default it will send to the laraval config value `mail.from.address`

```php
php artisan email-viewer:send-test --from=from@sender.tld --to=to@recipient.tld
```

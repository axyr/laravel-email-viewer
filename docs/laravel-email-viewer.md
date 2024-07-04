# 📨 Laravel Email Viewer

View and inspect all emails sent from your Laravel application.

![](docs/img/mailboxes.png)

Laravel Email Viewer is a package that allows you to view all emails sent from you application in the browser. This allows you to ensure your application has actually sent the mail. When using log as
an email driver for your local or staging environment, you can inspect emails without the need for external tools like Mailtrap or Mailhog, so emails never have to leave your server at all.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/axyr/laravel-email-viewer.svg?style=flat-square)](https://packagist.org/packages/axyr/laravel-email-viewer) [![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/spatie/laravel-permission/run-tests-L8.yml?branch=main\&label=Tests)](https://github.com/axyr/laravel-email-viewer/actions?query=workflow%3ATests+branch%3Amain)

## Key features

* Log all application emails to a storage disk or database table
* Inspect HTML, attachments and email headers
* Packed with a simple Blade UI and a Vue.js/JSON controller
* Easily integrate in your existing application

# Introduction

This package allows copying and viewing all outgoing emails locally from your Laravel application.

This can be used in production to ensure you application actually sent the emails.
For example when users say they did not receive an email and you want to verify the email was sent from the application.

But this package can also replace tools like Mailhog or Mailtrap to inspect emails sent from test or staging environments.
Sometimes you might want to or are not allowed to using an external service to catch emails.

In that case you will probably use the ``log`` or ``array`` mail driver to ensure emails will never leave the system.

To make inspecting those emails easier or allow test users to view the emails in the application, you can use this package to inspect and test emails in your non-local and non-production environments.
In this way, can still test features like password reset or other transactional email features.

![](img/screenshot.png)

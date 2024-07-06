# Commands

The package comes with a few commands to inspect the emails on the command line:

- EmailViewerList
- EmailViewerShow
- EmailVieuwerDelete
- EmailViewerSendTest

## EmailViewerList

List the emails for a particular server:

```shell
 php artisan email-viewer:list --server=disk
 ```

## EmailViewerShow

Show a single email for a particular server:

```shell
 php artisan email-viewer:show id-or-filename --server=disk
 ```

## EmailViewerDelete

Delete a single email for a particular server, or prune all emails older than x amount of days in the past:

```shell
 php artisan email-viewer:delete --id=id-or-filename --server=disk
 php artisan email-viewer:delete --since=30 --server=disk
 ```

## EmailViewerSendTest

Send a simple test email:

```shell
 php artisan email-viewer:send-test id-or-filename --from=x@from.tdl --to=x@to.tld --subject="My Test Email"
 ```

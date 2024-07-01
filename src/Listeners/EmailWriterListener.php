<?php

namespace Axyr\EmailViewer\Listeners;

use Axyr\EmailViewer\Writer\EmailMessageWriter;
use Illuminate\Mail\Events\MessageSending;

readonly class EmailWriterListener
{
    public function __construct(protected EmailMessageWriter $writer)
    {
    }

    public function handle(MessageSending $event): void
    {
        if (config('emailviewer.enabled')) {
            $this->writer->write($event->message);
        }
    }
}

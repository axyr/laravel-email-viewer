<?php

namespace Axyr\EmailViewer\Listeners;

use Axyr\EmailViewer\Facades\Emails;
use Illuminate\Mail\Events\MessageSending;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class EmailWriterListener
{
    public function handle(MessageSending $event): void
    {
        if (config('emailviewer.enabled')) {
            $this->addBcc($event->message);
            Emails::create($event->message->toString());
        }
    }

    protected function addBcc(Email $message): void
    {
        $bcc = array_filter(array_map(fn(Address $address) => $address->toString(), $message->getBcc()));
        if ($bcc) {
            $message->getHeaders()->addHeader('X-Bcc', implode(', ', $bcc));
        }
    }
}

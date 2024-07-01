<?php

namespace Axyr\EmailViewer\Writer;

use Axyr\EmailViewer\Facades\Emails;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class EmailMessageWriter
{
    public function write(Email $message): void
    {
        $this->addBcc($message);
        Emails::create($message->toString());
    }

    protected function addBcc(Email $message): void
    {
        $bcc = array_filter(array_map(fn(Address $address) => $address->toString(), $message->getBcc()));
        if ($bcc) {
            $message->getHeaders()->addHeader('X-Bcc', implode(', ', $bcc));
        }
    }
}

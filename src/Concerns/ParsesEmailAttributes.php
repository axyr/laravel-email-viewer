<?php

namespace Axyr\EmailViewer\Concerns;

use Axyr\EmailViewer\Contracts\EmailParser;
use Carbon\Carbon;

trait ParsesEmailAttributes
{
    private ?EmailParser $parser = null;

    public function parser(): EmailParser
    {
        if ( ! $this->parser) {
            $this->parser = app(EmailParser::class)->setText($this->raw());
        }

        return $this->parser;
    }

    public function subject(): ?string
    {
        return $this->parser()->getHeader('Subject') ?: null;
    }

    public function messageId(): ?string
    {
        return $this->parser()->getHeader('Message-ID');
    }

    public function from(): ?string
    {
        return $this->parser()->getHeader('from') ?: null;
    }

    public function to(): ?string
    {
        return $this->parser()->getHeader('to') ?: null;
    }

    public function cc(): ?string
    {
        return $this->parser()->getHeader('cc') ?: null;
    }

    public function bcc(): ?string
    {
        return $this->parser()->getHeader('x-bcc') ?: null;
    }

    public function date(): ?Carbon
    {
        if ($date = $this->parser()->getHeader('Date')) {
            return Carbon::parse($date);
        }

        return null;
    }

    public function headers(): array|false
    {
        return $this->parser()->getHeaders();
    }

    public function boundary(): ?string
    {
        $contentType = $this->parser()->getHeader('Content-Type');

        preg_match('/boundary="(.*)"$/', $contentType, $matches);

        return $matches[1] ?? null;
    }

    public function text(): string
    {
        return $this->parser()->getMessageBody();
    }

    public function html($type = 'html'): string
    {
        return $this->parser()->getMessageBody($type);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'message_id' => $this->messageId(),
            'from' => $this->from(),
            'to' => $this->to(),
            'cc' => $this->cc(),
            'bcc' => $this->bcc(),
            'subject' => $this->subject(),
            'date' => $this->date(),
            'raw' => $this->raw(),
            'text' => $this->text(),
            'html' => $this->html(),
            'headers' => $this->headers(),
        ];
    }
}

<?php

namespace Axyr\EmailViewer\Contracts;

use DateTime;

interface EmailMessage
{
    public function parser(): EmailParser;

    public function id(): string|int;

    public function messageId(): ?string;

    public function date(): ?DateTime;

    public function raw(): string;

    public function subject(): ?string;

    public function from(): ?string;

    public function to(): ?string;

    public function cc(): ?string;

    public function bcc(): ?string;

    public function boundary(): ?string;

    public function text(): ?string;

    public function toArray(): array;
}

<?php

namespace Axyr\EmailViewer\Parsers;

use Axyr\EmailViewer\Contracts\EmailParser;
use PhpMimeMailParser\Parser;

class PhpMimeMailParser extends Parser implements EmailParser
{
    // This subclass is added to enforce our own EmailParser interface
}

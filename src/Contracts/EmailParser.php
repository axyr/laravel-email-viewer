<?php

namespace Axyr\EmailViewer\Contracts;

interface EmailParser
{
    public function setText($data);

    /**
     * @param string $name
     *
     * @return string|false
     */
    public function getHeader($name);

    /**
     * @return array
     */
    public function getHeaders();

    /**
     * @param string $type
     *
     * @return string
     */
    public function getMessageBody($type = 'text');
}

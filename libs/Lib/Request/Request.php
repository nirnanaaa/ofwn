<?php

namespace Lib\Request;

class Request
{
    private $webseperator = '/';

    public function __construct(){}
    public static function fromGlobals(){}
    public function buildRequest(){}
    public function addLeadingSlash($url = null)
    {
        if (null === $url || empty($url)) {
            return $this->webseperator;
        }
        if (strpos($url, $this->webseperator) === 0) {
            return $url;
        }

        return $this->webseperator . $url;

    }

}

<?php

namespace Lib\Config;
use Lib\File\ReaderInterface;

interface ParserInterface
{
    public function __construct( ReaderInterface $file);

    public function write($content);

    public function read();

    public function parse();

    public function isValid();

}

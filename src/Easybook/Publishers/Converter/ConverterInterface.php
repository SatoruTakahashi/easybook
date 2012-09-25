<?php

namespace Easybook\Publishers\Formatter;

use Easybook\Parsers\ParserInterface;

interface ConverterInterface
{
    public function convert();

    public function supports($type);

    public function setParser(ParserInterface $parser);
}
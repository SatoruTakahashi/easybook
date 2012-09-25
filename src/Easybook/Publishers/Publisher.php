<?php

namespace Easybook\Publishers;

use Easybook\Parsers\ParserInterface;
use Easybook\Publishers\Converter\ConverterInterface;
use Easybook\Publishers\Exception\UnsupportedFormatException;

class Publisher implements PublisherInterface
{
    private $converters;
    private $parser;

    public function __construct(ParserInterface $parser, array $converters = array())
    {
        $this->parser = $parser;
        $this->converters = array();

        foreach ($converters as $converter) {
            $this->addConverter($converter);
        }
    }

    public function addConverter(ConverterInterface $converter)
    {
        if (!in_array($converter, $this->converters)) {
            $converter->setParser($this->parser);
            $this->converters[] = $converter;
        }
    }

    public function publish()
    {
        $format = 'pdf';

        if (!$converter = $this->getConverter($format)) {
            throw new UnsupportedFormatException(sprintf('The specified "%s" output format is not supported.', $format));
        }

        //$converter->convert();
    }

    private function getConverter($format)
    {
        foreach ($this->converters as $converter) {
            if ($converter->supports($format)) {
                return $converter;
            }
        }
    }
}
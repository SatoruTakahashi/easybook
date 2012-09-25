<?php

/*
 * This file is part of the easybook application.
 *
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Easybook\Publishers\Converter;

use Easybook\Events\EasybookEvents as Events;
use Easybook\Events\BaseEvent;
use Easybook\Events\ParseEvent;

abstract class Converter implements ConverterInterface
{
    protected $dispatcher;
    protected $parser;

    public function convert()
    {
        $this->loadContents();
        $this->parseContents();
        $this->decorateContents();
        $this->assembleBook();
    }

    public final function parseContents()
    {
        $event = new ParseEvent($this->app);
        $this->dispatcher->dispatch(Events::PRE_PARSE, $event);

        $this->doParsing();

        $event = new ParseEvent($this->app);
        $this->dispatcher->dispatch(Events::PRE_PARSE, $event);
    }

    protected function doParsing();

    public function setParser(ParserInterface $parser)
    {
        $this->parser = $parser;
    }
}
<?php

namespace Mexoboy\SubRip\Reader;

use Mexoboy\SubRip\Exception\ReaderException;
use Mexoboy\SubRip\Record;
use Traversable;

class StreamReader implements \IteratorAggregate
{
    /**
     * @var resource
     */
    protected $handler;

    /**
     * @var bool
     */
    protected $strict;

    public function __construct(string $srtPath, bool $strict = true)
    {
        if (!is_file($srtPath)) {
            throw new ReaderException("Source file '{$srtPath}' not exist");
        }

        if (false === ($this->handler = fopen($srtPath, 'r'))) {
            throw new ReaderException("Can't open source file '{$srtPath}'");
        }

        $this->strict = $strict;
    }

    public function getIterator(): Traversable
    {
        $buffer = '';

        while (false !== ($line = fgets($this->handler))) {
            if ($line !== "\r\n") {
                $buffer .= $line;
            } else {
                yield Record::create($buffer, $this->strict);

                $buffer = '';
            }
        }
    }
}
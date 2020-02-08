<?php

namespace Mexoboy\SubRip\Reader;

use Mexoboy\SubRip\Record;
use Traversable;

class StringReader implements \IteratorAggregate
{
    /**
     * @var string
     */
    protected $data;

    /**
     * @var bool
     */
    protected $strict;

    public function __construct(string $data, bool $strict = true)
    {
        $this->data = $data;
        $this->strict = $strict;
    }

    public function getIterator(): Traversable
    {
        foreach (explode("\r\n\r\n", trim($this->data)) as $recordData) {
            yield Record::create($recordData, $this->strict);
        }
    }
}
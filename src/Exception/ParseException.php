<?php

namespace Mexoboy\SubRip\Exception;

use Mexoboy\SubRip\Exception;

class ParseException extends Exception
{
    /**
     * @var string
     */
    protected $data;

    public function __construct($message = '', string $data = null)
    {
        parent::__construct($message);

        $this->data = $data;
    }

    public function getData(): ?string
    {
        return $this->data;
    }
}
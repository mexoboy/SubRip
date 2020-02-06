<?php

namespace Mexoboy\SubRip;

use Mexoboy\SubRip\Exception\ParseException;

class Record
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Time
     */
    protected $start;

    /**
     * @var Time
     */
    protected $end;

    /**
     * @var string
     */
    protected $content;

    public function __construct(int $id, Time $start, Time $end, string $content)
    {
        $this->id = $id;
        $this->start = $start;
        $this->end = $end;
        $this->content = $content;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getStart(): Time
    {
        return $this->start;
    }

    public function setStart(Time $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): Time
    {
        return $this->end;
    }

    public function setEnd(Time $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = trim($content);

        return $this;
    }

    public static function create(string $data, bool $strict = true): self
    {
        if ($strict) {
            $pattern = '/^\s*(\d+)\s+(\d{2}:\d{2}:\d{2},\d{3}) --> (\d{2}:\d{2}:\d{2},\d{3})\s+(.*)$/sm';
        } else {
            $pattern = '/^\s*(\d+)\s+(\d+:\d+:\d+,\d+) --> (\d+:\d+:\d+,\d+)\s+(.*)$/sm';
        }

        if (!preg_match($pattern, $data, $matches)) {
            throw new ParseException('Invalid record data', $data);
        }

        return new self(
            (int) $matches[1],
            Time::create($matches[2], $strict),
            Time::create($matches[3], $strict),
            trim($matches[4])
        );
    }

    public function __toString()
    {
        return <<<DATA
{$this->id}
{$this->start} --> {$this->end}
{$this->content}

DATA;
    }
}
<?php

namespace Mexoboy\SubRip;

use Mexoboy\SubRip\Exception\ParseException;
use Mexoboy\SubRip\Exception\InvalidArgumentException;

final class Time
{
    /**
     * @var int
     */
    private $hours;

    /**
     * @var int
     */
    private $minutes;

    /**
     * @var int
     */
    private $seconds;

    /**
     * @var int
     */
    private $milliseconds;

    public function __construct(int $hours = 0, int $minutes = 0, int $seconds = 0, int $milliseconds = 0)
    {
        $this
            ->setHours($hours)
            ->setMinutes($minutes)
            ->setSeconds($seconds)
            ->setMilliseconds($milliseconds);
    }

    /**
     * @return int
     */
    public function getHours(): int
    {
        return $this->hours;
    }

    public function setHours(int $hours): self
    {
        if ($hours > 99 || $hours < 0) {
            throw new InvalidArgumentException('Invalid hours value');
        }

        $this->hours = $hours;

        return $this;
    }

    public function getMinutes(): int
    {
        return $this->minutes;
    }

    public function setMinutes(int $minutes): self
    {
        if ($minutes > 59 || $minutes < 0) {
            throw new InvalidArgumentException('Invalid minutes value');
        }

        $this->minutes = $minutes;

        return $this;
    }

    public function getSeconds(): int
    {
        return $this->seconds;
    }

    public function setSeconds(int $seconds): self
    {
        if ($seconds > 59 || $seconds < 0) {
            throw new InvalidArgumentException('Invalid seconds value');
        }

        $this->seconds = $seconds;

        return $this;
    }

    public function getMilliseconds(): int
    {
        return $this->milliseconds;
    }

    public function setMilliseconds(int $milliseconds): self
    {
        if ($milliseconds > 999 || $milliseconds < 0) {
            throw new InvalidArgumentException('Invalid milliseconds value');
        }

        $this->milliseconds = $milliseconds;

        return $this;
    }

    public static function create(string $time, bool $strict = true): self
    {
        if ($strict) {
            $pattern = '/^(\d{2}):(\d{2}):(\d{2}),(\d{3})$/';
        } else {
            $time = trim($time);
            $pattern = '/^(\d+):(\d+):(\d+),(\d+)$/';
        }

        if (!preg_match($pattern, $time, $matches)) {
            throw new ParseException('Invalid time format', $time);
        }

        return new self((int) $matches[1], (int) $matches[2], (int) $matches[3], (int) $matches[4]);
    }

    public function __toString(): string
    {
        return sprintf(
            '%02d:%02d:%02d,%03d',
            $this->hours,
            $this->minutes,
            $this->seconds,
            $this->milliseconds
        );
    }
}
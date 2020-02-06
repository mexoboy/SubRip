<?php

namespace Mexoboy\SubRip;

use Mexoboy\SubRip\Exception\InvalidArgumentException;
use Mexoboy\SubRip\Exception\ParseException;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    public function testCreationWithValidaData()
    {
        $this->assertInstanceOf(Time::class, new Time());
    }

    public function testCreateTimeFromStringIsValid()
    {
        $time = Time::create('12:34:56,789');

        $this->assertSame(12, $time->getHours());
        $this->assertSame(34, $time->getMinutes());
        $this->assertSame(56, $time->getSeconds());
        $this->assertSame(789, $time->getMilliseconds());
    }

    public function testCreateTimeFromInvalidStringInStrictMode()
    {
        $this->expectException(ParseException::class);
        $this->expectExceptionMessage('Invalid time format');

        Time::create('1:12:39,1');
    }

    public function testCreateTimeFromInvalidStringInNonStrictMode()
    {
        $this->assertInstanceOf(Time::class, Time::create('1:12:39,1', false));
    }

    public function timeToStringProvider(): array
    {
        return [
            [new Time(), '00:00:00,000'],
            [new Time(1, 1, 1, 1), '01:01:01,001'],
            [new Time(99, 59, 59, 999), '99:59:59,999'],
        ];
    }

    /**
     * @dataProvider timeToStringProvider
     */
    public function testTimeToString(Time $time, string $expectedResult)
    {
        $this->assertSame((string) $time, $expectedResult);
    }
}
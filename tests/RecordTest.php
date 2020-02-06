<?php

namespace Mexoboy\SubRip;

use Mexoboy\SubRip\Exception\ParseException;
use PHPUnit\Framework\TestCase;

class RecordTest extends TestCase
{
    public function testCreateFromValidData(): void
    {
        $data = <<<DATA
1
00:00:00,630 --> 00:00:05,550
Hello and welcome!
DATA;
        $record = Record::create($data);

        $this->assertSame(1, $record->getId());
        $this->assertSame('00:00:00,630', (string) $record->getStart());
        $this->assertSame('00:00:05,550', (string) $record->getEnd());
        $this->assertSame('Hello and welcome!', $record->getContent());
    }

    public function testCreateFromInvalidDataWithStrictMode(): void
    {
        $data = <<<DATA
1
0:0:0,63 --> 0:0:5,55
Hello and welcome!
DATA;
        $this->expectException(ParseException::class);
        $this->expectExceptionMessage('Invalid record data');

        Record::create($data);
    }

    public function testCreateFromInvalidDataWithOutStrictMode(): void
    {
        $data = <<<DATA
1
0:0:0,63 --> 0:0:5,55
Hello and welcome!
DATA;

        $this->assertInstanceOf(Record::class, Record::create($data, false));
    }
}
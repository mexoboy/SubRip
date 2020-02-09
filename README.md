# SubRip Parser

Simple library for parsing subtitles in SubRip format.

Library support 2 ways for reading file: read as stream and read from string. 
By default, all readers use strict mode, but it can be off, to avoid
errors in reading non-valid subtitles.

Example for String Reader:

```php
$stringReader = new StringReader($subRipData);

foreach ($stringReader as $record) {
    echo $record->getContent() . "\n";
}
```

Example for Stream Reader:

```php
$stringReader = new StringReader($subRipData);

foreach ($stringReader as $record) {
    echo $record->getContent() . "\n";
}
```
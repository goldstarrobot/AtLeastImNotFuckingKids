<?php
require __DIR__ . '/../src/bootstrap.php';
$cases = [
    ['I ate the last slice.', 'I ate the last slice'],
    ["I left\n the dishes overnight", 'I left the dishes overnight'],
    ['<b>I forgot to call back</b>', 'I forgot to call back'],
    ['too short', null],
    [str_repeat('a', 151), null],
    [str_repeat('é', 150), str_repeat('é', 150)],
    ["Invalid UTF-8 \xFF here", null],
    ["A null\x00 byte in this sentence", null],
    ['One. Two. Three. Four.', null],
    ['I support white power', null],
    ['I support wh1te p0wer', null],
    ['I forgot to turn off the oven', 'I forgot to turn off the oven'],
];
foreach ($cases as [$input, $expected]) {
    if (cleanConfession($input) !== $expected) {
        fwrite(STDERR, 'Failed validation case: ' . json_encode($input) . PHP_EOL);
        exit(1);
    }
}
if (confessionsPath() !== dirname(__DIR__) . '/src/../data/sins.txt') {
    throw new RuntimeException('Unexpected storage path');
}
echo count($cases) . " validation cases passed.\n";

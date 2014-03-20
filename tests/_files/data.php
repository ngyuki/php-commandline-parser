<?php
if (PHP_OS !== 'Linux')
{
    fputs(STDERR, "This script only Linux.");
    exit();
}

$lines = <<<'EOS'
a b c
"a b" c
a 'b c'
\a\ \b\\c\
\a\ \b\\c\\
"a \ \" ' z"
'a \ \\ " \' " x'z "
aa" "bb' cc'\\zz  ""  ''  aa" "bb' cc'\\zz
\"
\'
\
\\
\\\
\\\\
EOS;

$lines = explode("\n", trim($lines));
$lines = array_map('trim', $lines);
$lines = array_filter($lines, 'strlen');

$data = array();

foreach ($lines as $line)
{
    $php = escapeshellarg('echo json_encode(array_slice($argv, 1));');
    $str = `php -r $php $line`;
    $arg = json_decode($str);
    $data[$line] = array($line, $arg);
}

echo json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL;

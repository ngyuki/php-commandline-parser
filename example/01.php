<?php
require __DIR__ . '/../vendor/autoload.php';
use ngyuki\CommandLineParser\CommandLineParser;

$obj = new CommandLineParser();
var_export($obj->parse('"foo \\" bar" abc " " 123'));
/*
array (
  0 => 'foo " bar',
  1 => 'abc',
  2 => ' ',
  3 => '123',
)
*/

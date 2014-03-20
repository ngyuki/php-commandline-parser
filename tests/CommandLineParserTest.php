<?php
namespace Tests\CommandLineParser;

use ngyuki\CommandLineParser\CommandLineParser;

class CommandLineParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider parser_ok_data
     */
    function parser_ok($cmdline, $exp)
    {
        $obj = new CommandLineParser();
        $act = $obj->parse($cmdline);
        assertEquals($exp, $act);
    }

    function parser_ok_data()
    {
        $data = file_get_contents(__DIR__ . '/_files/data.json');
        return json_decode($data, true);
    }

    /**
     * @test
     * @dataProvider parser_invalid_syntax_data
     */
    function parser_invalid_syntax($cmdline, $exp)
    {
        $obj = new CommandLineParser();
        $act = $obj->parse($cmdline);
        assertEquals($exp, $act);
    }

    function parser_invalid_syntax_data()
    {
        $data = array(
            array('"', array("")),
            array('"\\', array('\\')),

            array("'", array("")),
            array("'\\", array('\\')),

            array('"\\\\ Z', array('\\ Z')),
            array("'\\\\ Z", array('\\\\ Z')),
        );

        return $data;
    }
}

<?php

namespace League\CLImate\Tests\TerminalObject\Basic;

use League\CLImate\Tests\TestBase;

class DrawTest extends TestBase
{
    /**
     * @dataProvider directorySeparatorsProvider
     */
    public function testDirectorySeparators($directorySeparator, $message)
    {
        $expected = [
            '     ( )',
            '      H',
            '      H',
            '     _H_',
            '  .-\'-.-\'-.',
            ' /         \\',
            '|           |',
            '|   .-------\'._',
            '|  / /  \'.\' \'. \\',
            '|  \\ \\ @   @ / /',
            '|   \'---------\'',
            '|    _______|',
            '|  .\'-+-+-+|',
            '|  \'.-+-+-+|',
            '|    """""" |',
            '\'-.__   __.-\'',
            '     """',
        ];

        $draw = new \League\CLImate\TerminalObject\Basic\Draw('bender');
        $draw->directory_separator = $directorySeparator;
        $this->assertEquals(
            $expected,
            $draw->result(),
            'Bender with a ' . $message . ' directory separator'
        );
    }

    public function directorySeparatorsProvider()
    {
        return [
            [
                '/',
                'forward slash'
            ],
            [
                '\\',
                'backslash'
            ],
        ];
    }
}

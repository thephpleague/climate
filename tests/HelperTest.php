<?php

require_once 'TestBase.php';

use League\CLImate\Util\Helper;

class HelperTest extends TestBase
{

    /** @test */
    public function it_can_convert_a_string_to_an_array()
    {
        $result = Helper::toArray('string');

        $this->assertSame(['string'], $result);
    }

    /** @test */
    public function it_will_leave_an_array_alone_when_trying_to_convert()
    {
        $result = Helper::toArray(['string']);

        $this->assertSame(['string'], $result);
    }

    /** @test */
    public function it_can_flatten_an_array()
    {
        $arr = [
            [
                'this',
                'that'
            ],
            [
                'other',
                'thing',
            ],
        ];

        $result = Helper::flatten($arr);

        $this->assertSame(['this', 'that', 'other', 'thing'], $result);
    }

    /** @test */
    public function it_can_convert_a_string_to_snake_case()
    {
        $result = Helper::snakeCase('redYellowBlue');

        $this->assertSame('red_yellow_blue', $result);
    }
}

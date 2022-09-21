<?php

namespace kosogroup\cli;

use php\lib\char;

class TFormatting
{
    public static function create($formatting) : TFormatting
    {
        //return $formatting;
        return new self(char::of(27) . "[" . (array(
            "_reset"        => 0,
            "bold"       => 1,
            "italic"     => 3,
            "underline"  => 4,
            "blink"      => 5,
            "inverse"    => 7,
            "hidden"     => 8,
            "gray"       => 30,
            "red"        => 31,
            "green"      => 32,
            "yellow"     => 33,
            "blue"       => 34,
            "magenta"    => 35,
            "cyan"       => 36,
            "silver"     => "0;37",
            "white"      => 37,
            "_black_bg"   => 40,
            "_red_bg"     => 41,
            "_green_bg"   => 42,
            "_yellow_bg"  => 43,
            "_blue_bg"    => 44,
            "_magenta_bg" => 45,
            "_cyan_bg"    => 46,
            "_white_bg"   => 47,
        ))[$formatting] . "m");
    }

    private $_formatting;
    function __construct(string $formatting)
    {
        $this->_formatting = $formatting;
    }
    public function get()
    {
        return $this->_formatting;
    }
}
<?php
namespace PHPParserCombinator;


class Parsers {

    public static function s($s)
    {
        return new StringParser($s);
    }

    public static function reg($reg)
    {
        return new RegexParser($reg);
    }

    public static function rep(ParserInterface $p, array $option = array())
    {
        return new RepetitionParser($p, $option);
    }

    public static function repN($n, ParserInterface $p, array $option = array())
    {
        $option_times = array('times' => $n);
        $option = array_merge($option_times, $option);
        return new RepetitionParser($p, $option);
    }

}
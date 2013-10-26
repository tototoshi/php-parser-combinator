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

}
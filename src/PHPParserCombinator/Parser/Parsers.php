<?php
namespace PHPParserCombinator\Parser;


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

    public static function repsep(ParserInterface $p, ParserInterface $sep, array $option = array())
    {
        return $p
            ->next(
                Parsers::rep(
                    $sep->next($p)
                        ->setTransformer(function ($result) {
                            return $result[1];
                        })))
            ->setTransformer(function ($result) {
                return array_merge(array($result[0]), $result[1]);
            });
    }

}
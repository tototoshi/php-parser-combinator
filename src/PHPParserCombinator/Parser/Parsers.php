<?php
namespace PHPParserCombinator\Parser;


use PHPParserCombinator\Transformer\Transformer;

class Parsers {

    public static function s($s)
    {
        return new StringParser($s);
    }

    public static function opt(ParserInterface $p) {
        return new OptionParser($p);
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
                        ->setTransformer(Transformer::second())
                )
            )
            ->setTransformer(function ($result) {
                return array(array_merge(array($result[0]), $result[1]));
            });
    }

    public static function between(ParserInterface $begin, ParserInterface $p, ParserInterface $end)
    {
        return $begin->next($p)->next($end)->setTransformer(Transformer::second());
    }

}
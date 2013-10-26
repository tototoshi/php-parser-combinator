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

    public static function repsep(ParserInterface $p, ParserInterface $separator, array $option = array())
    {
        $option_skipWhitespace = array('skipWhitespace' => true);
        $option = array_merge($option_skipWhitespace, $option);
        $skipWhitespace = $option['skipWhitespace'];

        $p->setSkipWhitespace($skipWhitespace);
        $separator->setSkipWhitespace($skipWhitespace)->setIgnoreResult(true);

        $p2 = $separator->next($p)->setSkipWhitespace(false);
        return $p->next(self::rep($p2)->setSkipWhitespace($skipWhitespace))
            ->setSkipWhitespace($skipWhitespace)
            ->setTransformer(function ($before) {
                return array(array_merge(array($before[0]), $before[1]));
            });
    }

}
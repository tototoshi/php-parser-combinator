<?php
namespace PHPParserCombinator\Parser;


use PHPParserCombinator\Transformer\Transformer;

class Parsers {

    public static function withParserSetting(array $setting, callable $callable)
    {
        if (isset($setting['skipWhitespace'])) {
            $skip_whitespace = $setting['skipWhitespace'];
        } else {
            $skip_whitespace = true;
        }

        $previous = ParserSetting::$SKIP_WHITESPACE;

        ParserSetting::$SKIP_WHITESPACE = $skip_whitespace;

        $callable();

        ParserSetting::$SKIP_WHITESPACE = $previous;
    }

    /**
     * @param string $s
     * @return StringParser
     */
    public static function s($s)
    {
        return new StringParser($s);
    }

    /**
     * @param ParserInterface $p
     * @return OptionParser
     */
    public static function opt(ParserInterface $p)
    {
        return new OptionParser($p);
    }

    /**
     * @param ParserInterface $p
     * @return NotParser
     */
    public static function not(ParserInterface $p)
    {
        return new NotParser($p);
    }

    /**
     * @param string $reg regular expression
     * @return RegexParser
     */
    public static function reg($reg)
    {
        return new RegexParser($reg);
    }

    /**
     * @param ParserInterface $p
     * @param array $option
     * @return RepetitionParser
     */
    public static function rep(ParserInterface $p, array $option = array())
    {
        return new RepetitionParser($p, $option);
    }

    /**
     * @param $n
     * @param ParserInterface $p
     * @param array $option
     * @return RepetitionParser
     */
    public static function repN($n, ParserInterface $p, array $option = array())
    {
        $option_times = array('times' => $n);
        $option = array_merge($option_times, $option);
        return new RepetitionParser($p, $option);
    }

    /**
     * @param ParserInterface $p
     * @param ParserInterface $sep
     * @param array $option
     * @return ParserInterface
     */
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

    /**
     * @param ParserInterface $begin
     * @param ParserInterface $p
     * @param ParserInterface $end
     * @return ParserInterface
     */
    public static function between(ParserInterface $begin, ParserInterface $p, ParserInterface $end)
    {
        return $begin->next($p)->next($end)->setTransformer(Transformer::second());
    }

}
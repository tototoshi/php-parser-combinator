<?php
namespace PHPParserCombinator\Parser;


use PHPParserCombinator\Transformer\Transformer;

class Parser {

    /**
     * @param array $setting
     * @param callable $callable
     */
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
     * A parser generator for string
     *
     * @param string $s
     * @return StringParser
     */
    public static function s($s)
    {
        return new StringParser($s);
    }

    /**
     * A parser generator for optional sub-phrases
     *
     * @param ParserInterface $p
     * @return OptionParser
     */
    public static function opt(ParserInterface $p)
    {
        return new OptionParser($p);
    }

    /**
     * Wrap a parser so that its failures and errors become success and vice versa -- it never consumes any input.
     *
     * @param ParserInterface $p
     * @return NotParser
     */
    public static function not(ParserInterface $p)
    {
        return new NotParser($p);
    }

    /**
     * A parser generator for regular expression.
     *
     * @param string $reg regular expression
     * @return RegexParser
     */
    public static function reg($reg)
    {
        return new RegexParser($reg);
    }

    /**
     * A parser generator for repetitions.
     *
     * @param ParserInterface $p
     * @return RepetitionParser
     */
    public static function rep(ParserInterface $p)
    {
        return new RepetitionParser($p);
    }

    /**
     * A parser generator for non-empty repetitions.
     *
     * @param ParserInterface $p
     * @return ParserInterface
     */
    public static function rep1(ParserInterface $p)
    {
        return $p->next(new RepetitionParser($p))->setTransformer(function($value) {
            list($x, $y) = $value;
            return array(array_merge(array($x), $y));
        });
    }

    /**
     * A parser generator for a specified number of repetitions.
     *
     * @param $n
     * @param ParserInterface $p
     * @return RepetitionParser
     */
    public static function repN($n, ParserInterface $p)
    {
        $option = array('times' => $n);
        return new RepetitionParser($p, $option);
    }

    /**
     * A parser generator for interleaved repetitions.
     *
     * @param ParserInterface $p
     * @param ParserInterface $sep
     * @return ParserInterface
     */
    public static function repsep(ParserInterface $p, ParserInterface $sep)
    {
        $e = new EmptyParser();
        $e->setTransformer(function($value) {
            return array($value);
        });
        return self::rep1sep($p, $sep)->orElse($e);
    }

    /**
     * A parser generator for non-empty interleaved repetitions.
     *
     * @param ParserInterface $p
     * @param ParserInterface $sep
     * @return ParserInterface
     */
    public static function rep1sep(ParserInterface $p, ParserInterface $sep)
    {
        return $p
            ->next(
                Parser::rep(
                    $sep->next($p)
                        ->setTransformer(Transformer::second())
                )
            )
            ->setTransformer(function ($result) {
                return array(array_merge(array($result[0]), $result[1]));
            });
    }

    /**
     * A wrapper for a parser between parsers.
     *
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
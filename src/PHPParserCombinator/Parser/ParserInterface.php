<?php
namespace PHPParserCombinator\Parser;


interface ParserInterface {

    /**
     * @param string $input
     * @return Result
     */
    function parse($input);

    /**
     * @param ParserInterface $input
     * @return ParserInterface
     */
    function next(ParserInterface $input);

    /**
     * @param callable $transformer
     * @return ParserInterface
     */
    function setTransformer(Callable $transformer);

    /**
     * @param bool $skipWhitespace
     * @return ParserInterface
     */
    function setSkipWhitespace($skipWhitespace);

}
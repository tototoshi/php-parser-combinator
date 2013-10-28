<?php
namespace PHPParserCombinator\Parser;


interface ParserInterface {

    /**
     * @param string $input
     * @return \PHPParserCombinator\Result\ParseResult
     */
    function parse($input);

    /**
     * @param ParserInterface $input
     * @return ParserInterface
     */
    function next(ParserInterface $input);

    /**
     * @param ParserInterface $input
     * @return ParserInterface
     */
    function orElse(ParserInterface $input);

    /**
     * @param callable $transformer
     * @return ParserInterface
     */
    function setTransformer(callable $transformer);

}
<?php
namespace PHPParserCombinator;


interface ParserInterface {

    /**
     * @param string $input
     * @return Result
     */
    function parse($input);

}
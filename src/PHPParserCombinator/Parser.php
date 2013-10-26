<?php

namespace PHPParserCombinator;


abstract class Parser {

    abstract public function parse($input);

    public function next($parser, array $option = array())
    {
        return new SequenceParser($this, $parser, $option);
    }

    public function orElse($parser)
    {
        return new DisjunctiveParser($this, $parser);
    }

}
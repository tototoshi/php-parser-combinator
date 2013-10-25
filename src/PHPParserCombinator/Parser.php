<?php

namespace PHPParserCombinator;


abstract class Parser {

    abstract public function parse($input);

    public function next($parser)
    {
        return new SequenceParser($this, $parser);
    }

    public function orElse($parser)
    {
        return new DisjunctiveParser($this, $parser);
    }

}
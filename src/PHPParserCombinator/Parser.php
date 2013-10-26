<?php

namespace PHPParserCombinator;


abstract class Parser {

    abstract public function parse($input);

    public function next(ParserInterface $parser, array $option = array())
    {
        return new SequenceParser($this, $parser, $option);
    }

    public function orElse(ParserInterface $parser)
    {
        return new DisjunctiveParser($this, $parser);
    }

}
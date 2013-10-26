<?php

namespace PHPParserCombinator\Parser;


use PHPParserCombinator\Transformer\Transformer;

abstract class Parser {

    protected $skipWhitespace = true;

    protected $transformer;

    /**
     * @param callable $transformer
     * @return $this
     */
    public function setTransformer(Callable $transformer)
    {
        $this->transformer = $transformer;
        return $this;
    }

    public function getTransformer()
    {
        if ($this->transformer === null) {
            return Transformer::asIs();
        } else {
            return $this->transformer;
        }
    }

    /**
     * @param boolean $skipWhitespace
     */
    public function setSkipWhitespace($skipWhitespace)
    {
        $this->skipWhitespace = $skipWhitespace;
        return $this;
    }

    protected function ltrimWhitespace($input)
    {
        if ($this->skipWhitespace) {
            return ltrim($input);
        } else {
            return $input;
        }
    }

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
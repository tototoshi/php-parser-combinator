<?php

namespace PHPParserCombinator\Parser;


use PHPParserCombinator\Transformer\Transformer;

abstract class AbstractParser {

    protected $transformer;

    /**
     * @param callable $transformer
     * @return $this
     */
    public function setTransformer(callable $transformer)
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

    protected function ltrimWhitespace($input)
    {
        if (ParserSetting::$SKIP_WHITESPACE) {
            return ltrim($input);
        } else {
            return $input;
        }
    }

    abstract public function parse($input);

    public function next(ParserInterface $parser)
    {
        return new SequenceParser($this, $parser);
    }

    public function orElse(ParserInterface $parser)
    {
        return new DisjunctiveParser($this, $parser);
    }

}
<?php
namespace PHPParserCombinator;


class StringParser extends Parser implements ParserInterface
{

    private $value;

    public function __construct($value, Callable $transformer = null)
    {
        $this->value = $value;
        if ($transformer === null) {
            $this->transformer = Transformer::asIs();
        } else {
            $this->transformer = $transformer;
        }
    }

    public function parse($input)
    {
        if (strpos($input, $this->value) === 0) {
            $transformer = $this->getTransformer();
            if ($this->ignoreResult) {
                $value = array();
            } else {
                $value = array($transformer($this->value));
            }
            return new Success($value, substr($input, strlen($this->value)));
        } else {
            $expected = $this->value;
            $actual = substr($input, 0, strlen($this->value));
            return new Failure("$expected is expected but $actual found.", $input);
        }
    }
}

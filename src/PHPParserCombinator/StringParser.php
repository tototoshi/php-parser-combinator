<?php
namespace PHPParserCombinator;


class StringParser extends Parser implements ParserInterface
{

    private $value;

    private $callback;

    public function __construct($value, Callable $callback = null)
    {
        $this->value = $value;
        if ($callback === null) {
            $this->callback = Transformer::asIs();
        } else {
            $this->callback = $callback;
        }
    }

    public function parse($input)
    {
        if (strpos($input, $this->value) === 0) {
            $transformer = $this->callback;
            return new Success($transformer($this->value), substr($input, strlen($this->value)));
        } else {
            $expected = $this->value;
            $actual = substr($input, 0, strlen($this->value));
            return new Failure("$expected is expected but $actual found.", $input);
        }
    }
}

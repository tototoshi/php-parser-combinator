<?php
namespace PHPParserCombinator\Result;

class ParsedValue {

    private $value;

    public function __construct($value)
    {
        $this->value = array($value);
    }

    public function append(ParsedValue $value)
    {
        $this->value = array_merge($this->value, $value->get());
        return $this;
    }

    public function get()
    {
        return $this->value;
    }

}
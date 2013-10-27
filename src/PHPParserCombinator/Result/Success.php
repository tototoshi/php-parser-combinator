<?php
namespace PHPParserCombinator\Result;


class Success extends ParseResult {

    /**
     * @var ParsedValue $value
     */
    private $value;

    private $rest;

    public function __construct($value, $rest)
    {
        $this->value = $value;
        $this->rest = $rest;
    }

    public function isSuccess()
    {
        return true;
    }

    public function getParsedValue()
    {
        return $this->value;
    }

    public function get()
    {
        return $this->value->get();
    }

    public function getRest()
    {
        return $this->rest;
    }

}
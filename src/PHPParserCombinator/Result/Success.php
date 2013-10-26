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
        $parsed_value = $this->value->get();
        if (count($parsed_value) === 1) {
            return $parsed_value[0];
        } else {
            return $parsed_value;
        }
    }

    public function getRest()
    {
        return $this->rest;
    }

}
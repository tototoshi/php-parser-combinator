<?php
namespace PHPParserCombinator\Result;


class Success extends Result {

    private $value;

    private $rest;

    public function isSuccess()
    {
        return true;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getRest()
    {
        return $this->rest;
    }

    public function __construct($value, $rest)
    {
        $this->value = $value;
        $this->rest = $rest;
    }

}
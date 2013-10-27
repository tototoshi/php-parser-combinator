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

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return true;
    }

    /**
     * To library user: Don't use this method.
     * This method is intended to be used for internal purpose.
     *
     * @return ParsedValue
     */
    public function getParsedValue()
    {
        return $this->value;
    }

    /**
     * @return array Parsed result
     */
    public function get()
    {
        return $this->value->get();
    }

    /**
     * The rest of input
     *
     * @return string
     */
    public function getRest()
    {
        return $this->rest;
    }

}
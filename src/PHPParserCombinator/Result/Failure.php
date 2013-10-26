<?php
namespace PHPParserCombinator\Result;


use PHPParserCombinator\Exception\UnsuppotedOperationException;

class Failure extends ParseResult
{
    private $message;

    private $rest;

    public function isSuccess()
    {
        return false;
    }

    /**
     * @return string Rest of the input
     */
    public function getRest()
    {
        return $this->rest;
    }

    public function __construct($msg, $rest)
    {
        $this->message = $msg;
        $this->rest = $rest;
    }

    function __toString()
    {
        return 'Failure[msg=' . $this->message . ', rest=' . $this->rest .']';
    }

    public function get()
    {
        throw new UnsuppotedOperationException();
    }

    public function getMessage()
    {
        return $this->message;
    }

}
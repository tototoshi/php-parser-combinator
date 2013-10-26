<?php
namespace PHPParserCombinator;


use PHPParserCombinator\Exception\UnsuppotedOperationException;

class Failure extends Result
{
    private $msg;

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
        $this->msg = $msg;
        $this->rest = $rest;
    }

    function __toString()
    {
        return 'Failure[msg=' . $this->msg . ', rest=' . $this->rest .']';
    }

    public function getValue()
    {
        throw new UnsuppotedOperationException();
    }

}
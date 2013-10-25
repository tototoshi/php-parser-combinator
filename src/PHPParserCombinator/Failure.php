<?php
namespace PHPParserCombinator;


class Failure extends Result
{
    private $msg;

    public function isSuccess()
    {
        return false;
    }

    public function __construct($msg)
    {
        $this->msg = $msg;
    }
}
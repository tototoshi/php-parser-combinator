<?php
namespace PHPParserCombinator\Collection;

class Some extends Option {

    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function get()
    {
        return $this->value;
    }

}
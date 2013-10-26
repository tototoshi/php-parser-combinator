<?php
namespace PHPParserCombinator\Collection;

use PHPParserCombinator\Exception\NoSuchElementException;

class None extends Option {

    public function __construct()
    {
    }

    public function get()
    {
        throw new NoSuchElementException();
    }

}
<?php

namespace PHPParserCombinator\Result;


abstract class ParseResult {

    abstract public function isSuccess();

    abstract public function getRest();

    abstract public function get();

}
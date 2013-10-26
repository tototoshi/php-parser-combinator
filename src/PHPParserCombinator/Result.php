<?php

namespace PHPParserCombinator;


abstract class Result {

    abstract public function isSuccess();

    abstract public function getRest();

    abstract public function getValue();

}
<?php

namespace PHPParserCombinator\Transformer;


class Transformer
{
    public static function ignore() {
        return function ($value) {
            return null;
        };
    }

    public static function asIs() {
        return function ($value) {
            return $value;
        };
    }
}
<?php

namespace PHPParserCombinator\Transformer;

class Transformer
{
    public static function ignore()
    {
        return function ($value) {
            return null;
        };
    }

    public static function asIs()
    {
        return function ($value) {
            return $value;
        };
    }

    public static function first()
    {
        return function($xs) {
            return $xs[0];
        };
    }

    public static function second()
    {
        return function($xs) {
            return $xs[1];
        };
    }

    public static function third()
    {
        return function($xs) {
            return $xs[2];
        };
    }
}
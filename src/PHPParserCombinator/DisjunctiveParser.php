<?php
namespace PHPParserCombinator;


class DisjunctiveParser extends Parser implements ParserInterface {

    private $left;

    private $right;

    public function __construct(ParserInterface $left, ParserInterface $right)
    {
        $this->left = $left;
        $this->right = $right;
    }

    public function parse($input)
    {
        $res_left = $this->left->parse($input);
        if ($res_left->isSuccess()) {
            return $res_left;
        } else {
            $res_right = $this->right->parse($input);
            if ($res_right->isSuccess()) {
                return
                    new Success(
                        $res_right->getValue(),
                        $res_right->getRest()
                    );
            } else {
                return $res_right;
            }
        }
    }
}

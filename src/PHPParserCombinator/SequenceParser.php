<?php
namespace PHPParserCombinator;


class SequenceParser extends Parser
{
    private $left;

    private $right;

    private $append;

    public function __construct($left, $right, $append = false)
    {
        $this->left = $left;
        $this->right = $right;
        $this->append = $append;
    }

    public function next($parser)
    {
        return new SequenceParser($this, $parser, $append = true);
    }

    public function parse($input)
    {
        $res_left = $this->left->parse($input);
        if ($res_left->isSuccess()) {
            $res_right = $this->right->parse($res_left->getRest());
            if ($res_right->isSuccess()) {
                if ($this->append) {
                    $value = $res_left->getValue();
                    $value[] = $res_right->getValue();
                } else {
                    $value = array($res_left->getValue(), $res_right->getValue());
                }

                return
                    new Success(
                        $value,
                        $res_right->getRest()
                    );
            } else {
                return $res_right;
            }
        } else {
            return $res_left;
        }
    }
}

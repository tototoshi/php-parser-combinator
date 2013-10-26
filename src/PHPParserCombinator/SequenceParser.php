<?php
namespace PHPParserCombinator;


class SequenceParser extends Parser
{
    /**
     * @var Parser $left
     */
    private $left;

    /**
     * @var Parser $right
     */
    private $right;

    /**
     * @var bool $skipWhitespace
     */
    private $skipWhitespace;

    public function __construct($left, $right, array $option = array())
    {
        $option_default = array(
            'skipWhitespace' => true
        );
        $option = array_merge($option_default, $option);

        $this->skipWhitespace = $option['skipWhitespace'];

        $this->left = $left;
        $this->right = $right;
    }

    public function parse($input)
    {
        /*
         * if $skipWhitespace is true, trim whitespaces
         */
        if ($this->skipWhitespace) {
            $input = ltrim($input);
        }

        $res_left = $this->left->parse($input);
        if ($res_left->isSuccess()) {

            /*
             * Get rest of the input.
             * if $skipWhitespace is true, trim whitespaces
             */
            $rest = $res_left->getRest();
            if ($this->skipWhitespace) {
                $rest = ltrim($rest);
            }

            $res_right = $this->right->parse($rest);
            if ($res_right->isSuccess()) {
                $value = array_merge($res_left->getValue(), $res_right->getValue());
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

<?php
namespace PHPParserCombinator\Parser;


use PHPParserCombinator\Result\ParsedValue;
use PHPParserCombinator\Result\Success;

class SequenceParser extends Parser implements ParserInterface
{
    /**
     * @var ParserInterface $left
     */
    private $left;

    /**
     * @var ParserInterface $right
     */
    private $right;


    public function __construct(ParserInterface $left, ParserInterface $right, array $option = array())
    {
        $option_default = array(
            'ignoreResult' => false,
            'skipWhitespace' => true
        );
        $option = array_merge($option_default, $option);

        $this->skipWhitespace = $option['skipWhitespace'];
        $this->ignoreResult = $option['ignoreResult'];

        $this->left = $left;
        $this->right = $right;
    }

    public function parse($input)
    {
        $input = $this->ltrimWhitespace($input);

        $res_left = $this->left->parse($input);
        if ($res_left->isSuccess()) {
            $rest = $res_left->getRest();
            $rest = $this->ltrimWhitespace($rest);
            $res_right = $this->right->parse($rest);
            if ($res_right->isSuccess()) {
                $transformer = $this->getTransformer();
                $value = $res_left->getParsedValue()->append(new ParsedValue($res_right->get()));
                return new Success($transformer($value), $res_right->getRest());
            } else {
                return $res_right;
            }
        } else {
            return $res_left;
        }
    }
}

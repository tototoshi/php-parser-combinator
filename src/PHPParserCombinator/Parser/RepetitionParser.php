<?php
namespace PHPParserCombinator\Parser;


use PHPParserCombinator\Result\ParsedValue;
use PHPParserCombinator\Result\Success;

class RepetitionParser extends Parser implements ParserInterface {

    private $parser;

    private $times;

    public function __construct(ParserInterface $parser, array $option = array())
    {
        $option_default = array(
            'skipWhitespace' => true,
            'times' => -1
        );
        $option = array_merge($option_default, $option);
        $this->skipWhitespace = $option['skipWhitespace'];
        $this->times = $option['times'];

        $this->parser = $parser;
    }

    public function parse($input, array $option = array())
    {
        $result_values = array();

        $transformer = $this->getTransformer();

        while (true) {
            if ($this->times === 0) break;

            $input = $this->ltrimWhitespace($input);

            $result = $this->parser->parse($input);

            if ($this->times > 0) $this->times--;

            if (!$result->isSuccess()) {
                if ($this->times === -1) {
                    break;
                } else {
                    return $result;
                }
            }

            array_push($result_values, $transformer($result->get()));
            $input = $result->getRest();
        }

        return new Success(new ParsedValue($result_values), $input);
    }

}
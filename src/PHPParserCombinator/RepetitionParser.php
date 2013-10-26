<?php
namespace PHPParserCombinator;


class RepetitionParser extends Parser implements ParserInterface {

    private $parser;

    private $skipWhitespace;

    public function __construct(ParserInterface $parser, array $option = array())
    {
        $option_default = array(
            'skipWhitespace' => true
        );
        $option = array_merge($option_default, $option);
        $this->skipWhitespace = $option['skipWhitespace'];

        $this->parser = $parser;
    }

    public function parse($input, array $option = array())
    {
        $result_values = array();
        while (true) {
            if ($this->skipWhitespace) {
                $input = ltrim($input);
            }

            $result = $this->parser->parse($input);

            if (!$result->isSuccess()) break;

            $result_values = array_merge($result_values, $result->getValue());
            $input = $result->getRest();
        }

        return new Success(array($result_values), $input);
    }

}
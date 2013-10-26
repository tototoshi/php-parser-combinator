<?php
namespace PHPParserCombinator;


class RepetitionParser extends Parser implements ParserInterface {

    private $parser;

    private $skipWhitespace;

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

        while (true) {
            if ($this->times === 0) break;

            if ($this->skipWhitespace) {
                $input = ltrim($input);
            }

            $result = $this->parser->parse($input);

            if ($this->times > 0) $this->times--;

            if (!$result->isSuccess()) {
                if ($this->times === -1) {
                    break;
                } else {
                    return $result;
                }
            }

            $result_values = array_merge($result_values, $result->getValue());
            $input = $result->getRest();
        }

        return new Success(array($result_values), $input);
    }

}
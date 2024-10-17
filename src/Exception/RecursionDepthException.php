<?php

namespace Yomeva\OpenAiBundle\Exception;

class RecursionDepthException extends \RuntimeException
{
    public function __construct(
        string      $message = "Function reached maximum depth of recursion.",
        int         $code = 0,
        ?\Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}
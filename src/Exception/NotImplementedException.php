<?php

namespace Yomeva\OpenAiBundle\Exception;

class NotImplementedException extends \RuntimeException
{
    public function __construct(
        string      $message = "This call is not implemented yet.",
        int         $code = 0,
        ?\Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
    }
}
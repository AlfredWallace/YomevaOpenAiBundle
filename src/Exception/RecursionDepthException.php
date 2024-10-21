<?php

namespace Yomeva\OpenAiBundle\Exception;

class RecursionDepthException extends \RuntimeException
{
    public const int MAX_DEPTH = 100;

    public function __construct(
        int $maxDepth = self::MAX_DEPTH,
        string $message = "Function reached maximum depth of recursion.",
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
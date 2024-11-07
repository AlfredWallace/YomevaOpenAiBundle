<?php

namespace Yomeva\OpenAiBundle\Exception;

class CheckStagingEnvException extends \RuntimeException
{
    public const string STAGING_ASSISTANT_NAME = 'this-assistant-MUST-only-exists-in-staging-env';

    public function __construct(
        string $message = "Tests cancelled. You may not be in testing environment. Staging env must start with only one assistant with the name ".self::STAGING_ASSISTANT_NAME,
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
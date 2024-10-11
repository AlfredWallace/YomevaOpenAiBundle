<?php

namespace Yomeva\OpenAiBundle\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class FileSearchResources extends Constraint
{
    public string $message = "Only one of vectorStoreIds or vectorStores should be provided.";

    public function __construct(?array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);
    }

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
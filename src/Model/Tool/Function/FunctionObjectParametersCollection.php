<?php

namespace Yomeva\OpenAiBundle\Model\Tool\Function;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Validator\StringIndexedArray;

#[Assert\Cascade]
class FunctionObjectParametersCollection
{
    public function __construct(
        #[StringIndexedArray]
        #[Assert\All([
            new Assert\Type(FunctionObjectParameter::class),
            new Assert\NotBlank(),
        ])]
        public ?array $parameters = null,

        // TODO
        public ?array $required = null,
    ) {
    }

    public function getType(): string
    {
        return 'object';
    }
}
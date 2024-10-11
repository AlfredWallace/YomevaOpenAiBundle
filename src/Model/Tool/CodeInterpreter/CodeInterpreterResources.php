<?php

namespace Yomeva\OpenAiBundle\Model\Tool\CodeInterpreter;

use Symfony\Component\Validator\Constraints as Assert;

class CodeInterpreterResources
{
    public function __construct(

        #[Assert\Count(max: 20)]
        #[Assert\All(
            [
                new Assert\Type('string'),
                new Assert\NotBlank(),
            ]
        )]
        public array $fileIds = []
    ) {
    }
}
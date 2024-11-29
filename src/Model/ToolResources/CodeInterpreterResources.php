<?php

namespace Yomeva\OpenAiBundle\Model\ToolResources;

use Symfony\Component\Validator\Constraints as Assert;

class CodeInterpreterResources
{
    /**
     * @param string[]|null $fileIds
     */
    public function __construct(

        #[Assert\Count(max: 20)]
        #[Assert\All(
            [
                new Assert\Type('string'),
                new Assert\NotBlank(),
            ]
        )]
        public ?array $fileIds = null
    ) {
    }
}
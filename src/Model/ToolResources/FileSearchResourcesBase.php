<?php

namespace Yomeva\OpenAiBundle\Model\ToolResources;

use Symfony\Component\Validator\Constraints as Assert;

#[Assert\Cascade]
abstract class FileSearchResourcesBase
{
    /**
     * @param string[]|null $vectorStoreIds
     */
    public function __construct(

        #[Assert\Count(max: 1)]
        #[Assert\All(
            [
                new Assert\Type('string'),
                new Assert\NotBlank(),
            ]
        )]
        public ?array $vectorStoreIds = null,
    ) {
    }

}
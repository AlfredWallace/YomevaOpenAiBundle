<?php

namespace Yomeva\OpenAiBundle\Model\ToolResources;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Validator\FileSearchResources as FileSearchResourcesConstraint;

#[Assert\Cascade]
#[FileSearchResourcesConstraint]
class FileSearchResources
{
    public function __construct(

        #[Assert\Count(max: 1)]
        #[Assert\All(
            [
                new Assert\Type('string'),
                new Assert\NotBlank(),
            ]
        )]
        public ?array $vectorStoreIds = null,

        #[Assert\Count(max: 1)]
        #[Assert\All(
            [
                new Assert\Type(FileSearchResourcesVectorStore::class),
                new Assert\NotBlank()
            ]
        )]
        public ?array $vectorStores = null
    ) {
    }
}
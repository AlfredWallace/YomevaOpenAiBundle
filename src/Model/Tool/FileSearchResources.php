<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

use Symfony\Component\Validator\Constraints as Assert;

#[Assert\Cascade]
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
        public array $vectorStoreIds = [],

        #[Assert\Count(max: 1)]
        #[Assert\All(
            [
                new Assert\Type(FileSearchResourcesVectorStore::class),
                new Assert\NotBlank()
            ]
        )]
        public array $vectorStores = []
    ) {
    }
}
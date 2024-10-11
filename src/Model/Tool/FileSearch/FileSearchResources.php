<?php

namespace Yomeva\OpenAiBundle\Model\Tool\FileSearch;

use Symfony\Component\Validator\Constraints as Assert;

#[Assert\Cascade]
#[Assert\Expression(
    "!(this.vectorStoreIds|length > 0 and this.vectorStores|length > 0)",
    message: "Only one of vectorStoreIds or vectorStores should be provided."
)]
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
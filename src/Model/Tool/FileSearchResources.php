<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

use Symfony\Component\Validator\Constraints as Assert;

class FileSearchResources
{
    public function __construct(

        #[Assert\Count(max: 1)]
        #[Assert\All([new Assert\Type('string')])]
        public array $vectorStoreIds = [],

        #[Assert\Count(max: 1)]
        #[Assert\All([new Assert\Type(FileSearchResourcesVectorStore::class)])]
        public array $vectorStores = []
    ) {
    }
}
<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

class FileSearchResources
{
    public function __construct(
        public array $vectorStoreIds = [],
        public array $vectorStores = []
    )
    {
    }
}
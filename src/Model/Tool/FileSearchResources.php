<?php

namespace Yomeva\OpenAiBundle\Model\Tool;

class FileSearchResources
{
    public function __construct(
        public array $vectorStoreIds = [],
        public array $vectorStores = []
    )
    {
    }
}
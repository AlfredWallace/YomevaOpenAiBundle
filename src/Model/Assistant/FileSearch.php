<?php

namespace Yomeva\OpenAiBundle\Model\Assistant;

class FileSearch
{
    public function __construct(
        public array $vectorStoreIds = [],
        public array $vectorStores = []
    )
    {
    }
}
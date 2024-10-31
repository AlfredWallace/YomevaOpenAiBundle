<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

use Yomeva\OpenAiBundle\Model\ToolResources\FileSearchResourcesVectorStore;

interface HasFileSearchResourcesSimpleInterface
{
    public function setFileSearchResources(array $vectorStoreIds = null): self;
}
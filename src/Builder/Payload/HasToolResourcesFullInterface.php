<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

interface HasToolResourcesFullInterface
{
    public function setCodeInterpreterToolResources(array $fieldIds): self;

    public function setFileSearchResources(array $vectorStoreIds = null, array $vectorStores = null): self;
}
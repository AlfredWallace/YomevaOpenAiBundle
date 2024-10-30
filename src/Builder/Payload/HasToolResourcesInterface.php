<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

interface HasToolResourcesInterface
{
    public function setCodeInterpreterToolResources(array $fieldIds): self;

    public function setFileSearchResources(array $vectorStoreIds = null, array $vectorStores = null): self;
}
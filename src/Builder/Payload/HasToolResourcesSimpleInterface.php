<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

interface HasToolResourcesSimpleInterface
{
    /**
     * @param string[] $fieldIds
     */
    public function setCodeInterpreterToolResources(array $fieldIds): self;

    /**
     * @param string[] $vectorStoreIds
     */
    public function setFileSearchResources(array $vectorStoreIds): self;
}
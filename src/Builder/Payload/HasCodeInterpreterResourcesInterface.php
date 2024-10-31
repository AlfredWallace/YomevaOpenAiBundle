<?php

namespace Yomeva\OpenAiBundle\Builder\Payload;

interface HasCodeInterpreterResourcesInterface
{
    /**
     * @param string[] $fieldIds
     */
    public function setCodeInterpreterToolResources(array $fieldIds): self;
}
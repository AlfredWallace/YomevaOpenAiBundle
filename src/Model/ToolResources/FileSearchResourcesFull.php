<?php

namespace Yomeva\OpenAiBundle\Model\ToolResources;

use Symfony\Component\Validator\Constraints as Assert;
use Yomeva\OpenAiBundle\Validator\FileSearchResources as FileSearchResourcesConstraint;

#[Assert\Cascade]
#[FileSearchResourcesConstraint]
class FileSearchResourcesFull extends FileSearchResourcesBase
{
    /**
     * @param string[]|null $vectorStoreIds
     * @param FileSearchResourcesVectorStore[]|null $vectorStores
     */
    public function __construct(
        ?array $vectorStoreIds = null,

        #[Assert\Count(max: 1)]
        #[Assert\All(
            [
                new Assert\Type(FileSearchResourcesVectorStore::class),
                new Assert\NotBlank()
            ]
        )]
        public ?array $vectorStores = null
    ) {
        parent::__construct($vectorStoreIds);
    }
}
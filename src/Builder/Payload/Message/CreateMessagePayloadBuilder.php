<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Message;

use Yomeva\OpenAiBundle\Builder\Payload\Tool\HasMetadataTrait;
use Yomeva\OpenAiBundle\Model\Content\Detail;
use Yomeva\OpenAiBundle\Model\Content\ImageFile;
use Yomeva\OpenAiBundle\Model\Content\ImageFileContentPart;
use Yomeva\OpenAiBundle\Model\Content\ImageUrl;
use Yomeva\OpenAiBundle\Model\Content\ImageUrlContentPart;
use Yomeva\OpenAiBundle\Model\Content\TextContentPart;
use Yomeva\OpenAiBundle\Model\Message\CreateMessagePayload;
use Yomeva\OpenAiBundle\Model\Message\Role;

class CreateMessagePayloadBuilder implements MessagePayloadBuilderInterface
{
    use HasMetadataTrait;

    private CreateMessagePayload $createMessagePayload;

    public function __construct(Role $role)
    {
        $this->createMessagePayload = new CreateMessagePayload($role, []);
    }

    public function getPayload(): CreateMessagePayload
    {
        return $this->createMessagePayload;
    }

    private function switchContentFromStringToArray(): void
    {
        if (is_string($this->createMessagePayload->content)) {
            $this->createMessagePayload->content = [
                new TextContentPart($this->createMessagePayload->content),
            ];
        }
    }

    public function addText(string $text): self
    {
        $this->switchContentFromStringToArray();
        $this->createMessagePayload->content[] = new TextContentPart($text);
        return $this;
    }

    public function addImageFile(string $fileId, ?Detail $detail = null): self
    {
        $this->switchContentFromStringToArray();
        $this->createMessagePayload->content[] = new ImageFileContentPart(new ImageFile($fileId, $detail));
        return $this;
    }

    public function addImageUrl(string $url, ?Detail $detail = null): self
    {
        $this->switchContentFromStringToArray();
        $this->createMessagePayload->content[] = new ImageUrlContentPart(new ImageUrl($url, $detail));
        return $this;
    }
}
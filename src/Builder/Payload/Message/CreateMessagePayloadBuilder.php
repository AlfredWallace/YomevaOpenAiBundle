<?php

namespace Yomeva\OpenAiBundle\Builder\Payload\Message;

use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataInterface;
use Yomeva\OpenAiBundle\Builder\Payload\HasMetadataTrait;
use Yomeva\OpenAiBundle\Builder\Payload\PayloadBuilderInterface;
use Yomeva\OpenAiBundle\Model\Attachments\Attachment;
use Yomeva\OpenAiBundle\Model\Content\Detail;
use Yomeva\OpenAiBundle\Model\Content\ImageFile;
use Yomeva\OpenAiBundle\Model\Content\ImageFileContentPart;
use Yomeva\OpenAiBundle\Model\Content\ImageUrl;
use Yomeva\OpenAiBundle\Model\Content\ImageUrlContentPart;
use Yomeva\OpenAiBundle\Model\Content\TextContentPart;
use Yomeva\OpenAiBundle\Model\Message\CreateMessagePayload;
use Yomeva\OpenAiBundle\Model\Message\Role;
use Yomeva\OpenAiBundle\Model\Tool\CodeInterpreter\CodeInterpreterTool;
use Yomeva\OpenAiBundle\Model\Tool\FileSearch\FileSearchBasicTool;

class CreateMessagePayloadBuilder implements PayloadBuilderInterface, HasMetadataInterface
{
    use HasMetadataTrait;

    private CreateMessagePayload $createMessagePayload;

    public function __construct(Role $role, ?string $content = null)
    {
        $this->createMessagePayload = new CreateMessagePayload($role, $content ?? []);
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

    public function addAttachment(string $fileId, bool $useCodeInterpreter = false, bool $useFileSearch = false): self
    {
        $attachment = new Attachment($fileId);

        if ($useCodeInterpreter) {
            $attachment->tools[] = new CodeInterpreterTool();
        }

        if ($useFileSearch) {
            $attachment->tools[] = new FileSearchBasicTool();
        }

        $this->createMessagePayload->attachments[] = $attachment;

        return $this;
    }
}
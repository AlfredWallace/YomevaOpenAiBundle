<?php

namespace Yomeva\OpenAiBundle\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

enum BackedEnumNormalizer implements NormalizerInterface
{

    public function normalize(
        mixed $object,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|\ArrayObject|null {
        return $object->value;
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof \BackedEnum;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            \BackedEnum::class => true
        ];
    }
}

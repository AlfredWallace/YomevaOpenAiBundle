<?php

namespace Yomeva\OpenAiBundle\Normalizer;

use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Yomeva\OpenAiBundle\Model\Tool\Function\FunctionObjectParametersCollection;

class FunctionObjectParametersCollectionNormalizer implements NormalizerInterface
{
    public function normalize(
        mixed $object,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|\ArrayObject|null {
        $serializer = new Serializer([
            new ObjectNormalizer(nameConverter: new CamelCaseToSnakeCaseNameConverter())
        ]);
        $normalizedObject = $serializer->normalize($object, $format, $context);
        $normalizedObject['type'] = 'object';
        $normalizedObject['additionalProperties'] = false;

        return $normalizedObject;
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof FunctionObjectParametersCollection;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            FunctionObjectParametersCollection::class => true
        ];
    }
}
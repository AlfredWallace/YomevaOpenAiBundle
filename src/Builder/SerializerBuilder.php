<?php

namespace Yomeva\OpenAiBundle\Builder;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class SerializerBuilder
{
    public function makeSerializer(): SerializerInterface
    {
        return new Serializer(
            normalizers: [
                new BackedEnumNormalizer(),
                new ObjectNormalizer(
                    nameConverter: new CamelCaseToSnakeCaseNameConverter(),
                    defaultContext: [
                        AbstractObjectNormalizer::SKIP_NULL_VALUES => true
                    ]
                )
            ],
            encoders: [new JsonEncoder()],
        );
    }
}
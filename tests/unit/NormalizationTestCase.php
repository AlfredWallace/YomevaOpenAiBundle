<?php

namespace Yomeva\OpenAiBundle\Tests\unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;
use Yomeva\OpenAiBundle\Builder\SerializerBuilder;

abstract class NormalizationTestCase extends TestCase
{
    protected static SerializerInterface $serializer;

    public static function setUpBeforeClass(): void
    {
        self::$serializer = (new SerializerBuilder())->makeSerializer();

        parent::setUpBeforeClass();
    }
}
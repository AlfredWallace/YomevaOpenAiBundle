<?php

namespace Yomeva\OpenAiBundle\Tests\integration;

use PHPUnit\Framework\TestCase;
use Yomeva\OpenAiBundle\Service\OpenAiClient;

abstract class ClientTestCase extends TestCase
{
    // todo garde fou pas la prod
    protected static OpenAiClient $client;

    public static function setUpBeforeClass(): void
    {
        // this has to be a key for an OpenAI project used for tests where all data can be deleted
        self::$client = new OpenAiClient($_ENV['OPEN_AI_API_KEY']);
        parent::setUpBeforeClass();
    }
}
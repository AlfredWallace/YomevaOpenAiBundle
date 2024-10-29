<?php

namespace Yomeva\OpenAiBundle\Tests\integration;

use PHPUnit\Framework\TestCase;
use Yomeva\OpenAiBundle\Service\OpenAiClient;

abstract class ClientTestCase extends TestCase
{
    // todo sécurité pour ne pas accidentellement taper sur la prod : vérifier via l'API OpenAI les Projects
    // todo et/ou les service-accounts et/ou les users pour savoir si on tape bien sur 'RelaSync staging'
    protected static OpenAiClient $client;

    public static function setUpBeforeClass(): void
    {
        // this has to be a key for an OpenAI project used for tests where all data can be deleted
        // having a different name than the one used in the project where you install the bundle
        // (OPEN_AI_API_TEST_KEY instead of OPEN_AI_API_KEY) is a small security enhancement to
        // reduce the chances to run tests in a prod environment
        self::$client = new OpenAiClient($_ENV['OPEN_AI_API_TEST_KEY']);
        parent::setUpBeforeClass();
    }
}
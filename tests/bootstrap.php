<?php

use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

// The bundle needs a secret: the OpenAI API key
$dotEnv = new Dotenv();
$dotEnv->load(__DIR__ . '/../.env.test');
$dotEnv->load(__DIR__ . '/../.env.test.local');
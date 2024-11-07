Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
composer require yomeva/openai-bundle
```

### Step 2: Check if the Bundle is enabled, and if not, enable it

By adding it to the list of registered bundles 
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Yomeva\OpenAiBundle\YomevaOpenAiBundle::class => ['all' => true],
];
```

### Step 3: Add a OpenAI API key env var to a config file

Define the YAML config as follows and use an environment variable


```yaml
# config/packages/yomeva_open_ai.yaml

yomeva_open_ai:
    api_key: '%env(resolve:OPEN_AI_API_KEY)%'
```

### Step 4: Add a staging project OpenAI API key to a .env.test.local file for PHPUnit (data of this OpenAI project can be lost)
```.dotenv
OPEN_AI_API_TEST_KEY=your-staging-key
```

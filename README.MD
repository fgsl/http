# Installation in a PHP project

Add a composer.json file in your project root folder with following lines:

    {
        "require": {
            "php": ">=5.6",
            "fgsl\http": "1.0.0",
    
        },
        "repositories" : [
            {
                "type" : "vcs",
                "url": "https://gitbhub.com/fgsl/http.git"
            }
        ]
}

Run command:

    composer install

For getting Composer: https://getcomposer.org/download/

# Run unit tests

phpunit --bootstrap tests/bootstrap.php tests/Fgsl/Test/TestSuite.php

# How to use

See sample below: 

```php
use Fgsl\Http\Http;

$ctx = Http::getContext('GET', null);
@$response = Http::request("http://www.on.br/index.php/pt-br/busca.html", $ctx);

$this->assertContains('Tecnologia', $response);
``` 

The variable `$ctx` receives a HTTP context, that is a resource with elements of HTTP protocol.

The variable `$response` receives HTTP response text, according context defined by `$ctx`.
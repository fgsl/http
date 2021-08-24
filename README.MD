# Installation in a PHP project

```php
composer require fgsl/http
```

Run command:

```bash
composer install
```

For getting Composer: https://getcomposer.org/download/

# Run unit tests

```bash
phpunit --bootstrap tests/bootstrap.php tests/Fgsl/Test/TestSuite.php
```

# How to use

See below a sample of method `request`.

```php
use Fgsl\Http\Http;

$ctx = Http::getContext('GET', null);
@$response = Http::request("http://www.horalegalbrasil.mct.on.br/SincronismoPublico.html", $ctx);
        
$this->assertStringContainsString('Sincronismo', $response);
``` 

The variable `$ctx` receives a HTTP context, that is a resource with elements of HTTP protocol.

The variable `$response` receives HTTP response text, according context defined by `$ctx`.

Sometimes method `request` may not work. Then you can use method `curl`.

See class `ApiTest` for more examples.


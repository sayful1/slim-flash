# Easy Flash Messages for Slim Framework 3

This repository contains a Slim Framework Flash messages service provider. This enables you to define transient messages that persist only from the current request to the next request.

## Install

Via Composer

``` bash
$ composer require sayful1/slim-flash
```

Requires Slim 3.0.0 or newer.

## Usage

```php
// Start PHP session
session_start();

$app = new \Slim\App();

// Fetch DI Container
$container = $app->getContainer();

// Register provider
$container['flash'] = function () {
    return new \Sayful\SlimFlash\Flash();
};

$app->get('/foo', function ($req, $res, $args) {
    // Set flash message for next request
    $this->flash->success('Test', 'This is a message');

    // Redirect
    return $res->withStatus(302)->withHeader('Location', '/bar');
});

$app->get('/bar', function ($req, $res, $args) {
    // Get flash messages from previous request
    $messages = $this->flash->getMessages();
    print_r($messages);

    // Get the first message
    $test = $this->flash->getFlashMessage();
    print_r($test);
});

$app->run();
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
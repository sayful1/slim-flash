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
    
    // You may also do
    $this->flash->info('Info!', 'This is info message.');
    $this->flash->warning('Warning!', 'This is warning message.');
    $this->flash->error('Title', 'This is error message.');
    
    // All method can also take on parameter
    $this->flash->success('This is message without title.');

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

Behind the scenes, this will set a few keys in the session:

- 'flash_message'
- 'flash_message_overlay'

Add flash as global variable to Twig-View. For Twig-View, see documentation on [Slim Framework Twig View](https://github.com/slimphp/Twig-View)
```php
$container['view'] = function ($c) {
    ...
    // Add flash as global variable to twig view
    $view->getEnvironment()->addGlobal( 'flash', $c->flash );
    ...
};
```

With this message flashed to the session, you may now display it in your view(s). Maybe something like with twig-view package:
```twig
{% if flash.getFlashMessage() %}
    <script type="text/javascript">
        {% if flash.getFlashMessage.message %}
        swal({
            title: "{{ flash.getFlashMessage.title }}",
            text: "{{ flash.getFlashMessage.message }}",
            icon: "{{ flash.getFlashMessage.label }}",
            button: false,
            timer: 2000
        });
        {% else %}
        swal({
            text: "{{ flash.getFlashMessage.title }}",
            icon: "{{ flash.getFlashMessage.label }}",
            button: false,
            timer: 2000
        });
        {% endif %}
    </script>
{% endif %}
```

> Note that this package is optimized for use with [sweetAlert](https://sweetalert.js.org/).

You can also implement this package with [Bootstrap](http://getbootstrap.com/)
```twig
{% if flash.getFlashMessage() %}
    {% set type = ('error' == flash.getFlashMessage.label) ? "danger" : flash.getFlashMessage.label %}
    {% if flash.getFlashMessage.message %}
        <div class="alert alert-dismissible alert-{{ type }}" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <h4 class="alert-heading">{{ flash.getFlashMessage.title }}</h4>
            <p>{{ flash.getFlashMessage.message }}</p>
        </div>
    {% else %}
        <div class="alert alert-dismissible alert-{{ type }}" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            {{ flash.getFlashMessage.title }}
        </div>
    {% endif %}
{% endif %}
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

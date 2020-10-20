# Webhooks for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/viezel/webhooks.svg?style=flat-square)](https://packagist.org/packages/viezel/webhooks)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/viezel/webhooks/run-tests?label=tests)](https://github.com/viezel/webhooks/actions?query=workflow%3Arun-tests+branch%3Amaster)

Simple and powerful implementation of Webhooks. 

## Installation

You can install the package via composer:

```bash
composer require viezel/webhooks
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Viezel\Webhooks\WebhooksServiceProvider" --tag="migrations"
php artisan migrate
```

Add routes to your application. Below is a typical route configuration with auth, api prefix and naming.

```php
Route::middleware('auth:api')->prefix('api')->as('webhooks.api.')->group(function() {
    Route::get('hooks', Viezel\Webhooks\Controllers\API\ListWebhooks::class)->name('list');
    Route::get('hooks/events', Viezel\Webhooks\Controllers\API\ListWebhookEvents::class)->name('events');
    Route::post('hooks', Viezel\Webhooks\Controllers\API\CreateWebhook::class)->name('create');
    Route::delete('hooks/{id}', Viezel\Webhooks\Controllers\API\DeleteWebhook::class)->name('delete');
});
```


## Usage

First, register Events in your application that should be exposed as Webhooks. 
To do so, your Events should implement the `ShouldDeliverWebhooks` interface. 

The interface has two methods, `getWebhookName` for giving the webhook a unique name, 
and `getWebhookPayload` to define the data send with the webhook.  

The following example shows how a Post Updated Event and its implementation:

```php
use App\Models\Post;
use Viezel\Webhooks\Contracts\ShouldDeliverWebhooks;

class PostUpdatedEvent implements ShouldDeliverWebhooks
{
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function getWebhookName(): string
    {
        return 'post:updated';
    }

    public function getWebhookPayload(): array
    {
        return [
            'post' => $this->post->toArray(),
            'extra' => [
                'foo' => 'bar'
            ]       
        ];
    }
}
```

Next you need to register all your events with the `WebhookRegistry`. 
This is typically done in the boot method of a ServiceProvider.

```php
public function boot()
{
    WebhookRegistry::listen(PostUpdatedEvent::class);
}
```

To check everything works as expected, go visit the webhooks events route. The default route is: `/api/hooks/events`. 
It depends how you register the webhook routes. 

### List available webhooks events

GET https://myapp.test/api/hooks/events

### List registered webhooks

GET https://myapp.test/api/hooks

### Register a webhook

POST https://myapp.test/api/hooks

```json
{
    "events": [
        "post:updated"
    ],
    "url": "https://another-app.com/some/callback/route"
}
```

### Delete a webhook

DELETE https://myapp.test/api/hooks/{id}


## Testing

```bash
composer test
```

## Credits

- [Mads Møller](https://github.com/viezel)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

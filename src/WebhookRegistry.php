<?php
declare(strict_types=1);

namespace Viezel\Webhooks;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Viezel\Webhooks\Listener\WebhookListener;

class WebhookRegistry
{
    protected static array $events = [];

    public static function allEvents(): array
    {
        return self::$events;
    }

    public static function listen(string $class): void
    {
        $name = self::getEventName($class);
        if (\in_array($name, self::allEvents(), true)) {
            Log::warning('WebhookRegistry: Webhook event "' .$name . '" already registered');

            return;
        }

        self::$events[] = self::getEventName($class);
        Event::listen($class, WebhookListener::class);
    }

    private static function getEventName(string $class): string
    {
        return (new \ReflectionClass($class))
            ->newInstanceWithoutConstructor()
            ->getWebhookName();
    }
}

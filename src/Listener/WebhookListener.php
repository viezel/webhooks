<?php
declare(strict_types=1);

namespace Viezel\Webhooks\Listener;

use Viezel\Webhooks\Contracts\ShouldDeliverWebhooks;
use Viezel\Webhooks\Models\Webhook;

class WebhookListener
{
    public function handle(ShouldDeliverWebhooks $event): void
    {
        Webhook::trigger($event->getWebhookName(), $event->getWebhookPayload());
    }
}

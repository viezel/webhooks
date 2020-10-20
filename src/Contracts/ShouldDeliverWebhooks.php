<?php
declare(strict_types=1);

namespace Viezel\Webhooks\Contracts;

interface ShouldDeliverWebhooks
{
    public function getWebhookName(): string;

    public function getWebhookPayload(): array;
}

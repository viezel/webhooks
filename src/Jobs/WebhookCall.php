<?php
declare(strict_types=1);

namespace Viezel\Webhooks\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Viezel\Webhooks\Models\Webhook;

class WebhookCall implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected Webhook $webhook;
    protected array $payload;

    public $tries = 3;
    public $timeout = 60;

    public function __construct(Webhook $webhook, array $payload)
    {
        $this->webhook = $webhook;
        $this->payload = $payload;
    }

    public function handle()
    {
        Http::timeout(10)
            //->retry(3, 60)
            ->withHeaders($this->webhook->headers ?? [])
            ->withOptions([
                'verify' => $this->webhook->verify_ssl,
            ])
            ->asJson()
            ->post($this->webhook->url, $this->payload);
    }
}

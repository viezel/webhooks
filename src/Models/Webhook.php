<?php
declare(strict_types=1);

namespace Viezel\Webhooks\Models;

use Illuminate\Database\Eloquent\Model;
use Viezel\Webhooks\Jobs\WebhookCall;
use Viezel\Webhooks\Support\GeneratesIds;

class Webhook extends Model
{
    use GeneratesIds;

    protected $fillable = [
        'description',
        'url',
        'verify_ssl',
        'events',
        'headers',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'events' => 'json',
        'headers' => 'json',
        'verify_ssl' => 'boolean',
    ];

    public static function trigger(string $event, array $payload): void
    {
        $hooks = self::query()->whereJsonContains('events', $event)->get();

        if ($hooks->isEmpty()) {
            return;
        }

        foreach ($hooks as $hook) {
            WebhookCall::dispatch($hook, $payload);
        }
    }
}

<?php
declare(strict_types=1);

namespace Viezel\Webhooks\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Viezel\Webhooks\WebhookRegistry;

class CreateWebhookRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'events' => ['required', 'array'],
            'events.*' => ['string', 'distinct', Rule::in(WebhookRegistry::allEvents())],
            'headers' => ['nullable', 'array'],
            'url' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'verify_ssl' => ['nullable', 'boolean'],
        ];
    }
}

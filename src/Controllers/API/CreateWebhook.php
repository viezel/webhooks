<?php
declare(strict_types=1);

namespace Viezel\Webhooks\Controllers\API;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Viezel\Webhooks\Models\Webhook;
use Viezel\Webhooks\Requests\CreateWebhookRequest;

class CreateWebhook extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function __invoke(CreateWebhookRequest $request): JsonResponse
    {
        $hook = Webhook::create($request->validated());

        return Response::json($hook->toArray(), 201);
    }
}

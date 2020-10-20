<?php
declare(strict_types=1);

namespace Viezel\Webhooks\Controllers\API;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Viezel\Webhooks\Models\Webhook;

class DeleteWebhook extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function __invoke(string $id)
    {
        Webhook::findOrFail($id)->delete();

        return Response::json([], 204);
    }
}

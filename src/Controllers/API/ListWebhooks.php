<?php
declare(strict_types=1);

namespace Viezel\Webhooks\Controllers\API;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Viezel\Webhooks\Models\Webhook;

class ListWebhooks extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function __invoke()
    {
        return Webhook::query()->paginate();
    }
}

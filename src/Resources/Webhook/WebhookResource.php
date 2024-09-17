<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources\Webhook;

use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Webhook\Webhook;
use Szhorvath\CloudflareStream\Resources\Resource;

class WebhookResource extends Resource
{
    /**
     * @param  array<string,mixed>  $data
     * @return ApiResponse<Webhook>
     */
    public function create(string $accountId, array $data = []): ApiResponse
    {
        $response = $this->sdk()->put(
            uri: "/accounts/{$accountId}/stream/webhook",
            data: $data
        );

        return ApiResponse::from(
            data: $response,
            resultClass: Webhook::class
        );
    }

    /**
     * @return ApiResponse<Webhook>
     */
    public function view(string $accountId): ApiResponse
    {
        $response = $this->sdk()->get(
            uri: "/accounts/{$accountId}/stream/webhook"
        );

        return ApiResponse::from(
            data: $response,
            resultClass: Webhook::class
        );
    }

    /**
     * @return ApiResponse<Webhook>
     */
    public function delete(string $accountId): ApiResponse
    {
        $response = $this->sdk()->delete(
            uri: "/accounts/{$accountId}/stream/webhook"
        );

        return ApiResponse::from(
            data: $response,
        );
    }
}

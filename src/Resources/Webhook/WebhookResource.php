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
     */
    public function create(string $accountId, array $data): ApiResponse
    {
        $response = $this->client()->put(
            uri: "/accounts/{$accountId}/stream/webhook",
            body: $this->createStream($data)
        );

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: Webhook::class
        );
    }

    public function view(string $accountId): ApiResponse
    {
        $response = $this->client()->get(
            uri: "/accounts/{$accountId}/stream/webhook"
        );

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: Webhook::class
        );
    }

    public function delete(string $accountId): ApiResponse
    {
        $response = $this->client()->delete(
            uri: "/accounts/{$accountId}/stream/webhook"
        );

        return ApiResponse::from(
            data: $this->decodeResponse($response),
        );
    }
}

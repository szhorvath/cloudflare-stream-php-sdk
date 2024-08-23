<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources\SigningKey;

use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\SigningKey\Key;
use Szhorvath\CloudflareStream\DataObjects\SigningKey\KeyCollection;
use Szhorvath\CloudflareStream\Resources\Resource;

class SigningKeyResource extends Resource
{
    public function create(string $accountId): ApiResponse
    {
        $response = $this->client()->post("/accounts/{$accountId}/stream/keys");

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: Key::class
        );
    }

    public function list(string $accountId): ApiResponse
    {
        $response = $this->client()->get("/accounts/{$accountId}/stream/keys");

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: KeyCollection::class
        );
    }

    public function delete(string $accountId, string $keyId): ApiResponse
    {
        $response = $this->client()->delete("/accounts/{$accountId}/stream/keys/{$keyId}");

        return ApiResponse::from(
            data: $this->decodeResponse($response)
        );
    }
}

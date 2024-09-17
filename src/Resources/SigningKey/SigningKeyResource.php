<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources\SigningKey;

use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\SigningKey\Key;
use Szhorvath\CloudflareStream\DataObjects\SigningKey\KeyCollection;
use Szhorvath\CloudflareStream\Resources\Resource;

class SigningKeyResource extends Resource
{
    /**
     * @return ApiResponse<Key>
     */
    public function create(string $accountId): ApiResponse
    {
        $response = $this->sdk()->post("/accounts/{$accountId}/stream/keys");

        return ApiResponse::from(
            data: $response,
            resultClass: Key::class
        );
    }

    /**
     * @return ApiResponse<KeyCollection>
     */
    public function list(string $accountId): ApiResponse
    {
        $response = $this->sdk()->get("/accounts/{$accountId}/stream/keys");

        return ApiResponse::from(
            data: $response,
            resultClass: KeyCollection::class
        );
    }

    /**
     * @return ApiResponse<null>
     */
    public function delete(string $accountId, string $keyId): ApiResponse
    {
        $response = $this->sdk()->delete("/accounts/{$accountId}/stream/keys/{$keyId}");

        return ApiResponse::from(
            data: $response
        );
    }
}

<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources\Download;

use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Download\Download;
use Szhorvath\CloudflareStream\Resources\Resource;

class DownloadResource extends Resource
{
    public function create(string $accountId, string $videoId): ApiResponse
    {
        $response = $this->client()->post("/accounts/{$accountId}/stream/{$videoId}/downloads");

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: Download::class
        );
    }

    public function list(string $accountId, string $videoId): ApiResponse
    {
        $response = $this->client()->get("/accounts/{$accountId}/stream/{$videoId}/downloads");

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: Download::class
        );
    }

    public function delete(string $accountId, string $videoId): ApiResponse
    {
        $response = $this->client()->delete("/accounts/{$accountId}/stream/{$videoId}/downloads");

        return ApiResponse::from(
            data: $this->decodeResponse($response),
        );
    }
}

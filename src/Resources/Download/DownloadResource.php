<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources\Download;

use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Download\Download;
use Szhorvath\CloudflareStream\Resources\Resource;

class DownloadResource extends Resource
{
    /**
     * @return ApiResponse<Download>
     */
    public function create(string $accountId, string $videoId): ApiResponse
    {
        $response = $this->sdk()->post("/accounts/{$accountId}/stream/{$videoId}/downloads");

        return ApiResponse::from(
            data: $response,
            resultClass: Download::class
        );
    }

    /**
     * @return ApiResponse<Download>
     */
    public function list(string $accountId, string $videoId): ApiResponse
    {
        $response = $this->sdk()->get("/accounts/{$accountId}/stream/{$videoId}/downloads");

        return ApiResponse::from(
            data: $response,
            resultClass: Download::class
        );
    }

    /**
     * @return ApiResponse<Download>
     */
    public function delete(string $accountId, string $videoId): ApiResponse
    {
        $response = $this->sdk()->delete("/accounts/{$accountId}/stream/{$videoId}/downloads");

        return ApiResponse::from(
            data: $response,
        );
    }
}

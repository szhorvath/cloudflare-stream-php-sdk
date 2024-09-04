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
        $response = $this->client()->post(
            uri: "/accounts/{$accountId}/stream/{$videoId}/downloads"
        );

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: Download::class
        );
    }
}

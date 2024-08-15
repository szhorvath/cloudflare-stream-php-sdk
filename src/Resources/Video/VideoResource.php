<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources\Video;

use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Video\VideoCollection;
use Szhorvath\CloudflareStream\Resources\Resource;

class VideoResource extends Resource
{
    public function list(string $accountId, ?array $params = []): ApiResponse
    {
        $response = $this->client()->get(
            uri: "/accounts/{$accountId}/stream"
        );

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: VideoCollection::class
        );
    }
}

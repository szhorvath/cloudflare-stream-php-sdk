<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources\Video;

use Szhorvath\CloudflareStream\Contracts\FiltersContract;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Video\Video;
use Szhorvath\CloudflareStream\DataObjects\Video\Videos;
use Szhorvath\CloudflareStream\Enums\Method;
use Szhorvath\CloudflareStream\Resources\Resource;

class VideoResource extends Resource
{
    public function list(string $accountId, ?FiltersContract $filters = null): ApiResponse
    {
        $request = $this->buildRequest(Method::GET, "/accounts/{$accountId}/stream");

        if ($filters) {
            $request = $filters->applyTo($request);
        }

        $response = $this->client()->sendRequest($request);

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: Videos::class
        );
    }

    public function retrieve(string $accountId, string $videoId): ApiResponse
    {
        $response = $this->client()->get("/accounts/{$accountId}/stream/{$videoId}");

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: Video::class
        );
    }
}

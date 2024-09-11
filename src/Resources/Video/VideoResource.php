<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources\Video;

use Szhorvath\CloudflareStream\Contracts\FiltersContract;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Token\Token;
use Szhorvath\CloudflareStream\DataObjects\Video\Storage;
use Szhorvath\CloudflareStream\DataObjects\Video\Video;
use Szhorvath\CloudflareStream\DataObjects\Video\Videos;
use Szhorvath\CloudflareStream\Resources\Resource;

class VideoResource extends Resource
{
    public function list(string $accountId, ?FiltersContract $filters = null): ApiResponse
    {
        $response = $this->sdk()->get(
            uri: "/accounts/{$accountId}/stream",
            filters: $filters
        );

        return ApiResponse::from(
            data: $response,
            resultClass: Videos::class
        );
    }

    public function retrieve(string $accountId, string $videoId): ApiResponse
    {
        $response = $this->sdk()->get("/accounts/{$accountId}/stream/{$videoId}");

        return ApiResponse::from(
            data: $response,
            resultClass: Video::class
        );
    }

    /**
     * @param  array{allowedOrigins:array{string},creator:string,maxDurationSeconds:int,meta:array{string,mixed},requireSignedURLs:bool,scheduledDeletion:string,thumbnailTimestampPct:int,uploadExpiry:string,publicDetails?:array{title?:string,share_link?:string,channel_link?:string,logo?:string}}  $data
     */
    public function update(string $accountId, string $videoId, array $data): ApiResponse
    {
        $response = $this->sdk()->post(
            uri: "/accounts/{$accountId}/stream/{$videoId}",
            data: $data
        );

        return ApiResponse::from(
            data: $response,
            resultClass: Video::class
        );
    }

    public function delete(string $accountId, string $videoId): ApiResponse
    {
        $response = $this->sdk()->delete("/accounts/{$accountId}/stream/{$videoId}");

        return ApiResponse::from(
            data: $response,
        );
    }

    /**
     * @param  array{url:string,creator?:string,meta?:array{string,mixed},requireSignedURLs?:bool,scheduledDeletion?:string,thumbnailTimestampPct?:int,watermark?:array{uid:string}}  $data
     * @param  array{Upload-Creator?:string,Upload-Metadata?:string}  $headers
     */
    public function uploadFromURL(string $accountId, array $data, array $headers = []): ApiResponse
    {
        $response = $this->sdk()->post(
            uri: "/accounts/{$accountId}/stream/copy",
            data: $data,
            headers: $headers,
        );

        return ApiResponse::from(
            data: $response,
            resultClass: Video::class
        );
    }

    /**
     * @param  array{accessRules?:array{action?:string,country?:array{string},ip?:array{string},type?:string},downloadable?:bool,exp?:int,id?:string,nbf?:int,pem?:string}  $data
     */
    public function createToken(string $accountId, string $videoId, array $data = []): ApiResponse
    {
        $response = $this->sdk()->post(
            uri: "/accounts/{$accountId}/stream/{$videoId}/token",
            data: $data
        );

        return ApiResponse::from(
            data: $response,
            resultClass: Token::class
        );
    }

    public function embed(string $accountId, string $videoId): string
    {
        $response = $this->client()->get("/accounts/{$accountId}/stream/{$videoId}/embed");

        return $response->getBody()->getContents();
    }

    public function storage(string $accountId): ApiResponse
    {
        $response = $this->sdk()->get("/accounts/{$accountId}/stream/storage-usage");

        return ApiResponse::from(
            data: $response,
            resultClass: Storage::class
        );
    }

    /**
     * @param  array{clippedFromVideoUID:string,startTimeSeconds:int,endTimeSeconds:int,allowedOrigins?:array{string},creator?:string,maxDurationSeconds?:int,requireSignedURLs?:bool,thumbnailTimestampPct?:float,watermark?:array{uid:string}}  $data
     */
    public function clip(string $accountId, array $data): ApiResponse
    {
        $response = $this->sdk()->post(
            uri: "/accounts/{$accountId}/stream/clip",
            data: $data
        );

        return ApiResponse::from(
            data: $response,
            resultClass: Video::class
        );
    }
}

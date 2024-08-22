<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources\Video;

use Szhorvath\CloudflareStream\Contracts\FiltersContract;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Token\Token;
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

    /**
     * @param  array{allowedOrigins:array{string},creator:string,maxDurationSeconds:int,meta:array{string,mixed},requireSignedURLs:bool,scheduledDeletion:string,thumbnailTimestampPct:int,uploadExpiry:string}  $data
     */
    public function update(string $accountId, string $videoId, array $data): ApiResponse
    {
        $response = $this->client()->post(
            uri: "/accounts/{$accountId}/stream/{$videoId}",
            body: $this->createStream($data)
        );

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: Video::class
        );
    }

    public function delete(string $accountId, string $videoId): ApiResponse
    {
        $response = $this->client()->delete("/accounts/{$accountId}/stream/{$videoId}");

        return ApiResponse::from(
            data: $this->decodeResponse($response),
        );
    }

    /**
     * @param  array{url:string,creator?:string,meta?:array{string,mixed},requireSignedURLs?:bool,scheduledDeletion?:string,thumbnailTimestampPct?:int,watermark?:array{uid:string}}  $data
     * @param  array{Upload-Creator?:string,Upload-Metadata?:string}  $headers
     */
    public function uploadFromURL(string $accountId, array $data, array $headers = []): ApiResponse
    {
        $response = $this->client()->post(
            uri: "/accounts/{$accountId}/stream/copy",
            headers: $headers,
            body: $this->createStream($data)
        );

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: Video::class
        );
    }

    /**
     * @param  array{accessRules?:array{action?:string,country?:array{string},ip?:array{string},type?:string},downloadable?:bool,exp?:int,id?:string,nbf?:int,pem?:string}  $data
     */
    public function createToken(string $accountId, string $videoId, array $data = []): ApiResponse
    {
        $response = $this->client()->post(
            uri: "/accounts/{$accountId}/stream/{$videoId}/token",
            body: $data ? $this->createStream($data) : null
        );

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: Token::class
        );
    }

    public function embed(string $accountId, string $videoId): string
    {
        $response = $this->client()->get("/accounts/{$accountId}/stream/{$videoId}/embed");

        return $response->getBody()->getContents();
    }
}

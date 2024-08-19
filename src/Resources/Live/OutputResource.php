<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources\Live;

use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Live\Input;
use Szhorvath\CloudflareStream\DataObjects\Live\Output;
use Szhorvath\CloudflareStream\DataObjects\Live\OutputCollection;
use Szhorvath\CloudflareStream\Resources\Resource;

class OutputResource extends Resource
{
    /**
     * @param  array<string,mixed>  $data
     */
    public function create(string $accountId, string $liveInputId, ?array $data = []): ApiResponse
    {
        $response = $this->client()->post(
            uri: "/accounts/{$accountId}/stream/live_inputs/{$liveInputId}/outputs",
            body: $this->createStream($data)
        );

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: Output::class
        );
    }

    /**
     * @param  array<string,mixed>  $data
     */
    public function update(string $accountId, string $liveInputId, string $outputId, ?array $data = []): ApiResponse
    {
        $response = $this->client()->put(
            uri: "/accounts/{$accountId}/stream/live_inputs/{$liveInputId}/outputs/{$outputId}",
            body: $this->createStream($data)
        );

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: Output::class
        );
    }

    public function list(string $accountId, string $liveInputId): ApiResponse
    {
        $response = $this->client()->get("/accounts/{$accountId}/stream/live_inputs/{$liveInputId}/outputs");

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: OutputCollection::class
        );
    }

    public function retrieve(string $accountId, string $liveInputId): ApiResponse
    {
        $response = $this->client()->get("/accounts/{$accountId}/stream/live_inputs/{$liveInputId}");

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: Input::class
        );
    }

    public function delete(string $accountId, string $liveInputId, string $outputId): ApiResponse
    {
        $response = $this->client()->delete("/accounts/{$accountId}/stream/live_inputs/{$liveInputId}/outputs/{$outputId}");

        return ApiResponse::from(
            data: $this->decodeResponse($response),
        );
    }
}

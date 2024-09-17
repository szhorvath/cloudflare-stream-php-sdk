<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources\Live;

use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Live\Output;
use Szhorvath\CloudflareStream\DataObjects\Live\OutputCollection;
use Szhorvath\CloudflareStream\Resources\Resource;

class OutputResource extends Resource
{
    /**
     * @param  array<string,mixed>  $data
     * @return ApiResponse<Output>
     */
    public function create(string $accountId, string $liveInputId, array $data = []): ApiResponse
    {
        $response = $this->sdk()->post(
            uri: "/accounts/{$accountId}/stream/live_inputs/{$liveInputId}/outputs",
            data: $data
        );

        return ApiResponse::from(
            data: $response,
            resultClass: Output::class
        );
    }

    /**
     * @param  array<string,mixed>  $data
     * @return ApiResponse<Output>
     */
    public function update(string $accountId, string $liveInputId, string $outputId, array $data = []): ApiResponse
    {
        $response = $this->sdk()->put(
            uri: "/accounts/{$accountId}/stream/live_inputs/{$liveInputId}/outputs/{$outputId}",
            data: $data
        );

        return ApiResponse::from(
            data: $response,
            resultClass: Output::class
        );
    }

    /**
     * @return ApiResponse<OutputCollection>
     */
    public function list(string $accountId, string $liveInputId): ApiResponse
    {
        $response = $this->sdk()->get("/accounts/{$accountId}/stream/live_inputs/{$liveInputId}/outputs");

        return ApiResponse::from(
            data: $response,
            resultClass: OutputCollection::class
        );
    }

    /**
     * @return ApiResponse<Output>
     */
    public function retrieve(string $accountId, string $liveInputId): ApiResponse
    {
        $response = $this->sdk()->get("/accounts/{$accountId}/stream/live_inputs/{$liveInputId}");

        return ApiResponse::from(
            data: $response,
            resultClass: Output::class
        );
    }

    /**
     * @return ApiResponse<null>
     */
    public function delete(string $accountId, string $liveInputId, string $outputId): ApiResponse
    {
        $response = $this->sdk()->delete("/accounts/{$accountId}/stream/live_inputs/{$liveInputId}/outputs/{$outputId}");

        return ApiResponse::from(
            data: $response,
        );
    }
}

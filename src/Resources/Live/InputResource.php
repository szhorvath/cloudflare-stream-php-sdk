<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources\Live;

use Szhorvath\CloudflareStream\Contracts\FiltersContract;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Live\Input;
use Szhorvath\CloudflareStream\DataObjects\Live\InputCollection;
use Szhorvath\CloudflareStream\Resources\Resource;

class InputResource extends Resource
{
    /**
     * @param  array<string,mixed>  $data
     */
    public function create(string $accountId, array $data = []): ApiResponse
    {
        $response = $this->sdk()->post(
            uri: "/accounts/{$accountId}/stream/live_inputs",
            data: $data
        );

        return ApiResponse::from(
            data: $response,
            resultClass: Input::class
        );
    }

    /**
     * @param  array<string,mixed>  $data
     */
    public function update(string $accountId, string $liveInputId, array $data = []): ApiResponse
    {
        $response = $this->sdk()->put(
            uri: "/accounts/{$accountId}/stream/live_inputs/{$liveInputId}",
            data: $data
        );

        return ApiResponse::from(
            data: $response,
            resultClass: Input::class
        );
    }

    public function list(string $accountId, ?FiltersContract $filters = null): ApiResponse
    {
        $response = $this->sdk()->get("/accounts/{$accountId}/stream/live_inputs", $filters);

        return ApiResponse::from(
            data: $response,
            resultClass: InputCollection::class
        );
    }

    public function retrieve(string $accountId, string $liveInputId): ApiResponse
    {
        $response = $this->sdk()->get("/accounts/{$accountId}/stream/live_inputs/{$liveInputId}");

        return ApiResponse::from(
            data: $response,
            resultClass: Input::class
        );
    }

    public function delete(string $accountId, string $liveInputId): ApiResponse
    {
        $response = $this->sdk()->delete("/accounts/{$accountId}/stream/live_inputs/{$liveInputId}");

        return ApiResponse::from(
            data: $response,
        );
    }
}

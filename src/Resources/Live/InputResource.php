<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources\Live;

use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Live\Input;
use Szhorvath\CloudflareStream\DataObjects\Live\InputCollection;
use Szhorvath\CloudflareStream\Enums\Method;
use Szhorvath\CloudflareStream\Resources\Resource;

class InputResource extends Resource
{
    public function create(string $accountId, ?array $data = []): ApiResponse
    {
        $response = $this->client()->post(
            uri: "/accounts/{$accountId}/stream/live_inputs",
            body: $this->createStream($data)
        );

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: Input::class
        );
    }

    public function update(string $accountId, string $liveInputId, ?array $data = []): ApiResponse
    {
        $response = $this->client()->put(
            uri: "/accounts/{$accountId}/stream/live_inputs/{$liveInputId}",
            body: $this->createStream($data)
        );

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: Input::class
        );
    }

    public function list(string $accountId, array $filters = []): ApiResponse
    {
        $request = $this->buildRequest(Method::GET, "/accounts/{$accountId}/stream/live_inputs");

        $response = $this->client()->sendRequest($request);

        return ApiResponse::from(
            data: $this->decodeResponse($response),
            resultClass: InputCollection::class
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

    public function delete(string $accountId, string $liveInputId): ApiResponse
    {
        $response = $this->client()->delete("/accounts/{$accountId}/stream/live_inputs/{$liveInputId}");

        return ApiResponse::from(
            data: $this->decodeResponse($response),
        );
    }
}

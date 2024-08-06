<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources\Live;

use Http\Client\Exception;
use RuntimeException;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Live\Input;
use Szhorvath\CloudflareStream\DataObjects\Live\InputCollection;
use Szhorvath\CloudflareStream\Enums\Method;
use Szhorvath\CloudflareStream\Resources\Resource;
use TypeError;

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

    /**
     * @see https://developers.cloudflare.com/api/operations/stream-live-inputs-list-live-inputs
     *
     * @throws TypeError
     * @throws Exception
     * @throws RuntimeException
     */
    public function list(string $accountId, array $filters = []): ApiResponse
    {
        $request = $this->buildRequest(Method::GET, "/accounts/{$accountId}/stream/live_inputs");

        $response = $this->client()->sendRequest($request);

        return ApiResponse::from(
            $this->decodeResponse($response),
            InputCollection::class
        );
    }

    public function retrieve(string $accountId, string $liveInputIdentifier): object
    {
        $response = $this->client()->get("/accounts/{$accountId}/stream/live_inputs/{$liveInputIdentifier}");

        return ApiResponse::from(
            $this->decodeResponse($response),
            Input::class
        );
    }

    public function delete(string $uid): void
    {
        $this->client()->delete('/stream/'.$uid);
    }
}

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
    public function create(string $name, string $url): string
    {
        $response = $this->client()->post('/stream', [
            'json' => [
                'name' => $name,
                'url' => $url,
            ],
        ]);

        $responseBody = $response->getBody()->getContents();

        return json_decode($responseBody)->result->uid;
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

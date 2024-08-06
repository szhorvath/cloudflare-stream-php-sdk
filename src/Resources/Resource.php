<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Illuminate\Support\Collection;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Szhorvath\CloudflareStream\Contracts\ResourceContract;
use Szhorvath\CloudflareStream\Contracts\ResultContract;
use Szhorvath\CloudflareStream\Enums\Method;
use Szhorvath\CloudflareStream\StreamSdk;

abstract class Resource implements ResourceContract
{
    private bool $success = false;

    private array $errors = [];

    private array $messages = [];

    /** @var null|ResultContract|Collection<int, ResultContract> */
    private ResultContract|Collection|null $result = null;

    public function __construct(
        private readonly StreamSdk $sdk,
    ) {}

    public function client(): HttpMethodsClientInterface
    {
        return $this->sdk->client();
    }

    public function success(): bool
    {
        return $this->success;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function messages(): array
    {
        return $this->messages;
    }

    public function result(): ResultContract|Collection|null
    {
        return $this->result;
    }

    public function buildRequest(Method $method, string $uri): RequestInterface
    {
        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            method: $method->value,
            uri: $uri,
        );
    }

    public function createStream(array $payload): StreamInterface
    {
        return Psr17FactoryDiscovery::findStreamFactory()->createStream(
            content: json_encode(
                value: $payload,
                flags: JSON_THROW_ON_ERROR
            ),
        );
    }

    /**
     * @return array{success:bool,errors:array,messages:array,result:array}
     *
     * @throws JsonException
     */
    public function decodeResponse(ResponseInterface $response): array
    {
        return json_decode(
            json: $response->getBody()->getContents(),
            associative: true,
            flags: JSON_THROW_ON_ERROR,
        );
    }
}

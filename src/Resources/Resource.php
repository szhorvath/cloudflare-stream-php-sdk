<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Szhorvath\CloudflareStream\Contracts\ResourceContract;
use Szhorvath\CloudflareStream\Enums\Method;
use Szhorvath\CloudflareStream\StreamSdk;

abstract class Resource implements ResourceContract
{
    public function __construct(
        private readonly StreamSdk $sdk,
    ) {}

    public function client(): HttpMethodsClientInterface
    {
        return $this->sdk->client();
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

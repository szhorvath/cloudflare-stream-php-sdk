<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Concerns;

use Http\Client\Common\Exception\ClientErrorException;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use RuntimeException;
use Szhorvath\CloudflareStream\Contracts\FiltersContract;
use Szhorvath\CloudflareStream\Enums\Method;

trait CanCreateRequests
{
    public function request(Method $method, string $uri): RequestInterface
    {
        return Psr17FactoryDiscovery::findRequestFactory()->createRequest(
            method: $method->value,
            uri: $uri,
        );
    }

    /**
     * @param  array<string,mixed>  $payload
     */
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
     * @return array{success: bool, errors: array<int, string>, messages: array<int, string>, result: array<string, mixed>}
     *
     * @throws RuntimeException
     */
    public function decodeResponse(ResponseInterface $response): array
    {
        return json_decode(
            json: $response->getBody()->getContents(),
            associative: true,
            flags: JSON_THROW_ON_ERROR,
        );
    }

    public function send(RequestInterface $request, ?array $body = null, array $headers = []): array
    {
        foreach ($headers as $key => $value) {
            $request = $request->withHeader(
                name: $key,
                value: $value
            );
        }

        if ($body) {
            $request = $request->withBody(
                body: $this->createStream(payload: $body)
            );
        }

        try {
            return $this->decodeResponse(
                response: $this->client()->sendRequest($request)
            );
        } catch (ClientErrorException $exception) {
            return $this->decodeResponse(
                response: $exception->getResponse()
            );
        }
    }

    public function get(string $uri, ?FiltersContract $filters = null, array $headers = []): array
    {
        $request = $this->request(Method::GET, $uri);

        if ($filters) {
            $request = $filters->applyTo($request);
        }

        return $this->send(
            request: $request,
            headers: $headers,
        );
    }

    public function post(string $uri, array $data = [], array $headers = []): array
    {
        return $this->send(
            request: $this->request(Method::POST, $uri),
            body: $data,
            headers: $headers,
        );
    }

    public function put(string $uri, array $data = [], array $headers = []): array
    {
        return $this->send(
            request: $this->request(Method::PUT, $uri),
            body: $data,
            headers: $headers,
        );
    }

    public function patch(string $uri, array $data = [], array $headers = []): array
    {
        return $this->send(
            request: $this->request(Method::PATCH, $uri),
            body: $data,
            headers: $headers,
        );
    }

    public function delete(string $uri, array $data = [], array $headers = []): array
    {
        return $this->send(
            request: $this->request(Method::DELETE, $uri),
            body: $data,
            headers: $headers,
        );
    }
}

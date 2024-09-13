<?php

declare(strict_types=1);

use Http\Client\Common\Exception\ClientErrorException;
use Http\Mock\Client as MockClient;
use Szhorvath\CloudflareStream\Enums\Method;
use Szhorvath\CloudflareStream\StreamSdk;

it('should build a new client')
    ->expect(new StreamSdk(token: '1234567890'))
    ->toBeInstanceOf(StreamSdk::class);

it('should throw a client exception on client error', function () {
    $mockClient = new MockClient;

    $mockResponse = response(name: 'not-found');

    $mockClient->addException(
        new ClientErrorException(
            message: 'Not found',
            request: request(
                method: Method::GET,
                uri: 'https://api.cloudflare.com/client/v4/path/not/found',
            ),
            response: $mockResponse,
        )
    );

    $mockClient->addResponse($mockResponse);

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($mockClient)
    );

    $sdk->client()->get('path/not/found');
})->throws(ClientErrorException::class, 'Not found');

it('should handle client exceptions when direct request is made from SDK', function () {
    $mockClient = new MockClient;

    $mockResponse = response(name: 'not-found');

    $mockClient->addException(
        new ClientErrorException(
            message: 'Not found',
            request: request(
                method: Method::GET,
                uri: 'https://api.cloudflare.com/client/v4/path/not/found',
            ),
            response: $mockResponse,
        )
    );

    $mockClient->addResponse($mockResponse);

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($mockClient)
    );

    $response = $sdk->get('path/not/found');

    expect($response)->toBe([
        'success' => false,
        'errors' => [
            [
                'code' => 7003,
                'message' => 'Could not route to /path/not/found, perhaps your object identifier is invalid?',
            ],
            [
                'code' => 7000,
                'message' => 'No route for that URI',
            ],
        ],
        'messages' => [],
        'result' => null,
    ]);
});

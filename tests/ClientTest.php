<?php

declare(strict_types=1);

use Http\Mock\Client as MockClient;
use Szhorvath\CloudflareStream\ClientBuilder;
use Szhorvath\CloudflareStream\Enums\Status;
use Szhorvath\CloudflareStream\StreamSdk;

it('should build a new client', function () {
    $sdk = new StreamSdk(
        url: 'https://api.cloudflare.com/client/v4/',
        token: '1234567890'
    );

    expect($sdk)->toBeInstanceOf(StreamSdk::class);
});

it('should create a builder')
    ->expect(new ClientBuilder)
    ->toBeInstanceOf(ClientBuilder::class);

it('should verify token validity', function () {
    $client = new MockClient;
    $client->addResponse(response(
        status: Status::OK,
        name: 'token/verify',
    ));

    $sdk = new StreamSdk(
        url: 'https://api.cloudflare.com/client/v4/',
        token: '1234568',
        client: $client
    );

    expect($sdk->token()->verify())->toBeTrue();
});

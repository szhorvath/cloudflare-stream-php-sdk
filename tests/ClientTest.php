<?php

declare(strict_types=1);

use Szhorvath\CloudflareStream\Builder;
use Szhorvath\CloudflareStream\Client;

it('should build a new client', function () {
    $client = new Client(
        url: 'https://api.cloudflare.com/client/v4/',
        token: '1234567890'
    );

    expect($client)->toBeInstanceOf(Client::class);
});

it('should set token', function () {
    $client = new Client(
        url: 'https://api.cloudflare.com/client/v4/',
        token: '1234568'
    );

    expect($client->token())->toBe('1234568');
});

it('should create a builder')
    ->expect(new Builder)
    ->toBeInstanceOf(Builder::class);

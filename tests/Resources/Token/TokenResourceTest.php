<?php

declare(strict_types=1);

use Http\Mock\Client as MockClient;
use Szhorvath\CloudflareStream\Enums\Status;
use Szhorvath\CloudflareStream\StreamSdk;

it('should verify token validity', function () {
    $client = new MockClient;
    $client->addResponse(response(
        status: Status::OK,
        name: 'token/verify',
    ));

    $sdk = new StreamSdk(
        token: '1234568',
        clientBuilder: mockBuilder($client)
    );

    expect($sdk)->token()->verify()->toBeTrue();
});

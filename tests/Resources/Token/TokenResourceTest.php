<?php

declare(strict_types=1);

use Http\Mock\Client as MockClient;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Message;
use Szhorvath\CloudflareStream\DataObjects\Token\Verify;
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

    $verify = $sdk->token()->verify();

    expect($verify)
        ->toBeInstanceOf(ApiResponse::class)
        ->success->toBeTrue()
        ->messages->toHaveCount(1)->sequence(
            fn ($message) => $message
                ->toBeInstanceOf(Message::class)
                ->code->toBe(10000)
                ->message->toBe('This API Token is valid and active')
        )
        ->result->toBeInstanceOf(Verify::class)
        ->result->id->toBe('7d8f6ed5fd0843d3ae33919c06917fab')
        ->result->status->toBe('active');
});

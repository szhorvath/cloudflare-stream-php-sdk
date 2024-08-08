<?php

declare(strict_types=1);

use Http\Mock\Client as MockClient;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\Enums\Status;
use Szhorvath\CloudflareStream\Resources\Live\OutputResource;
use Szhorvath\CloudflareStream\StreamSdk;

it('should return the input resource', function () {
    $sdk = new StreamSdk('api-key');

    $output = $sdk->output();

    expect($output)->toBeInstanceOf(OutputResource::class);
});

it('should create a new live output', function () {
    $client = new MockClient;
    $client->addResponse(response(
        status: Status::OK,
        name: 'live/output/create',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $output = $sdk->output()->create(
        accountId: '0a6c8c72a460f78152e767e10842dcb2',
        liveInputId: 'aed55c2824e57b715d1254c2e7f47edd',
        data: [
            'enabled' => true,
            'streamKey' => 'fw1j-4r9t-qqc6-u98y-b8ga',
            'url' => 'rtmp://a.rtmp.youtube.com/live2',
        ]
    );

    expect($output)
        ->toBeInstanceOf(ApiResponse::class)
        ->success->toBeTrue();

    expect($output->result)
        ->uid->toBe('4ca798e9b35a9a9c8fa1c1ed8e7b705a')
        ->url->toBe('rtmp://a.rtmp.youtube.com/live2')
        ->streamKey->toBe('fw1j-4r9t-qqc6-u98y-b8ga')
        ->enabled->toBeTrue()
        ->status->toBeNull();
});

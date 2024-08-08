<?php

declare(strict_types=1);

use Http\Mock\Client as MockClient;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Live\InputStatus;
use Szhorvath\CloudflareStream\DataObjects\Live\OutputCollection;
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

it('should list all live outputs', function () {
    $client = new MockClient;
    $client->addResponse(response(
        status: Status::OK,
        name: 'live/output/list',
    ));

    $sdk = new StreamSdk(
        token: '134',
        clientBuilder: mockBuilder($client)
    );

    $outputs = $sdk->output()->list(
        accountId: '0a6c8c72a460f78152e767e10842dcb2',
        liveInputId: 'aed55c2824e57b715d1254c2e7f47edd',
    );

    expect($outputs)
        ->toBeInstanceOf(ApiResponse::class)
        ->success->toBeTrue();

    expect($outputs->result)
        ->toBeInstanceOf(OutputCollection::class)
        ->toHaveCount(1);

    expect($outputs->result->first())
        ->uid->toBe('4ca798e9b35a9a9c8fa1c1ed8e7b705a')
        ->url->toBe('rtmp://a.rtmp.youtube.com/live2')
        ->streamKey->toBe('fw1j-4r9t-qqc6-u98y-b8ga')
        ->enabled->toBeTrue()
        ->status->toBeInstanceOf(InputStatus::class)
        ->status->current->ingestProtocol->toBe('rtmp')
        ->status->current->state->toBe('connected')
        ->status->current->statusEnteredAt->toBeInstanceOf(DateTimeImmutable::class)
        ->status->current->reason->toBe('connected')
        ->status->history->toHaveCount(1)
        ->status->history->sequence(
            fn ($history) => $history
                ->ingestProtocol->toBe('rtmp')
                ->reason->toBeNull()
                ->state->toBe('connecting')
                ->statusEnteredAt->toBeInstanceOf(DateTimeImmutable::class),
        );

});

it('should update live output', function () {
    $client = new MockClient;
    $client->addResponse(response(
        status: Status::OK,
        name: 'live/output/update',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $output = $sdk->output()->update(
        accountId: '0a6c8c72a460f78152e767e10842dcb2',
        liveInputId: 'aed55c2824e57b715d1254c2e7f47edd',
        outputId: '4ca798e9b35a9a9c8fa1c1ed8e7b705a',
        data: [
            'enabled' => false,
        ]
    );

    expect($output)
        ->toBeInstanceOf(ApiResponse::class)
        ->success->toBeTrue();

    expect($output->result)
        ->uid->toBe('4ca798e9b35a9a9c8fa1c1ed8e7b705a')
        ->url->toBe('rtmp://a.rtmp.youtube.com/live2')
        ->streamKey->toBe('fw1j-4r9t-qqc6-u98y-b8ga')
        ->enabled->toBeFalse()
        ->status->toBeNull();
});

it('should delete live output', function () {
    $client = new MockClient;
    $client->addResponse(response(
        status: Status::NO_CONTENT,
        name: 'live/output/delete',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $output = $sdk->output()->delete(
        accountId: '0a6c8c72a460f78152e767e10842dcb2',
        liveInputId: 'aed55c2824e57b715d1254c2e7f47edd',
        outputId: '4ca798e9b35a9a9c8fa1c1ed8e7b705a',
    );

    expect($output)
        ->toBeInstanceOf(ApiResponse::class)
        ->success->toBeTrue()
        ->result->toBeNull();
});

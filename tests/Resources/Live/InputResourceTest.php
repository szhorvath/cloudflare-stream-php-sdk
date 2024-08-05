<?php

declare(strict_types=1);

use DateTimeImmutable;
use Http\Mock\Client as MockClient;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\InputCollection;
use Szhorvath\CloudflareStream\Enums\Status;
use Szhorvath\CloudflareStream\Resources\Live\InputResource;
use Szhorvath\CloudflareStream\StreamSdk;

it('should return the input resource', function () {
    $sdk = new StreamSdk('api-key');

    $inputs = $sdk->inputs();

    expect($inputs)->toBeInstanceOf(InputResource::class);
});

it('should list live inputs', function () {
    $client = new MockClient;
    $client->addResponse(response(
        status: Status::OK,
        name: 'live/list',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $inputs = $sdk->inputs()->list('0a6c8c72a460f78152e767e10842dcb2');

    expect($inputs)
        ->toBeInstanceOf(ApiResponse::class)
        ->result
        ->toBeInstanceOf(InputCollection::class)
        ->toHaveCount(2)
        ->sequence(
            fn ($input) => $input
                ->uid->toBe('aed55c2824e57b715d1254c2e7f47edd')
                ->created->toBeInstanceOf(DateTimeImmutable::class)
                ->modified->toBeInstanceOf(DateTimeImmutable::class)
                ->meta->toBe(['name' => 'curly-shape-b869', 'custom' => 'Some description'])
                ->deleteRecordingAfterDays->toBe(30),
            fn ($input) => $input
                ->uid->toBe('cc64dc68be858392942e4b89830769d9')
                ->created->toBeInstanceOf(DateTimeImmutable::class)
                ->modified->toBeInstanceOf(DateTimeImmutable::class)
                ->meta->toBe(['name' => 'curly-shape-bb80'])
                ->deleteRecordingAfterDays->toBe(null),
        );
});

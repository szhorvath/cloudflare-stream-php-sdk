<?php

declare(strict_types=1);

use Http\Mock\Client as MockClient;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Live\Input;
use Szhorvath\CloudflareStream\DataObjects\Live\InputCollection;
use Szhorvath\CloudflareStream\DataObjects\Live\InputStatus;
use Szhorvath\CloudflareStream\DataObjects\Live\InputStatusCurrent;
use Szhorvath\CloudflareStream\DataObjects\Live\Recording;
use Szhorvath\CloudflareStream\DataObjects\Live\Rtmps;
use Szhorvath\CloudflareStream\DataObjects\Live\Srt;
use Szhorvath\CloudflareStream\DataObjects\Live\WebRTC;
use Szhorvath\CloudflareStream\Enums\RecordingMode;
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

it('should create a new live input', function () {
    $client = new MockClient;
    $client->addResponse(response(
        status: Status::OK,
        name: 'live/create',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $input = $sdk->inputs()->create('0a6c8c72a460f78152e767e10842dcb2', [
        'defaultCreator' => 'test-stream',
        'meta' => [
            'name' => 'curly-shape-aa9',
        ],
        'deleteRecordingAfterDays' => 45,
        'recording' => [
            'allowedOrigins' => null,
            'mode' => 'off',
            'requireSignedURLs' => false,
            'timeoutSeconds' => 0,
        ],
    ]);

    expect($input)
        ->toBeInstanceOf(ApiResponse::class)
        ->result->toBeInstanceOf(Input::class);

    expect($input->result)
        ->uid->toBe('cfea8e17547acc0520486e228441fcff')
        ->created->toBeInstanceOf(DateTimeImmutable::class)
        ->modified->toBeInstanceOf(DateTimeImmutable::class)
        ->meta->toBe(['name' => 'curly-shape-aa9'])
        ->deleteRecordingAfterDays->toBe(45)
        ->recording->toBeInstanceOf(Recording::class)
        ->recording->mode->toBeInstanceOf(RecordingMode::class)
        ->recording->mode->value->toBe('off')
        ->recording->requireSignedURLs->toBeFalse()
        ->rtmps->toBeInstanceOf(Rtmps::class)
        ->rtmps->streamKey->toBe('4cc00bb4f41f32c260eb4daa457544dfkcfea8e17547acc0520486e228441fcff')
        ->rtmps->url->toBe('rtmps://live.cloudflare.com:443/live/')
        ->rtmpsPlayback->toBeInstanceOf(Rtmps::class)
        ->rtmpsPlayback->streamKey->toBe('09994d6aace0cab049853fbe4367fe53kcfea8e17547acc0520486e228441fcff')
        ->rtmpsPlayback->url->toBe('rtmps://live.cloudflare.com:443/live/')
        ->srt->toBeInstanceOf(Srt::class)
        ->srt->passphrase->toBe('ece3d28757d2e9fbbdde20b039dbbc18kcfea8e17547acc0520486e228441fcff')
        ->srt->streamId->toBe('cfea8e17547acc0520486e228441fcff')
        ->srtPlayback->toBeInstanceOf(Srt::class)
        ->srtPlayback->passphrase->toBe('6f7c50cc0e40f87db19f743524678465kcfea8e17547acc0520486e228441fcff')
        ->srtPlayback->streamId->toBe('playcfea8e17547acc0520486e228441fcff')
        ->webRTC->toBeInstanceOf(WebRTC::class)
        ->webRTC->url->toBe('https://customer-6xsmv6axkdji7uup.cloudflarestream.com/e706b37ac3a2d7ae90e18be581013043kcfea8e17547acc0520486e228441fcff/webRTC/publish')
        ->webRTCPlayback->toBeInstanceOf(WebRTC::class)
        ->webRTCPlayback->url->toBe('https://customer-6xsmv6axkdji7uup.cloudflarestream.com/cfea8e17547acc0520486e228441fcff/webRTC/play')
        ->status->toBeNull();
});

it('should update a live input', function () {
    $client = new MockClient;
    $client->addResponse(response(
        status: Status::OK,
        name: 'live/update',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $input = $sdk->inputs()->update('0a6c8c72a460f78152e767e10842dcb2', 'cfea8e17547acc0520486e228441fcff', [
        'defaultCreator' => 'test-stream',
        'meta' => [
            'name' => 'test-stream-updated',
            'description' => 'updated description',
        ],
        'deleteRecordingAfterDays' => 45,
        'recording' => [
            'allowedOrigins' => null,
            'mode' => 'automatic',
            'requireSignedURLs' => true,
            'timeoutSeconds' => 0,
        ],
    ]);

    expect($input)
        ->toBeInstanceOf(ApiResponse::class)
        ->result->toBeInstanceOf(Input::class);

    expect($input->result)
        ->uid->toBe('cfea8e17547acc0520486e228441fcff')
        ->created->toBeInstanceOf(DateTimeImmutable::class)
        ->modified->toBeInstanceOf(DateTimeImmutable::class)
        ->meta->toBe(['description' => 'updated description', 'name' => 'test-stream-updated'])
        ->deleteRecordingAfterDays->toBe(45)
        ->recording->toBeInstanceOf(Recording::class)
        ->recording->mode->toBeInstanceOf(RecordingMode::class)
        ->recording->mode->value->toBe('automatic')
        ->recording->requireSignedURLs->toBeTrue()
        ->rtmps->toBeInstanceOf(Rtmps::class)
        ->rtmps->streamKey->toBe('4cc00bb4f41f32c260eb4daa457544dfkcfea8e17547acc0520486e228441fcff')
        ->rtmps->url->toBe('rtmps://live.cloudflare.com:443/live/')
        ->rtmpsPlayback->toBeInstanceOf(Rtmps::class)
        ->rtmpsPlayback->streamKey->toBe('09994d6aace0cab049853fbe4367fe53kcfea8e17547acc0520486e228441fcff')
        ->rtmpsPlayback->url->toBe('rtmps://live.cloudflare.com:443/live/')
        ->srt->toBeInstanceOf(Srt::class)
        ->srt->passphrase->toBe('ece3d28757d2e9fbbdde20b039dbbc18kcfea8e17547acc0520486e228441fcff')
        ->srt->streamId->toBe('cfea8e17547acc0520486e228441fcff')
        ->srtPlayback->toBeInstanceOf(Srt::class)
        ->srtPlayback->passphrase->toBe('6f7c50cc0e40f87db19f743524678465kcfea8e17547acc0520486e228441fcff')
        ->srtPlayback->streamId->toBe('playcfea8e17547acc0520486e228441fcff')
        ->webRTC->toBeInstanceOf(WebRTC::class)
        ->webRTC->url->toBe('https://customer-6xsmv6axkdji7uup.cloudflarestream.com/e706b37ac3a2d7ae90e18be581013043kcfea8e17547acc0520486e228441fcff/webRTC/publish')
        ->webRTCPlayback->toBeInstanceOf(WebRTC::class)
        ->webRTCPlayback->url->toBe('https://customer-6xsmv6axkdji7uup.cloudflarestream.com/cfea8e17547acc0520486e228441fcff/webRTC/play')
        ->status->toBeNull();
});

it('should retrieve a single live input', function () {
    $client = new MockClient;
    $client->addResponse(response(
        status: Status::OK,
        name: 'live/retrieve',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $input = $sdk->inputs()->retrieve('0a6c8c72a460f78152e767e10842dcb2', 'cc64dc68be858392942e4b89830769d9');

    expect($input)
        ->toBeInstanceOf(ApiResponse::class)
        ->result->toBeInstanceOf(Input::class);

    expect($input->result)
        ->uid->toBe('cc64dc68be858392942e4b89830769d9')
        ->created->toBeInstanceOf(DateTimeImmutable::class)
        ->modified->toBeInstanceOf(DateTimeImmutable::class)
        ->meta->toBe(['name' => 'curly-shape-bb80'])
        ->deleteRecordingAfterDays->toBe(45)
        ->recording->toBeInstanceOf(Recording::class)
        ->recording->mode->toBeInstanceOf(RecordingMode::class)
        ->recording->mode->value->toBe('off')
        ->recording->requireSignedURLs->toBeFalse()
        ->rtmps->toBeInstanceOf(Rtmps::class)
        ->rtmps->streamKey->toBe('969c22d1392631c674b85d2a7174ed14kcc64dc68be858392942e4b89830769d9')
        ->rtmps->url->toBe('rtmps://live.cloudflare.com:443/live/')
        ->rtmpsPlayback->toBeInstanceOf(Rtmps::class)
        ->rtmpsPlayback->streamKey->toBe('b754d65a5a4ab8e984335b5743fb16cckcc64dc68be858392942e4b89830769d9')
        ->rtmpsPlayback->url->toBe('rtmps://live.cloudflare.com:443/live/')
        ->srt->toBeInstanceOf(Srt::class)
        ->srt->passphrase->toBe('0183c10621fb134651de3f759d3ee17bkcc64dc68be858392942e4b89830769d9')
        ->srt->streamId->toBe('cc64dc68be858392942e4b89830769d9')
        ->srtPlayback->toBeInstanceOf(Srt::class)
        ->srtPlayback->passphrase->toBe('89c37942d5314251b4ac14ea9a1c395ekcc64dc68be858392942e4b89830769d9')
        ->srtPlayback->streamId->toBe('playcc64dc68be858392942e4b89830769d9')
        ->webRTC->toBeInstanceOf(WebRTC::class)
        ->webRTC->url->toBe('https://customer-6xsmv6axkdji7uup.cloudflarestream.com/f7469f63104536a356457d24b447fc7fkcc64dc68be858392942e4b89830769d9/webRTC/publish')
        ->webRTCPlayback->toBeInstanceOf(WebRTC::class)
        ->webRTCPlayback->url->toBe('https://customer-6xsmv6axkdji7uup.cloudflarestream.com/cc64dc68be858392942e4b89830769d9/webRTC/play')
        ->status->toBeInstanceOf(InputStatus::class)
        ->status->current->toBeInstanceOf(InputStatusCurrent::class)
        ->status->current->ingestProtocol->toBe('rtmp')
        ->status->current->reason->toBe('client_disconnect')
        ->status->current->state->toBe('disconnected')
        ->status->current->statusEnteredAt->toBeInstanceOf(DateTimeImmutable::class)
        ->status->current->statusLastSeen->toBeInstanceOf(DateTimeImmutable::class)
        ->status->history->toHaveCount(1)
        ->status->history->sequence(
            fn ($history) => $history
                ->ingestProtocol->toBe('rtmp')
                ->reason->toBe('connected')
                ->state->toBe('connected')
                ->statusEnteredAt->toBeInstanceOf(DateTimeImmutable::class),
        );
});

it('should delete a live input', function () {
    $client = new MockClient;
    $client->addResponse(response(
        status: Status::OK,
        name: 'live/delete',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $input = $sdk->inputs()->delete('0a6c8c72a460f78152e767e10842dcb2', 'cfea8e17547acc0520486e228441fcff');

    expect($input)
        ->toBeInstanceOf(ApiResponse::class)
        ->result->toBeNull()
        ->success->toBeTrue();
});

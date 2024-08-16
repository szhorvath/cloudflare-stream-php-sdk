<?php

declare(strict_types=1);

use Http\Mock\Client as MockClient;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Video\Input;
use Szhorvath\CloudflareStream\DataObjects\Video\ListVideoItem;
use Szhorvath\CloudflareStream\DataObjects\Video\Playback;
use Szhorvath\CloudflareStream\DataObjects\Video\PublicDetails;
use Szhorvath\CloudflareStream\DataObjects\Video\Status as VideoStatus;
use Szhorvath\CloudflareStream\DataObjects\Video\Videos;
use Szhorvath\CloudflareStream\Enums\Status;
use Szhorvath\CloudflareStream\Resources\Video\VideoResource;
use Szhorvath\CloudflareStream\StreamSdk;

it('should return the video resource', function () {
    $sdk = new StreamSdk('api-key');

    $output = $sdk->video();

    expect($output)->toBeInstanceOf(VideoResource::class);
});

it('should create list videos', function () {
    $client = new MockClient;
    $client->addResponse(response(
        status: Status::OK,
        name: 'video/list',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $videos = $sdk->video()->list(
        accountId: '0a6c8c72a460f78152e767e10842dcb2',
    );

    expect($videos)
        ->toBeInstanceOf(ApiResponse::class)
        ->result->toBeInstanceOf(Videos::class)
        ->total->toBeNull()
        ->range->toBeNull();

    expect($videos->result->videos)
        ->toHaveCount(2)
        ->sequence(
            fn ($item) => $item
                ->toBeInstanceOf(ListVideoItem::class)
                ->uid->toBe('a0587f7fe8e9bc851c75183831a2eb3c')
                ->thumbnail->toBe('https://customer-6xsmv.cloudflarestream.com/a0587f7fe8e9bc851c75183831a2eb3c/thumbnails/thumbnail.jpg')
                ->thumbnailTimestampPct->toBe(0.0)
                ->readyToStream->toBeTrue()
                ->readyToStreamAt->toBeInstanceOf(DateTimeImmutable::class)
                ->status->toBeInstanceOf(VideoStatus::class)
                ->meta->toBeArray()
                ->created->toBeInstanceOf(DateTimeImmutable::class)
                ->modified->toBeInstanceOf(DateTimeImmutable::class)
                ->scheduledDeletion->toBeInstanceOf(DateTimeImmutable::class)
                ->size->toBe(0)
                ->preview->toBe('https://customer-6xsmv.cloudflarestream.com/a0587f7fe8e9bc851c75183831a2eb3c/watch')
                ->allowedOrigins->toBeArray()
                ->requireSignedURLs->toBeFalse()
                ->uploaded->toBeInstanceOf(DateTimeImmutable::class)
                ->uploadExpiry->toBeNull()
                ->maxSizeBytes->toBeNull()
                ->maxDurationSeconds->toBeNull()
                ->duration->toBe(25.0)
                ->input->toBeInstanceOf(Input::class)
                ->input->width->toBe(1280)
                ->input->height->toBe(720)
                ->playback->toBeInstanceOf(Playback::class)
                ->watermark->toBeNull()
                ->liveInput->toBe('aed55c2824e57b715d1254c2e7f47edd')
                ->clippedFrom->toBeNull()
                ->publicDetails->toBeInstanceOf(PublicDetails::class),

            fn ($item) => $item
                ->toBeInstanceOf(ListVideoItem::class)
                ->uid->toBe('66a41610bea30a851aa0ebaf9db2d8a4')
                ->thumbnail->toBe('https://customer-6xsmv.cloudflarestream.com/66a41610bea30a851aa0ebaf9db2d8a4/thumbnails/thumbnail.jpg')
                ->thumbnailTimestampPct->toBe(0.0)
                ->readyToStream->toBeTrue()
                ->readyToStreamAt->toBeInstanceOf(DateTimeImmutable::class)
                ->status->toBeInstanceOf(VideoStatus::class)
                ->meta->toBeArray()
                ->created->toBeInstanceOf(DateTimeImmutable::class)
                ->modified->toBeInstanceOf(DateTimeImmutable::class)
                ->scheduledDeletion->toBeInstanceOf(DateTimeImmutable::class)
                ->size->toBe(0)
                ->preview->toBe('https://customer-6xsmv.cloudflarestream.com/66a41610bea30a851aa0ebaf9db2d8a4/watch')
                ->allowedOrigins->toBeArray()
                ->requireSignedURLs->toBeFalse()
                ->uploaded->toBeInstanceOf(DateTimeImmutable::class)
                ->uploadExpiry->toBeNull()
                ->maxSizeBytes->toBeNull()
                ->maxDurationSeconds->toBeNull()
                ->duration->toBe(33.33)
                ->input->toBeInstanceOf(Input::class)
                ->input->width->toBe(1280)
                ->input->height->toBe(720)
                ->playback->toBeInstanceOf(Playback::class)
                ->watermark->toBeNull()
                ->liveInput->toBe('aed55c2824e57b715d1254c2e7f47edd')
                ->clippedFrom->toBeNull()
                ->publicDetails->toBeInstanceOf(PublicDetails::class),
        );
});

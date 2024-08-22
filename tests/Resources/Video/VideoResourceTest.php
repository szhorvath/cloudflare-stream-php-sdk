<?php

declare(strict_types=1);

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use Nyholm\Psr7\Response;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Token\Token;
use Szhorvath\CloudflareStream\DataObjects\Video\Input;
use Szhorvath\CloudflareStream\DataObjects\Video\ListVideoItem;
use Szhorvath\CloudflareStream\DataObjects\Video\Playback;
use Szhorvath\CloudflareStream\DataObjects\Video\PublicDetails;
use Szhorvath\CloudflareStream\DataObjects\Video\Status as VideoStatus;
use Szhorvath\CloudflareStream\DataObjects\Video\Video;
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

it('should retrieve video details', function () {
    $client = new MockClient;
    $client->addResponse(response(
        name: 'video/retrieve',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $video = $sdk->video()->retrieve(
        accountId: '0a6c8c72a460f78152e767e10842dcb2',
        videoId: 'a0587f7fe8e9bc851c75183831a2eb3c'
    );

    expect($video)
        ->toBeInstanceOf(ApiResponse::class)
        ->result->toBeInstanceOf(Video::class)
        ->total->toBeNull()
        ->range->toBeNull();

    expect($video->result)
        ->uid->toBe('a0587f7fe8e9bc851c75183831a2eb3c')
        ->thumbnail->toBe('https://customer-6xsmv6axkdji7uup.cloudflarestream.com/a0587f7fe8e9bc851c75183831a2eb3c/thumbnails/thumbnail.jpg')
        ->thumbnailTimestampPct->toBe(0.0)
        ->readyToStream->toBeTrue()
        ->readyToStreamAt->toBeInstanceOf(DateTimeImmutable::class)
        ->status->toBeInstanceOf(VideoStatus::class)
        ->meta->toBeArray()
        ->created->toBeInstanceOf(DateTimeImmutable::class)
        ->modified->toBeInstanceOf(DateTimeImmutable::class)
        ->scheduledDeletion->toBeInstanceOf(DateTimeImmutable::class)
        ->size->toBe(0)
        ->preview->toBe('https://customer-6xsmv6axkdji7uup.cloudflarestream.com/a0587f7fe8e9bc851c75183831a2eb3c/watch')
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
        ->publicDetails->toBeInstanceOf(PublicDetails::class);
});

it('should delete a video', function () {
    $client = new MockClient;
    $client->addResponse(response(
        name: 'video/retrieve',
        status: Status::NO_CONTENT
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $response = $sdk->video()->delete(
        accountId: '0a6c8c72a460f78152e767e10842dcb2',
        videoId: 'a0587f7fe8e9bc851c75183831a2eb3c'
    );

    expect($response)
        ->toBeInstanceOf(ApiResponse::class)
        ->success->toBeTrue()
        ->result->toBeNull();
});

it('should update a video', function () {
    $client = new MockClient;
    $client->addResponse(response(
        name: 'video/update',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $response = $sdk->video()->update(
        accountId: '0a6c8c72a460f78152e767e10842dcb2',
        videoId: 'a0587f7fe8e9bc851c75183831a2eb3c',
        data: [
            'meta' => ['key' => 'value'],
            'requireSignedURLs' => true,
        ]
    );

    expect($response)
        ->toBeInstanceOf(ApiResponse::class)
        ->result->toBeInstanceOf(Video::class)
        ->total->toBeNull()
        ->range->toBeNull();

    expect($response->result)
        ->uid->toBe('a0587f7fe8e9bc851c75183831a2eb3c')
        ->thumbnail->toBe('https://customer-6xsmv6axkdji7uup.cloudflarestream.com/a0587f7fe8e9bc851c75183831a2eb3c/thumbnails/thumbnail.jpg')
        ->thumbnailTimestampPct->toBe(0.0)
        ->readyToStream->toBeTrue()
        ->readyToStreamAt->toBeInstanceOf(DateTimeImmutable::class)
        ->status->toBeInstanceOf(VideoStatus::class)
        ->meta->toBeArray()->toBe(['key' => 'value'])
        ->created->toBeInstanceOf(DateTimeImmutable::class)
        ->modified->toBeInstanceOf(DateTimeImmutable::class)
        ->scheduledDeletion->toBeInstanceOf(DateTimeImmutable::class)
        ->size->toBe(0)
        ->preview->toBe('https://customer-6xsmv6axkdji7uup.cloudflarestream.com/a0587f7fe8e9bc851c75183831a2eb3c/watch')
        ->allowedOrigins->toBeArray()
        ->requireSignedURLs->toBeTrue()
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
        ->publicDetails->toBeNull();
});

it('should upload a video from URL', function () {
    $client = new MockClient;
    $client->addResponse(response(
        name: 'video/upload-from-url',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $response = $sdk->video()->uploadFromURL(
        accountId: '0a6c8c72a460f78152e767e10842dcb2',
        data: [
            'url' => 'https://example.com/video.mp4',
            'creator' => 'John Doe',
            'meta' => [
                'name' => 'Big Buck Bunny',
                'extra' => 'value',
            ],
            'requireSignedURLs' => false,
            'scheduledDeletion' => '2024-12-01T00:00:00Z',
            'thumbnailTimestampPct' => 0,
        ],
    );

    expect($response)
        ->toBeInstanceOf(ApiResponse::class)
        ->result->toBeInstanceOf(Video::class)
        ->total->toBeNull()
        ->range->toBeNull();

    expect($response->result)
        ->uid->toBe('143aaa0e8af3ed7d7f6cd173e5e01e6b')
        ->thumbnail->toBe('https://customer-6xsmv6axkdji7uup.cloudflarestream.com/143aaa0e8af3ed7d7f6cd173e5e01e6b/thumbnails/thumbnail.jpg')
        ->thumbnailTimestampPct->toBe(0.0)
        ->readyToStream->toBeFalse()
        ->readyToStreamAt->toBeNull()
        ->status->toBeInstanceOf(VideoStatus::class)
        ->meta->toBeArray()->toBe([
            'downloaded-from' => 'https://example.com/video.mp4',
            'extra' => 'value',
            'name' => 'Big Buck Bunny',
        ])
        ->created->toBeInstanceOf(DateTimeImmutable::class)
        ->modified->toBeInstanceOf(DateTimeImmutable::class)
        ->scheduledDeletion->toBeInstanceOf(DateTimeImmutable::class)
        ->size->toBe(158008374)
        ->preview->toBe('https://customer-6xsmv6axkdji7uup.cloudflarestream.com/143aaa0e8af3ed7d7f6cd173e5e01e6b/watch')
        ->allowedOrigins->toBeArray()
        ->requireSignedURLs->toBeTrue()
        ->uploaded->toBeInstanceOf(DateTimeImmutable::class)
        ->uploadExpiry->toBeNull()
        ->maxSizeBytes->toBeNull()
        ->maxDurationSeconds->toBeNull()
        ->duration->toBe(-1.0)
        ->input->toBeInstanceOf(Input::class)
        ->input->width->toBe(-1)
        ->input->height->toBe(-1)
        ->playback->toBeInstanceOf(Playback::class)
        ->watermark->toBeNull()
        ->liveInput->toBeNull()
        ->clippedFrom->toBeNull()
        ->publicDetails->toBeNull();
});

it('should create a signed URL token for videos', function () {
    $client = new MockClient;
    $client->addResponse(response(
        name: 'video/signed-url-token',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $response = $sdk->video()->createToken(
        accountId: '0a6c8c72a460f78152e767e10842dcb2',
        videoId: 'd98633da6f5ab948d6aca407190c8b7b',
    );

    expect($response)
        ->toBeInstanceOf(ApiResponse::class)
        ->success->toBeTrue()
        ->result->toBeInstanceOf(Token::class)
        ->result->token->toBe('eyJhbGciOiJSUzI1NiIsImtpZCI6ImMzY2M0NDFiMTlmNDYzYTczNWM2MTk0OTU3NWUxM2Y0In0.eyJzdWIiOiJkOTg2MzNkYTZmNWFiOTQ4ZDZhY2E0MDcxOTBjOGI3YiIsImtpZCI6ImMzY2M0NDFiMTlmNDYzYTczNWM2MTk0OTU3NWUxM2Y0IiwiZXhwIjoiMTcyNDMyNzUyMCIsIm5iZiI6IjE3MjQzMjAzMjAifQ.DQB4odgGXnlDzkBOpkoUi_fTIhNp8_spJUbDub4YJnWVukJzpTZNmTzl8O-5TcfQ5Dxjj15bPQgv5_F4axBnoQWXaCTqq_yXsYhodX0q2hHa4moUkJQevnMfR62h2YZifjX58snZFe60nIocf6YbklfYwb2tDJ4rhPgbd0YqS43vdiWWdm0q7MhXUl6QzSaX21XhO2t0--GOkmaQ3PpmfOJ7yjtTRYuIcVqhOEQN8xCZ5IQhsu793FuVlA_DjnqB41bHfgp1hOfigVekjbD9AiHzxj2gvLvHDuhZqG4KGqldnWHtYEj83Mp1sL75Dc-OsuF10mPtNZKVnxmsba1F7Q');
});

it('should retrieve embed code HTML', function () {
    $client = new MockClient;
    $client->addResponse(new Response(
        status: 200,
        body: Psr17FactoryDiscovery::findStreamFactory()->createStream(
            '<stream src="d98633da6f5ab948d6aca407190c8b7b"></stream><script data-cfasync="false" defer type="text/javascript" src="https://embed.videodelivery.net/embed/r4xu.fla9.latest.js?video=d98633da6f5ab948d6aca407190c8b7b"></script>',
        )
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $response = $sdk->video()->embed(
        accountId: '0a6c8c72a460f78152e767e10842dcb2',
        videoId: 'd98633da6f5ab948d6aca407190c8b7b',
    );

    expect($response)
        ->toBe('<stream src="d98633da6f5ab948d6aca407190c8b7b"></stream><script data-cfasync="false" defer type="text/javascript" src="https://embed.videodelivery.net/embed/r4xu.fla9.latest.js?video=d98633da6f5ab948d6aca407190c8b7b"></script>');
});

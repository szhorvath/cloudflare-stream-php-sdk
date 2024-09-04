<?php

declare(strict_types=1);

use Http\Mock\Client as MockClient;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Download\DefaultDownload;
use Szhorvath\CloudflareStream\DataObjects\Download\Download;
use Szhorvath\CloudflareStream\Enums\DownloadStatus;
use Szhorvath\CloudflareStream\Resources\Download\DownloadResource;
use Szhorvath\CloudflareStream\StreamSdk;

it('should return the download resource', function () {
    $sdk = new StreamSdk('api-key');

    $output = $sdk->download();

    expect($output)->toBeInstanceOf(DownloadResource::class);
});

it('should create a download', function () {
    $client = new MockClient;
    $client->addResponse(response(
        name: 'download/create',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $response = $sdk->download()->create(
        accountId: '0a6c8c72a460f78152e767e10842dcb2',
        videoId: '143aaa0e8af3ed7d7f6cd173e5e01e6b',
    );

    expect($response)
        ->toBeInstanceOf(ApiResponse::class)
        ->result->toBeInstanceOf(Download::class)
        ->result->default->toBeInstanceOf(DefaultDownload::class)
        ->result->default->url->toBe('https://customer-6xsmv6axkdji7uup.cloudflarestream.com/88cd0e5f454333c4de66f0f61399f067/downloads/default.mp4')
        ->result->default->status->toBeInstanceOf(DownloadStatus::class)
        ->result->default->status->value->toBe('inprogress')
        ->result->default->percentComplete->toBe(0);
});

it('should list downloads', function () {
    $client = new MockClient;
    $client->addResponse(response(
        name: 'download/list',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $response = $sdk->download()->list(
        accountId: '0a6c8c72a460f78152e767e10842dcb2',
        videoId: '143aaa0e8af3ed7d7f6cd173e5e01e6b',
    );

    expect($response)
        ->toBeInstanceOf(ApiResponse::class)
        ->result->toBeInstanceOf(Download::class)
        ->result->default->toBeInstanceOf(DefaultDownload::class)
        ->result->default->url->toBe('https://customer-6xsmv6axkdji7uup.cloudflarestream.com/6f3dd7af6bf5b6067f3a712f50937bd1/downloads/default.mp4')
        ->result->default->status->toBeInstanceOf(DownloadStatus::class)
        ->result->default->status->value->toBe('ready')
        ->result->default->percentComplete->toBe(100);
});

it('should delete a download', function () {
    $client = new MockClient;
    $client->addResponse(response(
        name: 'download/delete',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $response = $sdk->download()->delete(
        accountId: '0a6c8c72a460f78152e767e10842dcb2',
        videoId: '143aaa0e8af3ed7d7f6cd173e5e01e6b',
    );

    expect($response)
        ->toBeInstanceOf(ApiResponse::class)
        ->result->toBeNull();
});

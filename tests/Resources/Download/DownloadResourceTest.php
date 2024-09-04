<?php

declare(strict_types=1);

use Http\Mock\Client as MockClient;
use Szhorvath\CloudflareStream\StreamSdk;
use Szhorvath\CloudflareStream\Enums\DownloadStatus;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Download\Download;
use Szhorvath\CloudflareStream\Resources\Download\DownloadResource;
use Szhorvath\CloudflareStream\DataObjects\Download\DefaultDownload;

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
        videoId: '6f3dd7af6bf5b6067f3a712f50937bd1',
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

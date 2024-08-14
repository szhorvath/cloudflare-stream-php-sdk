<?php

declare(strict_types=1);

use Http\Mock\Client as MockClient;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\Enums\Status;
use Szhorvath\CloudflareStream\Resources\Webhook\WebhookResource;
use Szhorvath\CloudflareStream\StreamSdk;

it('should return the webhook resource', function () {
    $sdk = new StreamSdk('api-key');

    $output = $sdk->webhook();

    expect($output)->toBeInstanceOf(WebhookResource::class);
});

it('should verify token validity', function () {
    $client = new MockClient;
    $client->addResponse(response(
        status: Status::OK,
        name: 'webhook/create',
    ));

    $sdk = new StreamSdk(
        token: '123',
        clientBuilder: mockBuilder($client)
    );

    $webhook = $sdk->webhook()->create(
        accountId: '0a6c8c72a460f78152e767e10842dcb2',
        data: [
            'notificationUrl' => 'https://example.com/webhook',
        ]
    );

    expect($webhook)
        ->toBeInstanceOf(ApiResponse::class)
        ->success->toBeTrue();

    expect($webhook->result)
        ->notificationUrl->toBe('https://example.com/webhook')
        ->notification_url->toBe('https://example.com/webhook')
        ->secret->toBe('e853f3bd4563a66c86979cd584f08eb3c72ddd75')
        ->modified->toBeInstanceOf(DateTimeImmutable::class)
        ->modified->format('Y-m-d H:i:s')->toBe('2024-08-14 09:13:00');
});

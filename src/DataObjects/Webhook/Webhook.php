<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Webhook;

use DateTimeImmutable;
use Szhorvath\CloudflareStream\Contracts\ResultContract;
use Szhorvath\CloudflareStream\DataObjects\Concerns\CanBeHydrated;

class Webhook implements ResultContract
{
    use CanBeHydrated;

    public function __construct(
        public readonly string $notification_url,
        public readonly string $notificationUrl,
        public readonly DateTimeImmutable $modified,
        public readonly string $secret,
    ) {}
}

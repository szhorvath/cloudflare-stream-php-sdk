<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\SigningKey;

use DateTimeImmutable;
use Szhorvath\CloudflareStream\Contracts\ResultContract;
use Szhorvath\CloudflareStream\DataObjects\Concerns\CanBeHydrated;

class Key implements ResultContract
{
    use CanBeHydrated;

    public function __construct(
        public readonly string $id,
        public readonly string $jwk,
        public readonly string $pem,
        public readonly DateTimeImmutable $created,
    ) {}
}

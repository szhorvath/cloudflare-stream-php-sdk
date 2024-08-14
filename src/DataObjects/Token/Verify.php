<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Token;

use Szhorvath\CloudflareStream\Contracts\ResultContract;
use Szhorvath\CloudflareStream\DataObjects\Concerns\CanBeHydrated;

class Verify implements ResultContract
{
    use CanBeHydrated;

    public function __construct(
        public readonly string $id,
        public readonly string $status,
    ) {}
}

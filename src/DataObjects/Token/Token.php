<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Token;

use Szhorvath\CloudflareStream\Contracts\ResultContract;
use Szhorvath\CloudflareStream\DataObjects\Concerns\CanBeHydrated;

class Token implements ResultContract
{
    use CanBeHydrated;

    public function __construct(
        public readonly string $token,
    ) {}
}

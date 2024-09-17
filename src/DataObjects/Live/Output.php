<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Live;

use Szhorvath\CloudflareStream\Contracts\ResultContract;
use Szhorvath\CloudflareStream\DataObjects\Concerns\CanBeHydrated;

/**
 * @implements ResultContract<Output>
 */
class Output implements ResultContract
{
    use CanBeHydrated;

    public function __construct(
        public readonly string $uid,
        public readonly string $url,
        public readonly string $streamKey,
        public readonly bool $enabled,
        public readonly ?InputStatus $status = null,
    ) {}
}

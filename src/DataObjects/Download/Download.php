<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Download;

use Szhorvath\CloudflareStream\Contracts\ResultContract;
use Szhorvath\CloudflareStream\DataObjects\Concerns\CanBeHydrated;

/**
 * @implements ResultContract<Download>
 */
class Download implements ResultContract
{
    use CanBeHydrated;

    public function __construct(
        public readonly ?DefaultDownload $default,
    ) {}
}

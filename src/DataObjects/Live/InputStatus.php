<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Live;

class InputStatus
{
    /**
     * @param  InputStatusHistory[]  $history
     */
    public function __construct(
        public readonly ?InputStatusCurrent $current,
        public readonly array $history,
    ) {}
}

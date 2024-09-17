<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\SigningKey;

use DateTimeImmutable;
use Szhorvath\CloudflareStream\Contracts\ResultContract;
use Szhorvath\CloudflareStream\DataObjects\Concerns\CanBeHydrated;

/**
 * @implements ResultContract<ListKeyItem>
 */
class ListKeyItem implements ResultContract
{
    use CanBeHydrated;

    public function __construct(
        public string $id,
        public string $key_id,
        public DateTimeImmutable $created
    ) {}
}

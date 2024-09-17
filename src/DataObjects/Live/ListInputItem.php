<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Live;

use DateTimeImmutable;
use League\ObjectMapper\PropertyCasters\CastToType;
use Szhorvath\CloudflareStream\Contracts\ResultContract;
use Szhorvath\CloudflareStream\DataObjects\Concerns\CanBeHydrated;

/**
 * @implements ResultContract<ListInputItem>
 */
class ListInputItem implements ResultContract
{
    use CanBeHydrated;

    /**
     * @param  array<string,mixed>  $meta
     */
    public function __construct(
        public readonly string $uid,
        public readonly DateTimeImmutable $created,
        public readonly DateTimeImmutable $modified,
        public readonly array $meta,
        #[CastToType('integer')]
        public readonly ?int $deleteRecordingAfterDays,
    ) {}
}

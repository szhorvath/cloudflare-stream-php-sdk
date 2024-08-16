<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Video;

use Szhorvath\CloudflareStream\Contracts\ResultContract;

class Videos implements ResultContract
{
    public function __construct(
        public readonly VideoCollection $videos,
        public readonly ?int $total,
        public readonly ?int $range,
    ) {}

    /**
     * @param  array<string,mixed>  $data
     */
    public static function from(array $data): self
    {
        return new self(
            videos: VideoCollection::from($data['videos'] ?? $data),
            total: $data['total'] ?? null,
            range: $data['range'] ?? null,
        );
    }
}

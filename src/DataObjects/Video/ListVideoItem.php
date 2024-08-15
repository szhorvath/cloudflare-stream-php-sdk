<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Video;

use DateTimeImmutable;
use Szhorvath\CloudflareStream\Contracts\ResultContract;
use Szhorvath\CloudflareStream\DataObjects\Concerns\CanBeHydrated;

class ListVideoItem implements ResultContract
{
    use CanBeHydrated;

    /**
     * @param  array<string,mixed>  $meta
     */
    public function __construct(
        public string $uid,
        public ?string $creator,
        public string $thumbnail,
        public float $thumbnailTimestampPct,
        public bool $readyToStream,
        public DateTimeImmutable $readyToStreamAt,
        public ?Status $status,
        public array $meta,
        public DateTimeImmutable $created,
        public DateTimeImmutable $modified,
        public ?DateTimeImmutable $scheduledDeletion,
        public int $size,
        public string $preview,
        public array $allowedOrigins,
        public bool $requireSignedURLs,
        public ?DateTimeImmutable $uploaded,
        public ?DateTimeImmutable $uploadExpiry,
        public ?int $maxSizeBytes,
        public ?int $maxDurationSeconds,
        public float $duration,
        public Input $input,
        public Playback $playback,
        public ?Watermark $watermark,
        public string $liveInput,
        public ?string $clippedFrom,
        public PublicDetails $publicDetails,
    ) {}
}

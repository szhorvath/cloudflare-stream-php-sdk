<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Live;

use DateTimeImmutable;
use Szhorvath\CloudflareStream\Contracts\ResultContract;
use Szhorvath\CloudflareStream\DataObjects\Concerns\CanBeHydrated;

/**
 * @implements ResultContract<Input>
 */
class Input implements ResultContract
{
    use CanBeHydrated;

    /**
     * @param  array<string, mixed>  $meta
     */
    public function __construct(
        public readonly string $uid,
        public readonly DateTimeImmutable $created,
        public readonly DateTimeImmutable $modified,
        public readonly Recording $recording,
        public readonly Rtmps $rtmps,
        public readonly Rtmps $rtmpsPlayback,
        public readonly Srt $srt,
        public readonly Srt $srtPlayback,
        public readonly WebRTC $webRTC,
        public readonly WebRTC $webRTCPlayback,
        public readonly array $meta,
        public readonly ?string $defaultCreator = null,
        public readonly ?InputStatus $status = null,
        public readonly ?int $deleteRecordingAfterDays = null,
        public readonly bool $preferLowLatency = false,
    ) {}
}

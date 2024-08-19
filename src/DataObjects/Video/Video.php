<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Video;

use DateTimeImmutable;
use Szhorvath\CloudflareStream\Contracts\ResultContract;
use Szhorvath\CloudflareStream\DataObjects\Concerns\CanBeHydrated;

// {
//     "uid": "a0587f7fe8e9bc851c75183831a2eb3c",
//     "creator": null,
//     "thumbnail": "https://customer-6xsmv6axkdji7uup.cloudflarestream.com/a0587f7fe8e9bc851c75183831a2eb3c/thumbnails/thumbnail.jpg",
//     "thumbnailTimestampPct": 0,
//     "readyToStream": true,
//     "readyToStreamAt": "2024-08-14T14:35:39.11435Z",
//     "status": {
//         "state": "ready",
//         "pctComplete": "100.000000",
//         "errorReasonCode": "",
//         "errorReasonText": ""
//     },
//     "meta": {
//         "name": "rupert-test-b869 14 Aug 24 14:34 UTC"
//     },
//     "created": "2024-08-14T14:34:51.294025Z",
//     "modified": "2024-08-14T14:35:39.112868Z",
//     "scheduledDeletion": "2024-09-13T14:35:00Z",
//     "size": 0,
//     "preview": "https://customer-6xsmv6axkdji7uup.cloudflarestream.com/a0587f7fe8e9bc851c75183831a2eb3c/watch",
//     "allowedOrigins": [],
//     "requireSignedURLs": false,
//     "uploaded": "2024-08-14T14:34:51.294018Z",
//     "uploadExpiry": null,
//     "maxSizeBytes": null,
//     "maxDurationSeconds": null,
//     "duration": 25,
//     "input": {
//         "width": 1280,
//         "height": 720
//     },
//     "playback": {
//         "hls": "https://customer-6xsmv6axkdji7uup.cloudflarestream.com/a0587f7fe8e9bc851c75183831a2eb3c/manifest/video.m3u8",
//         "dash": "https://customer-6xsmv6axkdji7uup.cloudflarestream.com/a0587f7fe8e9bc851c75183831a2eb3c/manifest/video.mpd"
//     },
//     "watermark": null,
//     "liveInput": "aed55c2824e57b715d1254c2e7f47edd",
//     "clippedFrom": null,
//     "publicDetails": {
//         "title": "",
//         "share_link": "",
//         "channel_link": "",
//         "logo": ""
//     }
// }
class Video implements ResultContract
{
    use CanBeHydrated;

    /**
     * @param  array<string,mixed>  $meta
     * @param  array<string>  $allowedOrigins
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
        public DateTimeImmutable $uploaded,
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

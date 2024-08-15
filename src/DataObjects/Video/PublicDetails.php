<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Video;

class PublicDetails
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $share_link,
        public readonly ?string $channel_link,
        public readonly ?string $logo,
    ) {}
}

<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Video;

use Illuminate\Support\Collection;
use League\ObjectMapper\Constructor;
use Szhorvath\CloudflareStream\Contracts\ResultContract;

/**
 * @extends \Illuminate\Support\Collection<int, \Szhorvath\CloudflareStream\DataObjects\Video\ListVideoItem>
 */
class VideoCollection extends Collection implements ResultContract
{
    protected $type = ListVideoItem::class;

    /**
     * @param  array<string, mixed>  $data
     * @return VideoCollection<int, \Szhorvath\CloudflareStream\DataObjects\Video\ListVideoItem>
     */
    #[Constructor]
    public static function from(array $data): self
    {
        return (new self($data))->map(fn ($item) => ListVideoItem::from($item));
    }
}

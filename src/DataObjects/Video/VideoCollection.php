<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Video;

use Illuminate\Support\Collection;
use League\ObjectMapper\Constructor;
use Szhorvath\CloudflareStream\Contracts\ResultContract;

/**
 * @extends \Illuminate\Support\Collection<int,ListVideoItem>
 */
class VideoCollection extends Collection implements ResultContract
{
    /**
     * @param  array<int, mixed>  $data
     * @return VideoCollection<int,ListVideoItem>
     */
    #[Constructor]
    public static function from(array $data): VideoCollection
    {
        $items = array_map(fn (array $item) => ListVideoItem::from($item), $data);

        return new VideoCollection($items);
    }
}

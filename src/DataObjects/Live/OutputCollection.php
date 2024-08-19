<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Live;

use Illuminate\Support\Collection;
use League\ObjectMapper\Constructor;
use Szhorvath\CloudflareStream\Contracts\ResultContract;

/**
 * @extends \Illuminate\Support\Collection<int,ListOutputItem>
 */
class OutputCollection extends Collection implements ResultContract
{
    /**
     * @param  array<int, mixed>  $data
     * @return OutputCollection<int,ListOutputItem>
     */
    #[Constructor]
    public static function from(array $data): OutputCollection
    {
        $items = array_map(fn (array $item) => ListOutputItem::from($item), $data);

        return new OutputCollection($items);
    }
}

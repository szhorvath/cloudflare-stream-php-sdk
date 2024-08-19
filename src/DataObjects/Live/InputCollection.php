<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Live;

use Illuminate\Support\Collection;
use League\ObjectMapper\Constructor;
use Szhorvath\CloudflareStream\Contracts\ResultContract;

/**
 * @extends \Illuminate\Support\Collection<int, ListInputItem>
 */
class InputCollection extends Collection implements ResultContract
{
    /**
     * @param  array<int, mixed>  $data
     * @return InputCollection<int, ListInputItem>
     */
    #[Constructor]
    public static function from(array $data): InputCollection
    {
        $items = array_map(fn (array $item) => ListInputItem::from($item), $data);

        return new InputCollection($items);
    }
}

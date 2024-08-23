<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\SigningKey;

use Illuminate\Support\Collection;
use League\ObjectMapper\Constructor;
use Szhorvath\CloudflareStream\Contracts\ResultContract;

/**
 * @extends \Illuminate\Support\Collection<int, ListKeyItem>
 */
class KeyCollection extends Collection implements ResultContract
{
    /**
     * @param  array<int, mixed>  $data
     * @return KeyCollection<int, ListKeyItem>
     */
    #[Constructor]
    public static function from(array $data): KeyCollection
    {
        $items = array_map(fn (array $item) => ListKeyItem::from($item), $data);

        return new KeyCollection($items);
    }
}

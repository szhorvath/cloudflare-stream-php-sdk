<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Live;

use Illuminate\Support\Collection;
use League\ObjectMapper\Constructor;
use Szhorvath\CloudflareStream\Contracts\ResultContract;

/**
 * @extends \Illuminate\Support\Collection<int, \Szhorvath\CloudflareStream\DataObjects\ListOutputItem>
 */
class OutputCollection extends Collection implements ResultContract
{
    protected $type = ListOutputItem::class;

    /**
     * @param  array<string, mixed>  $data
     * @return \Szhorvath\CloudflareStream\DataObjects\OutputCollection<int, \Szhorvath\CloudflareStream\DataObjects\ListOutputItem>
     */
    #[Constructor]
    public static function from(array $data): self
    {
        return (new self($data))->map(fn ($item) => ListOutputItem::from($item));
    }
}

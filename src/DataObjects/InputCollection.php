<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects;

use Illuminate\Support\Collection;
use League\ObjectMapper\Constructor;
use Szhorvath\CloudflareStream\Contracts\ResultContract;

/**
 * @extends \Illuminate\Support\Collection<int, \Szhorvath\CloudflareStream\DataObjects\Input>
 */
class InputCollection extends Collection implements ResultContract
{
    protected $type = Input::class;

    /**
     * @param  array<string, mixed>  $data
     * @return \Szhorvath\CloudflareStream\DataObjects\InputCollection<int, \Szhorvath\CloudflareStream\DataObjects\Input>
     */
    #[Constructor]
    public static function from(array $data): self
    {
        return (new self($data))->map(fn ($item) => Input::from($item));
    }
}

<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Contracts;

/**
 * @template TResult of object
 */
interface ResultContract
{
    /**
     * @param  array<string,mixed>  $data
     * @return TResult
     */
    public static function from(array $data): object;
}

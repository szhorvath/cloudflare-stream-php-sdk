<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Contracts;

interface ResultContract
{
    /**
     * @param  array<string,mixed>  $data
     */
    public static function from(array $data): ResultContract;
}

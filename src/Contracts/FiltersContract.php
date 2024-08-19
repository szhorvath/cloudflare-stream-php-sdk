<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use Psr\Http\Message\RequestInterface;

/**
 * @extends Arrayable<int, \Szhorvath\CloudflareStream\Filters\Filter>
 */
interface FiltersContract extends Arrayable
{
    public function applyTo(RequestInterface $request): RequestInterface;

    public function add(\Szhorvath\CloudflareStream\Filters\Filter $filter): self;

    public function remove(\Szhorvath\CloudflareStream\Filters\Filter $filter): self;
}

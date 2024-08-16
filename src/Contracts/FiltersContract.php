<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use Psr\Http\Message\RequestInterface;
use Szhorvath\CloudflareStream\Filters\Filter;

interface FiltersContract extends Arrayable
{
    /**
     * @param  \Illuminate\Contracts\Support\Arrayable<int, Filter>|null  $filters
     * @return static<int, Filter>
     */
    public static function make(array $filters = []): static;

    public function applyTo(RequestInterface $request): RequestInterface;

    public function add(Filter $filter): self;

    public function remove(Filter $filter): self;

    public function toArray(): array;
}

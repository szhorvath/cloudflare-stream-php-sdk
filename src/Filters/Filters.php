<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Filters;

use Psr\Http\Message\RequestInterface;
use Szhorvath\CloudflareStream\Contracts\FiltersContract;

abstract class Filters implements FiltersContract
{
    /**
     * @param  array<int,Filter>  $filters
     */
    private array $filters = [];

    /**
     * @param  array<int,Filter>  $filters
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @param  array<int,Filter>  $filters
     * @return static<int,Filter>
     */
    public static function make(array $filters = []): static
    {
        return new static($filters);
    }

    public function applyTo(RequestInterface $request): RequestInterface
    {
        return $request->withUri(
            uri: $request->getUri()->withQuery(
                query: $this->toString()
            ),
            preserveHost: true
        );
    }

    public function add(Filter $filter): self
    {
        $this->filters[] = $filter;

        return $this;
    }

    public function remove(Filter $filter): self
    {
        $this->filters = array_filter(
            $this->filters,
            fn (Filter $f) => $f->name() !== $filter->name()
        );

        return $this;
    }

    public function clear(): self
    {
        $this->filters = [];

        return $this;
    }

    public function all(): array
    {
        return $this->filters;
    }

    public function count(): int
    {
        return count($this->filters);
    }

    public function isEmpty(): bool
    {
        return empty($this->filters);
    }

    public function toArray(): array
    {
        return array_reduce(
            array: $this->filters,
            callback: fn (array $carry, Filter $filter) => array_merge($carry, $filter->toArray()),
            initial: []
        );
    }

    public function toString(): string
    {
        return http_build_query(
            data: $this->toArray(),
            encoding_type: PHP_QUERY_RFC3986,
        );
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}

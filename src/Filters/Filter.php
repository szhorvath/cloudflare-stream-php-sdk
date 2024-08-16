<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Filters;

use Illuminate\Contracts\Support\Arrayable;

class Filter implements Arrayable
{
    public function __construct(
        private readonly string $name,
        private readonly mixed $value,
    ) {}

    public function name(): string
    {
        return $this->name;
    }

    public function value(): mixed
    {
        return $this->value;
    }

    public function toQueryParam(): string
    {
        return "{$this->name}={$this->value}";
    }

    public function toArray(): array
    {
        return [
            $this->name => $this->value,
        ];
    }
}

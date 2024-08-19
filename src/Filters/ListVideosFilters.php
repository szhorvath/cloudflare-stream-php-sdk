<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Filters;

use DateTimeImmutable;
use Szhorvath\CloudflareStream\Enums\VideoStatus;
use Szhorvath\CloudflareStream\Enums\VideoType;

final class ListVideosFilters extends Filters
{
    /**
     * @param  array<int, \Szhorvath\CloudflareStream\Filters\Filter>|null  $filters
     */
    public static function make(?array $filters = []): self
    {
        return new self($filters);
    }

    public function search(?string $search): self
    {
        $this->add(new Filter('search', $search));

        return $this;
    }

    public function creator(?string $creator): self
    {
        $this->add(new Filter('creator', $creator));

        return $this;
    }

    public function to(?DateTimeImmutable $to): self
    {
        $this->add(new Filter('end', $to->format('Y-m-d\TH:i:s\Z')));

        return $this;
    }

    public function from(?DateTimeImmutable $from): self
    {
        $this->add(new Filter('start', $from->format('Y-m-d\TH:i:s\Z')));

        return $this;
    }

    public function between(?DateTimeImmutable $from, ?DateTimeImmutable $to): self
    {
        $this->from($from);
        $this->to($to);

        return $this;
    }

    public function type(?VideoType $type): self
    {
        $this->add(new Filter('type', $type->value));

        return $this;
    }

    public function status(?VideoStatus $status): self
    {
        $this->add(new Filter('status', $status->value));

        return $this;
    }

    public function withCounts(bool $withCounts = true): self
    {
        $this->add(new Filter('include_counts', $withCounts));

        return $this;
    }

    public function orderByCreation(bool $asc = true): self
    {
        $this->add(new Filter('asc', $asc));

        return $this;
    }
}

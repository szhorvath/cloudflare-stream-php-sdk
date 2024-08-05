<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Concerns;

use League\ObjectMapper\KeyFormatterWithoutConversion;
use League\ObjectMapper\ObjectMapperUsingReflection;
use League\ObjectMapper\ReflectionDefinitionProvider;

trait CanBeHydrated
{
    /**
     * @param  array<string,mixed>  $data
     */
    public static function from(array $data): self
    {
        $mapper = new ObjectMapperUsingReflection(
            definitionProvider: new ReflectionDefinitionProvider(
                keyFormatter: new KeyFormatterWithoutConversion,
            ),
        );

        return $mapper->hydrateObject(
            className: self::class,
            payload: $data,
        );
    }
}

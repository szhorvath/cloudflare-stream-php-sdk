<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects\Casts;

use Attribute;
use League\ObjectMapper\ObjectMapper;
use League\ObjectMapper\PropertyCaster;
use LogicException;

#[Attribute(Attribute::TARGET_PARAMETER)]
class CastInterfaceToType implements PropertyCaster
{
    public function __construct(
        private array $typeToClassMap
    ) {}

    public function cast(mixed $value, ObjectMapper $mapper): mixed
    {
        assert(is_array($value));

        $type = $value['type'] ?? 'unknown';
        unset($value['type']);
        $className = $this->typeToClassMap[$type] ?? null;

        if ($className === null) {
            throw new LogicException("Unable to map type '$type' to class.");
        }

        return $mapper->hydrateObject($className, $value);
    }
}

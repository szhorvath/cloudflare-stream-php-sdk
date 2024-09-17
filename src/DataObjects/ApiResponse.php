<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\DataObjects;

use Illuminate\Support\Collection;
use League\ObjectMapper\Constructor;
use Szhorvath\CloudflareStream\Contracts\ResultContract;

class ApiResponse
{
    /**
     * @param  Collection<int,\Szhorvath\CloudflareStream\DataObjects\Error>  $errors
     * @param  Collection<int,\Szhorvath\CloudflareStream\DataObjects\Message>  $messages
     */
    public function __construct(
        public readonly bool $success,
        public readonly Collection $errors,
        public readonly Collection $messages,
        public readonly ?ResultContract $result = null,
    ) {}

    /**
     * @param  array{success:bool,result:array<string, mixed>|null,messages:array<int,mixed>, errors:array<int, mixed>}  $data
     * @param  class-string<ResultContract>|null  $resultClass
     */
    #[Constructor]
    public static function from(array $data, ?string $resultClass = null): self
    {
        $result = null;
        $errors = array_map(fn ($error) => Error::from($error), $data['errors']);
        $messages = array_map(fn ($message) => Message::from($message), $data['messages']);

        if ($resultClass) {
            if (! is_subclass_of($resultClass, ResultContract::class)) {
                throw new \InvalidArgumentException("The {$resultClass} must implement the ".ResultContract::class);
            }

            $result = $data['result'] ? $resultClass::from($data['result']) : null;
        }

        return new self(
            success: $data['success'],
            result: $result,
            errors: new Collection($errors),
            messages: new Collection($messages)
        );
    }

    public function successful(): bool
    {
        return $this->success;
    }

    public function failed(): bool
    {
        return ! $this->success;
    }

    public function error(): string
    {
        return $this->errors->first()?->message ?? '';
    }

    /**
     * @return Collection<int,string>
     */
    public function errors(): Collection
    {
        return $this->errors->pluck('message');
    }

    public function message(): string
    {
        return $this->messages->first()?->message ?? '';
    }
}

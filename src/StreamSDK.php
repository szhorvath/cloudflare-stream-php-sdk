<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream;

final class StreamSDK
{
    public function __construct(private readonly string $url, private readonly string $token)
    {
        echo 'StreamSDK';
    }

    public function url(): string
    {
        return $this->url;
    }

    public function token(): string
    {
        return $this->token;
    }
}

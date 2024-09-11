<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources;

use Http\Client\Common\HttpMethodsClientInterface;
use Szhorvath\CloudflareStream\Contracts\ResourceContract;
use Szhorvath\CloudflareStream\StreamSdk;

abstract class Resource implements ResourceContract
{
    public function __construct(
        private readonly StreamSdk $sdk,
    ) {}

    public function sdk(): StreamSdk
    {
        return $this->sdk;
    }

    public function client(): HttpMethodsClientInterface
    {
        return $this->sdk->client();
    }
}

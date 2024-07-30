<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Resources;

use Http\Client\Common\HttpMethodsClientInterface;
use Szhorvath\CloudflareStream\StreamSdk;

abstract class Resource
{
    public function __construct(
        protected readonly StreamSdk $sdk,
    ) {}

    public function client(): HttpMethodsClientInterface
    {
        return $this->sdk->client();
    }
}

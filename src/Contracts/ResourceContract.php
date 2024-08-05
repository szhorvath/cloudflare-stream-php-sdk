<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Contracts;

use Http\Client\Common\HttpMethodsClientInterface;

interface ResourceContract
{
    public function client(): HttpMethodsClientInterface;
}

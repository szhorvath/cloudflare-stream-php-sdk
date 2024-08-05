<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\Plugin\RetryPlugin;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\Authentication\Bearer;
use Szhorvath\CloudflareStream\Resources\Live\InputResource;
use Szhorvath\CloudflareStream\Resources\Token\TokenResource;

final class StreamSdk
{
    public function __construct(
        private readonly string $token,
        private readonly string $baseUrl = 'https://api.cloudflare.com/client/v4/',
        private ?ClientBuilder $clientBuilder = null,
    ) {
        $this->clientBuilder = $builder = $clientBuilder ?: new ClientBuilder;

        $builder->addPlugin(new AuthenticationPlugin(new Bearer($this->token)));
        $builder->addPlugin(new BaseUriPlugin(Psr17FactoryDiscovery::findUriFactory()->createUri($baseUrl)));
        $builder->addPlugin(new ErrorPlugin);
        $builder->addPlugin(new RetryPlugin);
    }

    public function clientBuilder(): ClientBuilder
    {
        return $this->clientBuilder;
    }

    public function client(): HttpMethodsClientInterface
    {
        return $this->clientBuilder->httpClient();
    }

    public function token(): TokenResource
    {
        return new TokenResource($this);
    }

    public function inputs(): InputResource
    {
        return new InputResource($this);
    }
}

<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\Plugin\RetryPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Http\Message\Authentication\Bearer;
use Psr\Http\Client\ClientInterface;
use Szhorvath\CloudflareStream\Resources\Token\TokenResource;

final class StreamSdk
{
    public function __construct(
        private readonly string $url,
        private readonly string $token,
        private ?ClientInterface $client = null,
        private array $plugins = [],
    ) {}

    /**
     * @param  array<int, Plugin>  $plugins
     */
    public function withPlugins(array $plugins): self
    {
        $this->plugins = array_merge($this->defaultPlugins(), $plugins);

        return $this;
    }

    public function defaultPlugins(): array
    {
        return [
            new RetryPlugin,
            new ErrorPlugin,
            new AuthenticationPlugin(
                authentication: new Bearer($this->token)
            ),
            new BaseUriPlugin(
                uri: Psr17FactoryDiscovery::findUriFactory()->createUri($this->url)
            ),
        ];
    }

    public function client(): HttpMethodsClientInterface
    {
        $pluginClient = new PluginClient(
            client: $this->client ?? Psr18ClientDiscovery::find(),
            plugins: $this->defaultPlugins(),
        );

        $this->client = new HttpMethodsClient(
            $pluginClient,
            Psr17FactoryDiscovery::findRequestFactory(),
            Psr17FactoryDiscovery::findStreamFactory()
        );

        return $this->client;
    }

    public function setClient(ClientInterface $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function token(): TokenResource
    {
        return new TokenResource($this);
    }
}

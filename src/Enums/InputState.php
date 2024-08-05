<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Enums;

enum InputState: string
{
    case CONNECTED = 'connected';
    case RECONNECTED = 'reconnected';
    case RECONNECTING = 'reconnecting';
    case CLIENT_DISCONNECT = 'client_disconnect';
    case TTL_EXCEEDED = 'ttl_exceeded';
    case FAILED_TO_CONNECT = 'failed_to_connect';
    case FAILED_TO_RECONNECT = 'failed_to_reconnect';
    case NEW_CONFIGURATION_ACCEPTED = 'new_configuration_accepted';
}

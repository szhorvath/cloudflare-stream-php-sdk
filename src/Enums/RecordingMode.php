<?php

declare(strict_types=1);

namespace Szhorvath\CloudflareStream\Enums;

enum RecordingMode: string
{
    case OFF = 'off';
    case AUTOMATIC = 'automatic';
}

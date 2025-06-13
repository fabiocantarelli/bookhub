<?php

declare(strict_types=1);

namespace App\Enum;

Enum FlashTypeEnum: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
}
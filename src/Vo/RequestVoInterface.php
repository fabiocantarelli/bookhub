<?php

declare(strict_types=1);

namespace App\Vo;

use Symfony\Component\HttpFoundation\Request;

interface RequestVoInterface
{
    public static function buildDataFromRequest(Request $request): static;
}

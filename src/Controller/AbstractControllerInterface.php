<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface AbstractControllerInterface
{

    public function list(): Response;
    public function new(Request $request): Response;
    public function edit(int $id, Request $request): Response;
    public function delete(Request $request): Response;
}
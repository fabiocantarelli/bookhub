<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface AbstractCrudControllerInterface
{
    public function index(): Response;
    public function new(Request $request): Response;
    public function edit(Request $request): Response;
    public function delete(Request $request): Response;
}
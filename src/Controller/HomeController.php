<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_home_')]
final class HomeController extends AbstractController
{
    #[Route('/', name: 'show')]
    public function show(): Response
    {
        return $this->render('home/show.html.twig', [
            'title' => 'Home'
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Controller;

use App\Enum\FlashTypeEnum;
use App\Services\AuthorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/author', name: 'app_author_')]
final class AuthorController extends AbstractController implements CrudControllerInterface
{
    public function __construct(
        private readonly AuthorService $authorService
    ) {
    }

    #[Route('/', name: 'index', methods: [Request::METHOD_GET])]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', $this->authorService->list());
    }

    #[Route('/', name: 'new', methods: [Request::METHOD_POST])]
    public function new(Request $request): Response
    {
        try {
            $this->authorService->new($request);
            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Autor inserido com sucesso!');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
        }

        return $this->redirectToRoute('app_author_index');
    }

    #[Route('/{id}', name: 'edit', methods: [Request::METHOD_PUT])]
    public function edit(Request $request): Response
    {
        try {
            $this->authorService->edit($request);
            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Autor editado com sucesso!');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
        }

        return $this->redirectToRoute('app_author_index');
    }

    #[Route('/{id}', name: 'delete', methods: [Request::METHOD_DELETE])]
    public function delete(Request $request): Response
    {
        try {
            $this->authorService->delete($request);
            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Autor deletado com sucesso!');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
        }

        return $this->redirectToRoute('app_author_index');
    }
}

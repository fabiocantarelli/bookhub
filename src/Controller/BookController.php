<?php

declare(strict_types=1);

namespace App\Controller;

use App\Enum\FlashTypeEnum;
use App\Services\BookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/book', name: 'app_book_')]
final class BookController extends AbstractController implements CrudControllerInterface
{
    public function __construct(
        private readonly BookService $bookService,
    ) {
    }

    #[Route('/', name: 'index', methods: [Request::METHOD_GET])]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', $this->bookService->list());
    }

    #[Route('/', name: 'new', methods: [Request::METHOD_POST])]
    public function new(Request $request): Response
    {
        try {
            $this->bookService->new($request);
            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Livro inserido com sucesso!');
            return $this->redirectToRoute('app_book_index');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
            return $this->redirectToRoute('app_book_index');
        }
    }

    #[Route('/{id}', name: 'edit', methods: [Request::METHOD_PUT])]
    public function edit(Request $request): Response
    {
        try {
            $this->bookService->edit($request);
            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Livro editado com sucesso!');
            return $this->redirectToRoute('app_book_index');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
            return $this->redirectToRoute('app_book_index');
        }
    }

    #[Route('/{id}', name: 'delete', methods: [Request::METHOD_DELETE])]
    public function delete(Request $request): Response
    {
        try {
            $this->bookService->delete($request);
            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Livro deletado com sucesso!');
            return $this->redirectToRoute('app_book_index');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
            return $this->redirectToRoute('app_book_index');
        }
    }
}

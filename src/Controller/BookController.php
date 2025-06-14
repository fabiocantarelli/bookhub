<?php

declare(strict_types=1);

namespace App\Controller;

use App\Enum\FlashTypeEnum;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use App\Repository\SubjectRepository;
use App\Validator\BookRequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/book', name: 'app_book_')]
final class BookController extends AbstractController implements AbstractCrudControllerInterface
{
    public function __construct(
        private readonly BookRepository $bookRepository,
        private readonly AuthorRepository $authorRepository,
        private readonly SubjectRepository $subjectRepository,
        private readonly BookRequestValidator $bookRequestValidator,
    ) {
    }

    #[Route('/', name: 'index', methods: [Request::METHOD_GET])]
    public function index(): Response
    {
        $books = $this->bookRepository->findAll();
        $authors = $this->authorRepository->findAll();
        $subjects = $this->subjectRepository->findAll();

        return $this->render('book/index.html.twig', [
            'title' => 'Livros',
            'books' => $books,
            'authors' => $authors,
            'subjects' => $subjects,

        ]);
    }

    #[Route('/', name: 'new', methods: [Request::METHOD_POST])]
    public function new(Request $request): Response
    {
        try {
            $bookDto = $this->bookRequestValidator->validateNewRequest($request);

            $this->bookRepository->save($bookDto);

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
            $bookDto = $this->bookRequestValidator->validateEditRequest($request);

            $this->bookRepository->update($bookDto);

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
            $bookDto = $this->bookRequestValidator->validateDeleteRequest($request);

            $this->bookRepository->delete($bookDto);

            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Livro deletado com sucesso!');
            return $this->redirectToRoute('app_book_index');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
            return $this->redirectToRoute('app_book_index');
        }
    }
}

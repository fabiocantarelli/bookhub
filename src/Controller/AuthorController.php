<?php

declare(strict_types=1);

namespace App\Controller;

use App\Enum\FlashTypeEnum;
use App\Repository\AuthorRepository;
use App\Validator\AuthorRequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/author', name: 'app_author_')]
final class AuthorController extends AbstractController
{
    public function __construct(
        private readonly AuthorRequestValidator $authorRequestValidator,
        private readonly AuthorRepository $authorRepository
    ) {}

    #[Route('/', name: 'list', methods: [Request::METHOD_GET])]
    public function list(): Response
    {
        $authors = $this->authorRepository->findAll();

        return $this->render('author/list.html.twig', [
            'title' => 'Autor',
            'authors' => $authors,
        ]);
    }

    #[Route('/', name: 'new', methods: [Request::METHOD_POST])]
    public function new(Request $request): Response
    {
        try {
            $authorDto = $this->authorRequestValidator->validateNewRequest($request);

            $this->authorRepository->save($authorDto);

            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Autor inserido com sucesso!');

            return $this->redirectToRoute('app_author_list');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
            return $this->redirectToRoute('app_author_list');
        }
    }

    #[Route('/{id}', name: 'edit', methods: [Request::METHOD_PATCH])]
    public function edit(Request $request): Response
    {
        try {
            $authorDto = $this->authorRequestValidator->validateEditRequest($request);

            $this->authorRepository->update($authorDto);

            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Autor editado com sucesso!');
            return $this->redirectToRoute('app_author_list');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
            return $this->redirectToRoute('app_author_list');
        }
    }

    #[Route('/{id}/delete', name: 'delete', methods: [Request::METHOD_GET])]
    public function delete(Request $request): Response
    {
        try {
            $authorDto = $this->authorRequestValidator->validateDeleteRequest($request);

            $this->authorRepository->delete($authorDto);

            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Autor deletado com sucesso!');
            return $this->redirectToRoute('app_author_list');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
            return $this->redirectToRoute('app_author_list');
        }
    }
}

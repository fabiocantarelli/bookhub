<?php

declare(strict_types=1);

namespace App\Controller;

use App\Vo\AuthorVo;
use App\Enum\FlashTypeEnum;
use App\Repository\AuthorRepository;
use App\Validator\AuthorRequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/author', name: 'app_author_')]
final class AuthorController extends AbstractController implements AbstractCrudControllerInterface
{
    public function __construct(
        private readonly AuthorRequestValidator $authorRequestValidator,
        private readonly AuthorRepository $authorRepository
    ) {
    }

    #[Route('/', name: 'index', methods: [Request::METHOD_GET])]
    public function index(): Response
    {
        $authors = $this->authorRepository->findAll();

        return $this->render('author/index.html.twig', [
            'title' => 'Autor',
            'authors' => $authors,
        ]);
    }

    #[Route('/', name: 'new', methods: [Request::METHOD_POST])]
    public function new(Request $request): Response
    {
        try {
            $this->authorRequestValidator->validateNewRequest($request);
            $authorVo = AuthorVo::buildDataFromRequest($request);
            $this->authorRepository->save($authorVo);
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
            $this->authorRequestValidator->validateEditRequest($request);
            $authorVo = AuthorVo::buildDataFromRequest($request);
            $this->authorRepository->update($authorVo);
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
            $this->authorRequestValidator->validateDeleteRequest($request);
            $authorVo = AuthorVo::buildDataFromRequest($request);
            $this->authorRepository->delete($authorVo);
            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Autor deletado com sucesso!');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
        }

        return $this->redirectToRoute('app_author_index');
    }
}

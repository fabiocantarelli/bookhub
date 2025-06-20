<?php

declare(strict_types=1);

namespace App\Controller;

use App\Vo\SubjectVo;
use App\Enum\FlashTypeEnum;
use App\Repository\SubjectRepository;
use App\Services\SubjectService;
use App\Validator\SubjectRequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/subject', name: 'app_subject_')]
final class SubjectController extends AbstractController implements CrudControllerInterface
{
    public function __construct(
        private readonly SubjectService $subjectService
    ) {
    }

    #[Route('/', name: 'index', methods: [Request::METHOD_GET])]
    public function index(): Response
    {
        return $this->render('subject/index.html.twig', $this->subjectService->list());
    }

    #[Route('/', name: 'new', methods: [Request::METHOD_POST])]
    public function new(Request $request): Response
    {
        try {
            $this->subjectService->new($request);
            return $this->redirectToRoute('app_subject_index');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
            return $this->redirectToRoute('app_subject_index');
        }
    }

    #[Route('/{id}', name: 'edit', methods: [Request::METHOD_PUT])]
    public function edit(Request $request): Response
    {
        try {
            $this->subjectService->edit($request);
            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Assunto editado com sucesso!');
            return $this->redirectToRoute('app_subject_index');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
            return $this->redirectToRoute('app_subject_index');
        }
    }

    #[Route('/{id}', name: 'delete', methods: [Request::METHOD_DELETE])]
    public function delete(Request $request): Response
    {
        try {
            $this->subjectService->delete($request);
            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Livro deletado com sucesso!');
            return $this->redirectToRoute('app_subject_index');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
            return $this->redirectToRoute('app_subject_index');
        }
    }
}

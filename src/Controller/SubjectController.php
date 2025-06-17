<?php

declare(strict_types=1);

namespace App\Controller;

use App\Vo\SubjectVo;
use App\Enum\FlashTypeEnum;
use App\Repository\SubjectRepository;
use App\Validator\SubjectRequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/subject', name: 'app_subject_')]
final class SubjectController extends AbstractController implements AbstractCrudControllerInterface
{
    public function __construct(
        private readonly SubjectRepository $subjectRepository,
        private readonly SubjectRequestValidator $subjectRequestValidator
    ) {
    }

    #[Route('/', name: 'index', methods: [Request::METHOD_GET])]
    public function index(): Response
    {
        $subjects = $this->subjectRepository->findAll();

        return $this->render('subject/index.html.twig', [
            'title' => 'Assunto',
            'subjects' => $subjects,
        ]);
    }

    #[Route('/', name: 'new', methods: [Request::METHOD_POST])]
    public function new(Request $request): Response
    {
        try {
            $this->subjectRequestValidator->validateNewRequest($request);
            $subjectVo = SubjectVo::buildData($request);
            $this->subjectRepository->save($subjectVo);

            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Assunto inserido com sucesso!');

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
            $this->subjectRequestValidator->validateEditRequest($request);
            $subjectVo = SubjectVo::buildData($request);
            $this->subjectRepository->update($subjectVo);

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
            $this->subjectRequestValidator->validateDeleteRequest($request);
            $subjectVo = SubjectVo::buildData($request);
            $this->subjectRepository->delete($subjectVo);

            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Livro deletado com sucesso!');
            return $this->redirectToRoute('app_subject_index');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
            return $this->redirectToRoute('app_subject_index');
        }
    }
}

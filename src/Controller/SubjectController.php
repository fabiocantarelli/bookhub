<?php

declare(strict_types=1);

namespace App\Controller;

use App\Enum\FlashTypeEnum;
use App\Repository\SubjectRepository;
use App\Validator\SubjectRequestValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/subject', name: 'app_subject_')]
final class SubjectController extends AbstractController implements AbstractControllerInterface
{
    public function __construct(
        private readonly SubjectRepository $subjectRepository,
        private readonly SubjectRequestValidator $subjectRequestValidator
    ) {
        
    }

    #[Route('/', name: 'list', methods: [Request::METHOD_GET])]
    public function list(): Response
    {
        $subjects = $this->subjectRepository->findAll();

        return $this->render('subject/list.html.twig', [
            'title' => 'Assunto',
            'controller_name' => 'SubjectController',
            'subjects' => $subjects,
        ]);
    }

    #[Route('/', name: 'new', methods: [Request::METHOD_POST])]
    public function new(Request $request): Response
    {
        try {
            $subjectDto = $this->subjectRequestValidator
                ->validateNewRequest($request);

            $this->subjectRepository->save($subjectDto);

            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Assunto inserido com sucesso!');
        
            return $this->redirectToRoute('app_subject_list');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
            return $this->redirectToRoute('app_subject_list');
        }
    }

    #[Route('/{id}', name: 'edit', methods: [Request::METHOD_PATCH])]
    public function edit(int $id, Request $request): Response
    {
        try {
            $subjectDto = $this->subjectRequestValidator
                ->validateEditRequest($request);

            $this->subjectRepository->update($subjectDto);

            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Assunto editado com sucesso!');
            return $this->redirectToRoute('app_subject_list');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
            return $this->redirectToRoute('app_subject_list');
        }
    }

    #[Route('/{id}/delete', name: 'delete', methods: [Request::METHOD_GET])]
    public function delete(Request $request): Response
    {
        try {
            $subjectDto = $this->subjectRequestValidator
                ->validateDeleteRequest($request);

            $this->subjectRepository->delete($subjectDto);

            $this->addFlash(FlashTypeEnum::SUCCESS->value, 'Livro deletado com sucesso!');
            return $this->redirectToRoute('app_subject_list');
        } catch (\Exception $exception) {
            $this->addFlash(FlashTypeEnum::ERROR->value, $exception->getMessage());
            return $this->redirectToRoute('app_subject_list');
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Validator;

use App\Dto\SubjectDto;
use App\Repository\SubjectRepository;
use Symfony\Component\HttpFoundation\Request;

class SubjectRequestValidator 
{
    private const DESCRIPTION_MAX_LENGTH = 20;

    public function __construct(
        readonly private SubjectRepository $subjectRepository
    ) {
        
    }
    
    public function validateNewRequest(Request $request): SubjectDto
    {
        $this->basicRequestValidate($request);

        $description = $request->get('description');

        return (new SubjectDto)
            ->setDescription($description);
    }

    public function validateEditRequest(Request $request): SubjectDto
    {
        $this->basicRequestValidate($request);

        $id = (int) $request->get('id');
        $description = $request->get('description');

        if (empty($id)) {
            throw new \Exception('Id não informado ou inválido!');
        }

        $findSubject = $this->subjectRepository->findOneBy([
            'description' => $description
        ]);

        if (!empty($findSubject)) {
            throw new \Exception('Descrição já existe!');
        }

        return (new SubjectDto)
            ->setId($id)
            ->setDescription($description);
    }

    public function validateDeleteRequest(Request $request) : SubjectDto 
    {
        $id = (int) $request->get('id');

        if (empty($id)) {
            throw new \Exception('Id não informado ou inválido!');
        }

        $subject = $this->subjectRepository->find($id);

        if (!empty($subject->getBooks()->toArray())) {
            throw new \Exception(
                'Não é possivel remover o assunto, existem livros vinculados a ele!'
            );
        }

        return (new SubjectDto)
            ->setId($id);
    }

    private function basicRequestValidate(Request $request)
    {
        $description = $request->get('description');

        if (empty($description)) {
            throw new \Exception('Você não pode inserir uma descrição vazia!');
        }

        if (mb_strlen($description, 'UTF-8') > self::DESCRIPTION_MAX_LENGTH) {
            throw new \Exception(
                'Você não pode inserir uma descrição maior que ' 
                . self::DESCRIPTION_MAX_LENGTH 
                . ' caracteres'
            );
        }
    }
}
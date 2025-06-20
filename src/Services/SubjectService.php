<?php

declare(strict_types=1);

namespace App\Services;

use App\Validator\SubjectRequestValidator;
use App\Vo\SubjectVo;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Subject;

class SubjectService extends AbstractService
{
    public function __construct(
        EntityManagerInterface $em,
        protected readonly SubjectRequestValidator $subjectRequestValidator
    ) {
        parent::__construct($em);
    }

    /**
     * @return array{title: string, subjects: Subject[]}
     */
    public function list(): array
    {
        return [
            'title' => 'Assunto',
            'subjects' => $this->getSubjectRepository()->findAll(),
        ];
    }

    public function new(Request $request): void
    {
        $this->subjectRequestValidator->validateNewRequest($request);
        $subjectVo = SubjectVo::buildDataFromRequest($request);
        $this->getSubjectRepository()->save($subjectVo);
    }

    public function edit(Request $request): void
    {
        $this->subjectRequestValidator->validateEditRequest($request);
        $subjectVo = SubjectVo::buildDataFromRequest($request);
        $this->getSubjectRepository()->update($subjectVo);
    }

    public function delete(Request $request): void
    {
        $this->subjectRequestValidator->validateDeleteRequest($request);
        $subjectVo = SubjectVo::buildDataFromRequest($request);
        $this->getSubjectRepository()->delete($subjectVo);
    }
}

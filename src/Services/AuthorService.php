<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Author;
use App\Validator\AuthorRequestValidator;
use App\Vo\AuthorVo;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class AuthorService extends AbstractService
{
    public function __construct(
        EntityManagerInterface $em,
        protected readonly AuthorRequestValidator $authorRequestValidator
    ) {
        parent::__construct($em);
    }

    /**
     * @return array{title: string, authors: Author[]}
     */
    public function list(): array
    {
        return [
            'title' => 'Autor',
            'authors' => $this->getAuthorRepository()->findAll(),
        ];
    }

    public function new(Request $request): void
    {
        $this->authorRequestValidator->validateNewRequest($request);
        $authorVo = AuthorVo::buildDataFromRequest($request);
        $this->getAuthorRepository()->save($authorVo);
    }

    public function edit(Request $request): void
    {
        $this->authorRequestValidator->validateEditRequest($request);
        $authorVo = AuthorVo::buildDataFromRequest($request);
        $this->getAuthorRepository()->update($authorVo);
    }

    public function delete(Request $request): void
    {
        $this->authorRequestValidator->validateDeleteRequest($request);
        $authorVo = AuthorVo::buildDataFromRequest($request);
        $this->getAuthorRepository()->delete($authorVo);
    }
}

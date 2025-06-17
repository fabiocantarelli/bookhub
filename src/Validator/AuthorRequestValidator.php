<?php

declare(strict_types=1);

namespace App\Validator;

use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;

class AuthorRequestValidator
{
    private const NAME_MAX_LENGTH = 40;

    public function __construct(
        readonly private AuthorRepository $authorRepository
    ) {
    }

    public function validateNewRequest(Request $request): void
    {
        $name = $request->get('name');
        $this->validateName($name);
    }

    public function validateEditRequest(Request $request): void
    {
        $id = (int) $request->get('id');
        $name = $request->get('name');

        if (empty($id)) {
            throw new \Exception('Id não informado ou inválido!');
        }

        $this->validateName($name, $id);
    }

    public function validateDeleteRequest(Request $request): void
    {
        $id = (int) $request->get('id');

        if (empty($id)) {
            throw new \Exception('Id não informado ou inválido!');
        }

        $author = $this->authorRepository->find($id);

        if (!empty($author->getBooks()->toArray())) {
            throw new \Exception('Não é possivel remover o autor, existem livros vinculados a ele!');
        }
    }

    private function validateName(string $name, ?int $id = null): void
    {
        if (empty($name)) {
            throw new \Exception('Você não pode inserir um nome vazio!');
        }

        if (mb_strlen($name, 'UTF-8') > self::NAME_MAX_LENGTH) {
            throw new \Exception(
                'Você não pode inserir um nome maior que '
                . self::NAME_MAX_LENGTH
                . ' caracteres'
            );
        }

        $findAuthor = $this->authorRepository->findOneBy([
            'name' => $name
        ]);

        if ($findAuthor && $findAuthor->getId() !== $id) {
            throw new \Exception('Autor já existe!');
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Validator;

use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;

final class BookRequestValidator
{
    public const MAX_EDITION = 99999;
    private const TITLE_MAX_LENGTH = 40;
    private const PUBLISHER_MAX_LENGTH = 40;
    private const YEAR_OF_PUBLICATION_MAX_LENGTH = 4;

    public function __construct(
        readonly private BookRepository $bookRepository,
    ) {
    }

    public function validateNewRequest(Request $request): void
    {
        $title = $request->get('title');
        $publisher = $request->get('publisher');
        $edition = (int) $request->get('edition');
        $yearOfPublication = $request->get('yearOfPublication');
        $price = (float) $request->get('price');
        $authorIds = $request->get('authors');
        $subjectIds = $request->get('subjects');

        $this->validateBookData(
            $title,
            $publisher,
            $edition,
            $yearOfPublication,
            $price,
            $authorIds,
            $subjectIds
        );
    }

    public function validateEditRequest(Request $request): void
    {
        $id = (int) $request->get('id');
        $title = $request->get('title');
        $publisher = $request->get('publisher');
        $edition = (int) $request->get('edition');
        $yearOfPublication = $request->get('yearOfPublication');
        $price = (float) $request->get('price');
        $authorIds = $request->get('authors');
        $subjectIds = $request->get('subjects');

        if (empty($id)) {
            throw new \Exception('Id não informado ou inválido!');
        }

        $this->validateBookData(
            $title,
            $publisher,
            $edition,
            $yearOfPublication,
            $price,
            $authorIds,
            $subjectIds,
            $id
        );
    }

    public function validateDeleteRequest(Request $request): void
    {
        $id = (int) $request->get('id');

        if (empty($id)) {
            throw new \Exception('Id não informado ou inválido!');
        }
    }

    /**
     * @param string $title
     * @param string $publisher
     * @param int $edition
     * @param string $yearOfPublication
     * @param float $price
     * @param int[] $authorIds
     * @param int[] $subjectIds
     * @param int|null $id
     *
     * @return void
     */
    private function validateBookData(
        string $title,
        string $publisher,
        int $edition,
        string $yearOfPublication,
        float $price,
        array $authorIds,
        array $subjectIds,
        ?int $id = null
    ): void {
        match (true) {
            empty($title) => throw new \Exception('Você não pode inserir um título vazio!'),
            empty($publisher) => throw new \Exception('Você não pode inserir uma editora vazia!'),
            empty($edition) => throw new \Exception('Você não pode inserir uma edição vazia!'),
            empty($yearOfPublication) => throw new \Exception('Você não pode inserir um ano de publicação vazio!'),
            empty($authorIds) => throw new \Exception('Você não pode inserir um autor vazio!'),
            empty($subjectIds) => throw new \Exception('Você não pode inserir um assunto vazio!'),
            empty($price) => throw new \Exception('Você não pode inserir um preço vazio!'),
            default => ''
        };

        $currentDate = (new \DateTime());
        $currentYearFormated = $currentDate->format('Y');

        if ($yearOfPublication > $currentYearFormated) {
            throw new \Exception('Você não pode inserir um ano de publicação superior ao atual!');
        }

        if (mb_strlen($title, 'UTF-8') > self::TITLE_MAX_LENGTH) {
            throw new \Exception('O título não pode ter mais de ' . self::TITLE_MAX_LENGTH . ' caracteres.');
        }

        if (mb_strlen($publisher, 'UTF-8') > self::PUBLISHER_MAX_LENGTH) {
            throw new \Exception('A editora não pode ter mais de ' . self::PUBLISHER_MAX_LENGTH . ' caracteres.');
        }

        if (mb_strlen($yearOfPublication, 'UTF-8') !== self::YEAR_OF_PUBLICATION_MAX_LENGTH) {
            throw new \Exception(
                'O ano de publicação precisa ter exatamente ' . self::YEAR_OF_PUBLICATION_MAX_LENGTH . ' caracteres.'
            );
        }

        if ($edition > self::MAX_EDITION) {
            throw new \Exception('A edição não pode ser maior que ' . self::MAX_EDITION);
        }

        $findBook = $this->bookRepository->findOneBy(['title' => $title]);

        if ($findBook && $findBook->getId() !== $id) {
            throw new \Exception('Título já existe!');
        }
    }
}

<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Services\AuthorService;
use App\Validator\AuthorRequestValidator;
use App\Repository\AuthorRepository;
use App\Vo\AuthorVo;
use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class AuthorServiceTest extends TestCase
{
    private EntityManagerInterface $em;
    private AuthorRepository $authorRepository;
    private AuthorRequestValidator $validator;
    private AuthorService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authorRepository = $this->createMock(AuthorRepository::class);

        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->em
            ->method('getRepository')
            ->with(Author::class)
            ->willReturn($this->authorRepository);

        $this->validator = $this->createMock(AuthorRequestValidator::class);
        $this->service = new AuthorService($this->em, $this->validator);
    }

    public function testListReturnsTitleAndAuthors(): void
    {
        $authors = [new Author(), new Author()];
        $this->authorRepository
            ->expects(self::once())
            ->method('findAll')
            ->willReturn($authors);

        $result = $this->service->list();

        self::assertIsArray($result);
        self::assertSame('Autor', $result['title']);
        self::assertSame($authors, $result['authors']);
    }

    public function testNewValidatesAndSavesVo(): void
    {
        $request = new Request([], ['name' => 'Teste Autor']);

        $this->validator
            ->expects(self::once())
            ->method('validateNewRequest')
            ->with($request);

        $this->authorRepository
            ->expects(self::once())
            ->method('save')
            ->with(self::isInstanceOf(AuthorVo::class));

        $this->service->new($request);
    }

    public function testEditValidatesAndUpdatesVo(): void
    {
        $request = new Request([], ['id' => 5, 'name' => 'Outro Autor']);

        $this->validator
            ->expects(self::once())
            ->method('validateEditRequest')
            ->with($request);

        $this->authorRepository
            ->expects(self::once())
            ->method('update')
            ->with(self::isInstanceOf(AuthorVo::class));

        $this->service->edit($request);
    }

    public function testDeleteValidatesAndDeletesVo(): void
    {
        $request = new Request([], ['id' => 7]);

        $this->validator
            ->expects(self::once())
            ->method('validateDeleteRequest')
            ->with($request);

        $this->authorRepository
            ->expects(self::once())
            ->method('delete')
            ->with(self::isInstanceOf(AuthorVo::class));

        $this->service->delete($request);
    }
}

<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public const AUTHOR_REFERENCE = 'author';

    public function load(ObjectManager $manager): void
    {
        $authorRepository = $manager->getRepository(Author::class);

        $authorsData = [
            'J.K. Rowling', 'George R.R. Martin', 'J.R.R. Tolkien', 'Agatha Christie', 'Isaac Asimov',
            'Stephen King', 'Ernest Hemingway', 'Jane Austen', 'Charles Dickens', 'F. Scott Fitzgerald'
        ];

        foreach ($authorsData as $i => $authorName) {
            // Verifica se o autor já existe
            $author = $authorRepository->findOneBy(['name' => $authorName]);

            if (!$author) {
                $author = new Author();
                $author->setName($authorName);
                $manager->persist($author);
            }

            // Adicionar referência para cada autor (existente ou novo)
            $this->addReference(self::AUTHOR_REFERENCE . '_' . $i, $author);
        }

        $manager->flush();
    }
}

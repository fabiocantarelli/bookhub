<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $authorsData = [
            'J.K. Rowling',
            'George R.R. Martin',
            'J.R.R. Tolkien',
            'Agatha Christie',
            'Isaac Asimov',
            'Stephen King',
            'Ernest Hemingway',
            'Jane Austen',
            'Charles Dickens',
            'F. Scott Fitzgerald',
            'Haruki Murakami',
            'Gabriel García Márquez',
            'Mark Twain',
            'Leo Tolstoy',
            'Franz Kafka',
            'Kurt Vonnegut',
            'William Shakespeare',
            'George Orwell',
            'Oscar Wilde',
            'Virginia Woolf'
        ];

        foreach ($authorsData as $authorName) {
            $author = new Author();
            $author->setName($authorName);

            $manager->persist($author);
        }

        $manager->flush();
    }
}

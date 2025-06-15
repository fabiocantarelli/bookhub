<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $bookRepository = $manager->getRepository(Book::class);

        // Obter referências de autores e assuntos
        $authors = [];
        for ($i = 0; $i < 10; $i++) {
            $authors[] = $this->getReference(AuthorFixtures::AUTHOR_REFERENCE . '_' . $i, Author::class);
        }

        $subjects = [];
        for ($i = 0; $i < 5; $i++) {
            $subjects[] = $this->getReference(SubjectsFixtures::SUBJECT_REFERENCE . '_' . $i, Subject::class);
        }

        $bookTitles = [
            'A Sombra do Vento', 'O Nome do Vento', 'Cem Anos de Solidão', 'Dom Quixote', '1984',
            'O Senhor dos Anéis', 'Guerra e Paz', 'A Montanha Mágica', 'Ulisses', 'Em Busca do Tempo Perdido',
            'O Grande Gatsby', 'O Apanhador no Campo de Centeio', 'Moby Dick', 'O Sol é para Todos', 'Crime e Castigo',
            'O Processo', 'A Metamorfose', 'Fahrenheit 451', 'Admirável Mundo Novo', 'O Guia do Mochileiro das Galáxias'
        ];

        $publishers = ['Companhia das Letras', 'Rocco', 'Sextante', 'Intrínseca', 'Record'];

        foreach ($bookTitles as $title) {
            // Verifica se o livro já existe
            $book = $bookRepository->findOneBy(['title' => $title]);

            if (!$book) {
                $book = new Book();
                $book->setTitle($title);
                $book->setPublisher($publishers[array_rand($publishers)]);
                $book->setEdition(mt_rand(1, 10));
                $book->setYearOfPublication((string)mt_rand(1980, 2024));
                $book->setPrice((float)mt_rand(2000, 15000) / 100);

                // Adicionar autores aleatórios
                $randomAuthorsKeys = (array) array_rand($authors, mt_rand(1, 2));
                foreach ($randomAuthorsKeys as $key) {
                    $book->addAuthor($authors[$key]);
                }

                // Adicionar assuntos aleatórios
                $randomSubjectsKeys = (array) array_rand($subjects, mt_rand(1, 3));
                foreach ($randomSubjectsKeys as $key) {
                    $book->addSubject($subjects[$key]);
                }

                $manager->persist($book);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AuthorFixtures::class,
            SubjectsFixtures::class,
        ];
    }
}

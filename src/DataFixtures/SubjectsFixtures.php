<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubjectsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $subjectsData = [
            'Ficção Científica',
            'Mistério',
            'Romance',
            'Aventura',
            'Fantasias',
            'História',
            'Biografia',
            'Terror',
            'Drama',
            'Psicologia',
            'Filosofia',
            'Religião',
            'Política',
            'Economia',
            'Arte',
            'Literatura Clássica',
            'Poesia',
            'Tecnologia',
            'Ciência',
            'Educação'
        ];

        foreach ($subjectsData as $subjectDescription) {
            $subject = new Subject();
            $subject->setDescription($subjectDescription);  // Define a descrição mockada do assunto

            // Persistir o assunto no banco
            $manager->persist($subject);
        }

        // Salvar os assuntos no banco de dados
        $manager->flush();
    }
}

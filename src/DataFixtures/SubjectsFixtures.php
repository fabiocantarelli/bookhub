<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SubjectsFixtures extends Fixture
{
    public const SUBJECT_REFERENCE = 'subject';

    public function load(ObjectManager $manager): void
    {
        $subjectRepository = $manager->getRepository(Subject::class);

        $subjectsData = [
            'Ficção Científica', 'Mistério', 'Romance', 'Aventura', 'Fantasias'
        ];

        foreach ($subjectsData as $i => $subjectDescription) {
            // Verifica se o assunto já existe
            $subject = $subjectRepository->findOneBy(['description' => $subjectDescription]);

            if (!$subject) {
                $subject = new Subject();
                $subject->setDescription($subjectDescription);
                $manager->persist($subject);
            }

            // Adicionar referência para cada assunto (existente ou novo)
            $this->addReference(self::SUBJECT_REFERENCE . '_' . $i, $subject);
        }

        $manager->flush();
    }
}

<?php

declare(strict_types=1);

namespace App\Vo;

use Symfony\Component\HttpFoundation\Request;

final class SubjectVo implements RequestVoInterface
{
    private ?int $id = null;
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public static function buildDataFromRequest(Request $request): static
    {
        return (new static())
            ->setId((int) $request->get('id'))
            ->setDescription($request->get('description'));
    }
}

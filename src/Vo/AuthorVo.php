<?php

declare(strict_types=1);

namespace App\Vo;

use Symfony\Component\HttpFoundation\Request;

final class AuthorVo implements RequestVoInterface
{
    private ?int $id = null;
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public static function buildDataFromRequest(Request $request): static
    {
        return (new static())
            ->setId((int) $request->get('id'))
            ->setName($request->get('name'));
    }
}

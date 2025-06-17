<?php

declare(strict_types=1);

namespace App\Vo;

use Symfony\Component\HttpFoundation\Request;

class AuthorVo
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

    public static function buildData(Request $request): self
    {
        return (new self())
            ->setId((int) $request->get('id'))
            ->setName($request->get('name'));
    }
}

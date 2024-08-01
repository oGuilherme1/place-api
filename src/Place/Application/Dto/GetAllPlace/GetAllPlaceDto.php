<?php

declare(strict_types=1);

namespace Src\Place\Application\Dto\GetAllPlace;

class GetAllPlaceDto
{
    private function __construct(
        public readonly ?string $name,
    )
    {
    }

    public static function create(?string $name): self
    {
        return new self(
            $name
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    public function getName(): ?string
    {
        return $this->name;
    }

}
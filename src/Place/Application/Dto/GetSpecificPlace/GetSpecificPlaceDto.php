<?php

declare(strict_types=1);

namespace Src\Place\Application\Dto\GetSpecificPlace;

class GetSpecificPlaceDto
{
    private function __construct(
        public readonly string $id,
    )
    {
    }

    public static function create(string $id): self
    {
        return new self(
            $id
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
        ];
    }

    public function getId(): string
    {
        return $this->id;
    }

}
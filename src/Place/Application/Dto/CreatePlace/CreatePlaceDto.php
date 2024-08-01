<?php

declare(strict_types=1);

namespace Src\Place\Application\Dto\CreatePlace;

class CreatePlaceDto
{
    private function __construct(
        public readonly ?string $id,
        public readonly string $name,
        public readonly string $city,
        public readonly string $state
    )
    {
    }

    public static function create(?string $id, string $name, string $city, string $state): self
    {
        return new self(
            $id,
            $name,
            $city,
            $state
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'state' => $this->state
        ];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }
}
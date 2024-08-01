<?php

declare(strict_types=1);

namespace Src\Place\Domain;

class Place
{
    private function __construct(
        public readonly ?string $id,
        public string $name,
        public string $slug,
        public string $city,
        public string $state,
    )
    {
    }

    public static function create(?string $id, string $name, string $slug, string $city, string $state): self
    {
        return new self(
            $id,
            $name,
            $slug,
            $city,
            $state
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'city' => $this->city,
            'state' => $this->state
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['slug'],
            $data['city'],
            $data['state']
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }
}
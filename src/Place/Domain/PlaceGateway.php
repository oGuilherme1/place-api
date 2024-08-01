<?php

declare(strict_types=1);

namespace Src\Place\Domain;

interface PlaceGateway
{
    public function save(array $place): void; 
    public function update(array $place): void;
    public function getSpecificPlace(string $slug): ?array;
    public function getAllPlaces(?string $name): array;
    public function existingPlace(string $slug): bool;
}
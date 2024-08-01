<?php

declare(strict_types=1);

namespace Src\Place\Infra\Repository\PgSql;

use Src\Place\Domain\PlaceGateway;
use Src\Place\Infra\Models\Place;

class PlaceRepository implements PlaceGateway
{
    public function save(array $place): void
    {
        Place::create($place);
    }

    public function update(array $place): void
    {
        $existingPlace = Place::find($place['id']);
        if ($existingPlace) {
            $existingPlace->update($place);
        }
    }

    public function getSpecificPlace(string $id): ?array
    {
        $place = Place::select('id', 'name', 'slug', 'city', 'state')
            ->where('id', $id)
            ->first();

        return $place ? $place->toArray() : null;
    }

    public function getAllPlaces(?string $name): array
    {
        if ($name) {
            return Place::select('id', 'name', 'slug', 'city', 'state')
                ->where('name', 'like', "%$name%")
                ->get()
                ->toArray();
        }

        return Place::select('id', 'name', 'slug', 'city', 'state')
            ->get()
            ->toArray();
    }

    public function existingPlace(string $slug): bool
    {
        return Place::where('slug', $slug)->exists();
    }
}

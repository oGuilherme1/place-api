<?php

declare(strict_types=1);

namespace Src\Place\Application\UseCase\CreatePlace;

use Exception;
use Ramsey\Uuid\Uuid;
use Src\Place\Application\Dto\CreatePlace\CreatePlaceDto;
use Src\Place\Domain\Place;
use Src\Place\Domain\PlaceGateway;

class CreatePlaceUseCase
{
    private function __construct(private readonly PlaceGateway $gateway)
    {
    }

    public static function create(PlaceGateway $gateway): self
    {
        return new self($gateway);
    }

    public function execute(CreatePlaceDto $dto): array
    {
        try {

            $name = strtolower($dto->getName());
            $city = strtolower($dto->getCity());
            $state = strtolower($dto->getState());
    
            $slug = preg_replace('/[^a-z0-9]+/', '-', $name . '-' . $city . '-' . $state);
            $slug = trim($slug, '-');

            $existingPlace = $this->gateway->existingPlace($slug);

            if ($existingPlace) {
                throw new Exception('This place is already registered');
            }

            $aPlace = Place::create(
                Uuid::uuid4()->toString(),
                $dto->getName(),
                $slug,
                $dto->getCity(),
                $dto->getState()
            );

            $this->gateway->save($aPlace->toArray());

            return [
                'success' => true,
                'message' => 'Place created successfully',
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

    }
}
<?php

declare(strict_types=1);

namespace Src\Place\Application\UseCase\UpdatePlace;

use Exception;
use Ramsey\Uuid\Uuid;
use Src\Place\Application\Dto\UpdatePlace\UpdatePlaceDto;
use Src\Place\Domain\Place;
use Src\Place\Domain\PlaceGateway;

class UpdatePlaceUseCase
{
    private function __construct(private readonly PlaceGateway $gateway)
    {
    }

    public static function create(PlaceGateway $gateway): self
    {
        return new self($gateway);
    }

    public function execute(UpdatePlaceDto $dto): array
    {
        try {
            
            $getPlace = $this->gateway->getSpecificPlace($dto->getId());

            if(!$getPlace) {
                throw new Exception('Place not found');
            }

            $name = strtolower($dto->getName());
            $city = strtolower($dto->getCity());
            $state = strtolower($dto->getState());
    
            $slug = preg_replace('/[^a-z0-9]+/', '-', $name . '-' . $city . '-' . $state);
            $slug = trim($slug, '-');

            if ($slug !== $getPlace['slug'] && $this->gateway->existingPlace($slug)) {
                throw new Exception('This place is already registered');
            }

            $aPlace = Place::fromArray($getPlace);

            $aPlace->setName($dto->getName());
            $aPlace->setSlug($slug);
            $aPlace->setCity($dto->getCity());
            $aPlace->setState($dto->getState());

            $this->gateway->update($aPlace->toArray());

            return [
                'success' => true,
                'message' => 'Place updated successfully',
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

    }
}
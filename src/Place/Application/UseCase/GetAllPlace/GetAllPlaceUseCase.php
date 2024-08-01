<?php

declare(strict_types=1);

namespace Src\Place\Application\UseCase\GetAllPlace;

use Exception;
use Src\Place\Application\Dto\GetAllPlace\GetAllPlaceDto;
use Src\Place\Domain\Place;
use Src\Place\Domain\PlaceGateway;

class GetAllPlaceUseCase
{
    private function __construct(private readonly PlaceGateway $gateway)
    {
    }

    public static function create(PlaceGateway $gateway): self
    {
        return new self($gateway);
    }

    public function execute(GetAllPlaceDto $dto): array
    {
        try {
            
            $places = $this->gateway->getAllPlaces($dto->getName());

            return [
                'success' => true,
                'places' => $places,
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

    }
}
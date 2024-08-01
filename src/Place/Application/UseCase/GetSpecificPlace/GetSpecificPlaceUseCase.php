<?php

declare(strict_types=1);

namespace Src\Place\Application\UseCase\GetSpecificPlace;

use Exception;
use Src\Place\Application\Dto\GetSpecificPlace\GetSpecificPlaceDto;
use Src\Place\Domain\PlaceGateway;

class GetSpecificPlaceUseCase
{
    private function __construct(private readonly PlaceGateway $gateway)
    {
    }

    public static function create(PlaceGateway $gateway): self
    {
        return new self($gateway);
    }

    public function execute(GetSpecificPlaceDto $dto): array
    {
        try {
            
            $place = $this->gateway->getSpecificPlace($dto->getId());

            if (!$place) {
                throw new Exception('Place not found');
            }

            return [
                'success' => true,
                'place' => $place,
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

    }
}
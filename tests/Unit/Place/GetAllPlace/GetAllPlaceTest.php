<?php

declare(strict_types=1);

namespace Tests\Unit\Place\GetAllPlace;

use PHPUnit\Framework\TestCase;
use Src\Place\Application\UseCase\GetAllPlace\GetAllPlaceUseCase;
use Src\Place\Application\Dto\GetAllPlace\GetAllPlaceDto;
use Src\Place\Domain\PlaceGateway;
use Src\Place\Domain\Place;
use Exception;

class GetAllPlaceTest extends TestCase
{
    private $placeGatewayMock;
    private $getAllPlaceUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->placeGatewayMock = $this->createMock(PlaceGateway::class);
        $this->getAllPlaceUseCase = GetAllPlaceUseCase::create($this->placeGatewayMock);
    }

    public function testExecuteWithNonNullNameReturnsFilteredPlacesSuccessfully(): void
    {
        $dto = GetAllPlaceDto::create('Test Place');

        // Criar um mock de Place.
        $place = $this->createMock(Place::class);

        // Espera-se que o método getAllPlaces retorne uma lista de lugares filtrada.
        $expectedPlaces = [$place];

        $this->placeGatewayMock->expects($this->once())
            ->method('getAllPlaces')
            ->with($dto->getName())
            ->willReturn($expectedPlaces);

        $result = $this->getAllPlaceUseCase->execute($dto);

        $this->assertTrue($result['success']);
        $this->assertSame($expectedPlaces, $result['places']);
    }

    public function testExecuteWithNullNameReturnsAllPlacesSuccessfully(): void
    {
        $dto = GetAllPlaceDto::create(null);

        // Criar mock de Place.
        $place1 = $this->createMock(Place::class);
        $place2 = $this->createMock(Place::class);

        $expectedPlaces = [$place1, $place2];

        $this->placeGatewayMock->expects($this->once())
            ->method('getAllPlaces')
            ->with($this->isNull())
            ->willReturn($expectedPlaces);

        $result = $this->getAllPlaceUseCase->execute($dto);

        $this->assertTrue($result['success']);
        $this->assertSame($expectedPlaces, $result['places']);
    }

    public function testExecuteHandlesExceptionAndReturnsErrorMessage(): void
    {
        $dto = GetAllPlaceDto::create('Test Place');

        $exceptionMessage = 'An error occurred';

        $this->placeGatewayMock->expects($this->once())
            ->method('getAllPlaces')
            ->with($dto->getName())
            ->willThrowException(new Exception($exceptionMessage));

        $result = $this->getAllPlaceUseCase->execute($dto);

        $this->assertFalse($result['success']);
        $this->assertSame($exceptionMessage, $result['message']);
    }
}

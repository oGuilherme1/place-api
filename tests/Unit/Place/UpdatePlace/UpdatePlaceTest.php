<?php

declare(strict_types=1);

namespace Tests\Unit\Place\UpdatePlace;

use Exception;
use PHPUnit\Framework\TestCase;
use Src\Place\Application\Dto\UpdatePlace\UpdatePlaceDto;
use Src\Place\Application\UseCase\UpdatePlace\UpdatePlaceUseCase;
use Src\Place\Domain\PlaceGateway;

class UpdatePlaceTest extends TestCase
{
    private $placeGatewayMock;
    private $updatePlaceUseCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->placeGatewayMock = $this->createMock(PlaceGateway::class);
        $this->updatePlaceUseCase = UpdatePlaceUseCase::create($this->placeGatewayMock);
    }

    public function testUpdatePlaceSuccess(): void
    {
        $dto = UpdatePlaceDto::create('existing-id', 'Test Name', 'Test City', 'Test State');
        $placeArray = [
            'id' => 'existing-id',
            'name' => 'Old Name',
            'slug' => 'old-slug',
            'city' => 'Old City',
            'state' => 'Old State',
        ];

        $this->placeGatewayMock
            ->expects($this->once())
            ->method('getSpecificPlace')
            ->with($dto->getId())
            ->willReturn($placeArray);

        $this->placeGatewayMock
            ->expects($this->once())
            ->method('existingPlace')
            ->with('test-name-test-city-test-state')
            ->willReturn(false);

        $this->placeGatewayMock
            ->expects($this->once())
            ->method('update')
            ->with($this->callback(function (array $place) use ($dto) {
                return $place['name'] === $dto->getName() &&
                    $place['city'] === $dto->getCity() &&
                    $place['state'] === $dto->getState() &&
                    $place['slug'] === 'test-name-test-city-test-state';
            }));

        $result = $this->updatePlaceUseCase->execute($dto);

        $this->assertTrue($result['success']);
        $this->assertEquals('Place updated successfully', $result['message']);
    }

    public function testUpdatePlaceErrorPlaceNotFound(): void
    {
        $dto = UpdatePlaceDto::create('non-existing-id', 'Test Name', 'Test City', 'Test State');

        $this->placeGatewayMock
            ->expects($this->once())
            ->method('getSpecificPlace')
            ->with($dto->getId())
            ->willReturn(null);

        $result = $this->updatePlaceUseCase->execute($dto);

        $this->assertFalse($result['success']);
        $this->assertEquals('Place not found', $result['message']);
    }

    public function testUpdatePlaceErrorPlaceAlreadyRegistered(): void
    {
        $dto = UpdatePlaceDto::create('existing-id', 'Test Name', 'Test City', 'Test State');
        $placeArray = [
            'id' => 'existing-id',
            'name' => 'Old Name',
            'slug' => 'old-slug',
            'city' => 'Old City',
            'state' => 'Old State',
        ];

        $this->placeGatewayMock
            ->expects($this->once())
            ->method('getSpecificPlace')
            ->with($dto->getId())
            ->willReturn($placeArray);

        $this->placeGatewayMock
            ->expects($this->once())
            ->method('existingPlace')
            ->with('test-name-test-city-test-state')
            ->willReturn(true);

        $result = $this->updatePlaceUseCase->execute($dto);

        $this->assertFalse($result['success']);
        $this->assertEquals('This place is already registered', $result['message']);
    }

    public function testUpdatePlaceDatabaseError(): void
    {
        $dto = UpdatePlaceDto::create('existing-id', 'Test Name', 'Test City', 'Test State');
        $placeArray = [
            'id' => 'existing-id',
            'name' => 'Old Name',
            'slug' => 'old-slug',
            'city' => 'Old City',
            'state' => 'Old State',
        ];

        $this->placeGatewayMock
            ->expects($this->once())
            ->method('getSpecificPlace')
            ->with($dto->getId())
            ->willReturn($placeArray);

        $this->placeGatewayMock
            ->expects($this->once())
            ->method('update')
            ->willThrowException(new Exception('Database error'));

        $result = $this->updatePlaceUseCase->execute($dto);

        $this->assertFalse($result['success']);
        $this->assertEquals('Database error', $result['message']);
    }
}

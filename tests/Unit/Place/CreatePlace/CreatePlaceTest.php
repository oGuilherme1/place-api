<?php

declare(strict_types=1);

namespace Tests\Unit\Place\CreatePlace;

use Exception;
use PHPUnit\Framework\TestCase;
use Src\Place\Application\Dto\CreatePlace\CreatePlaceDto;
use Src\Place\Domain\PlaceGateway;
use Src\Place\Application\UseCase\CreatePlace\CreatePlaceUseCase;

class CreatePlaceTest extends TestCase
{
    private $placeGatewayMock;
    private $createPlaceUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->placeGatewayMock = $this->createMock(PlaceGateway::class);
        $this->createPlaceUseCase = CreatePlaceUseCase::create($this->placeGatewayMock);
    }

    public function testCreatePlaceSuccess()
    {
        $dto = CreatePlaceDto::create(
            null,
            'Place Name',
            'place-name',
            'City Name',
            'State Name'
        );

        $name = strtolower($dto->getName());
        $city = strtolower($dto->getCity());
        $state = strtolower($dto->getState());
        $slug = preg_replace('/[^a-z0-9]+/', '-', $name . '-' . $city . '-' . $state);
        $slug = trim($slug, '-');

        $this->placeGatewayMock
            ->expects($this->once())
            ->method('existingPlace')
            ->with($slug)
            ->willReturn(false);

        $this->placeGatewayMock
            ->expects($this->once())
            ->method('save')
            ->with($this->callback(function (array $place) use ($dto, $slug) {
                return $place['name'] === $dto->getName() &&
                    $place['slug'] === $slug &&
                    $place['city'] === $dto->getCity() &&
                    $place['state'] === $dto->getState();
            }));

        $result = $this->createPlaceUseCase->execute($dto);

        $this->assertTrue($result['success']);
        $this->assertEquals('Place created successfully', $result['message']);
    }

    public function testCreatePlaceFailureDueToExistingPlace()
    {
        $dto = CreatePlaceDto::create(
            null,
            'Place Name',
            'place-name',
            'City Name',
            'State Name'
        );

        $name = strtolower($dto->getName());
        $city = strtolower($dto->getCity());
        $state = strtolower($dto->getState());
        $slug = preg_replace('/[^a-z0-9]+/', '-', $name . '-' . $city . '-' . $state);
        $slug = trim($slug, '-');

        $this->placeGatewayMock
            ->expects($this->once())
            ->method('existingPlace')
            ->with($slug)
            ->willReturn(true);

        $result = $this->createPlaceUseCase->execute($dto);

        $this->assertFalse($result['success']);
        $this->assertEquals('This place is already registered', $result['message']);
    }

    public function testCreatePlaceFailureDueToException()
    {
        $dto = CreatePlaceDto::create(
            null,
            'Place Name',
            'place-name',
            'City Name',
            'State Name'
        );

        $name = strtolower($dto->getName());
        $city = strtolower($dto->getCity());
        $state = strtolower($dto->getState());
        $slug = preg_replace('/[^a-z0-9]+/', '-', $name . '-' . $city . '-' . $state);
        $slug = trim($slug, '-');

        $this->placeGatewayMock
            ->expects($this->once())
            ->method('existingPlace')
            ->with($slug)
            ->willReturn(false);

        $this->placeGatewayMock
            ->expects($this->once())
            ->method('save')
            ->will($this->throwException(new Exception('Database error')));

        $result = $this->createPlaceUseCase->execute($dto);

        $this->assertFalse($result['success']);
        $this->assertEquals('Database error', $result['message']);
    }
}

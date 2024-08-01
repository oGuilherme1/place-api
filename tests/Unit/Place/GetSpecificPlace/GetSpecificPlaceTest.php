<?php

declare(strict_types=1);

namespace Tests\Unit\Place\GetSpecificPlace;

use PHPUnit\Framework\TestCase;
use Src\Place\Application\UseCase\GetSpecificPlace\GetSpecificPlaceUseCase;
use Src\Place\Application\Dto\GetSpecificPlace\GetSpecificPlaceDto;
use Src\Place\Domain\PlaceGateway;
use Exception;

class GetSpecificPlaceTest extends TestCase
{
    private $placeGatewayMock;
    private $getSpecificPlaceUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->placeGatewayMock = $this->createMock(PlaceGateway::class);
        $this->getSpecificPlaceUseCase = GetSpecificPlaceUseCase::create($this->placeGatewayMock);
    }

    public function testExecuteWithExistingPlaceReturnsPlaceSuccessfully(): void
    {
        $placeId = 'test-place-id';
        $dto = GetSpecificPlaceDto::create($placeId);

        $place = [
            'id' => $placeId,
            'name' => 'Test Place',
            'slug' => 'test-place-slug',
            'city' => 'Test City',
            'state' => 'Test State'
        ];

        $this->placeGatewayMock->expects($this->once())
            ->method('getSpecificPlace')
            ->with($placeId)
            ->willReturn($place);

        $result = $this->getSpecificPlaceUseCase->execute($dto);

        $this->assertTrue($result['success']);
        $this->assertSame($place, $result['place']);
    }

    public function testExecuteWithNonExistingPlaceReturnsError(): void
    {
        $placeId = 'test-place-id';
        $dto = GetSpecificPlaceDto::create($placeId);

        $this->placeGatewayMock->expects($this->once())
            ->method('getSpecificPlace')
            ->with($placeId)
            ->willReturn(null);

        $result = $this->getSpecificPlaceUseCase->execute($dto);

        $this->assertFalse($result['success']);
        $this->assertSame('Place not found', $result['message']);
    }

    public function testExecuteHandlesExceptionAndReturnsErrorMessage(): void
    {
        $placeId = 'test-place-id';
        $dto = GetSpecificPlaceDto::create($placeId);

        $exceptionMessage = 'An error occurred';

        $this->placeGatewayMock->expects($this->once())
            ->method('getSpecificPlace')
            ->with($placeId)
            ->willThrowException(new Exception($exceptionMessage));

        $result = $this->getSpecificPlaceUseCase->execute($dto);

        $this->assertFalse($result['success']);
        $this->assertSame($exceptionMessage, $result['message']);
    }
}

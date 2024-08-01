<?php

declare(strict_types=1);

namespace Src\Place\Infra\Controllers\GetSpecificPlace;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Place\Application\Dto\GetSpecificPlace\GetSpecificPlaceDto;
use Src\Place\Application\UseCase\GetSpecificPlace\GetSpecificPlaceUseCase;
use Symfony\Component\HttpFoundation\Response;

class GetSpecificPlaceController
{

    public function __construct(private readonly GetSpecificPlaceUseCase $useCase)
    {
    }

    public function execute(Request $request): JsonResponse
    {
        $getSpecificPlaceDto = GetSpecificPlaceDto::create($request->route('id'));

        $getSpecificPlace = $this->useCase->execute($getSpecificPlaceDto);

        if(!$getSpecificPlace['success']){
            return response()->json([
                'error' => $getSpecificPlace['message']
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'data' => [
                'place' => $getSpecificPlace['place']
            ]
        ], Response::HTTP_OK);
    }
}
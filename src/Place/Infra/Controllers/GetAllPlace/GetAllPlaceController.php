<?php

declare(strict_types=1);

namespace Src\Place\Infra\Controllers\GetAllPlace;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Place\Application\Dto\GetAllPlace\GetAllPlaceDto;
use Src\Place\Application\UseCase\GetAllPlace\GetAllPlaceUseCase;
use Symfony\Component\HttpFoundation\Response;

class GetAllPlaceController
{

    public function __construct(private readonly GetAllPlaceUseCase $useCase)
    {
    }

    public function execute(Request $request): JsonResponse
    {
        $getAllPlaceDto = GetAllPlaceDto::create($request->route('name'));

        $getAllPlace = $this->useCase->execute($getAllPlaceDto);

        if(!$getAllPlace['success']){
            return response()->json([
                'error' => $getAllPlace['message']
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'data' => [
                'place' => $getAllPlace['places']
            ]
        ], Response::HTTP_OK);
    }
}
<?php

declare(strict_types=1);

namespace Src\Place\Infra\Controllers\CreatePlace;

use Illuminate\Http\JsonResponse;
use Src\Place\Application\UseCase\CreatePlace\CreatePlaceUseCase;
use Src\Place\Infra\Requests\CreatePlace\CreatePlaceRequest;
use Symfony\Component\HttpFoundation\Response;

class CreatePlaceController
{

    public function __construct(private readonly CreatePlaceUseCase $useCase)
    {
    }

    public function execute(CreatePlaceRequest $request): JsonResponse
    {
        $createPlace = $this->useCase->execute($request->createDto());

        if(!$createPlace['success']){
            return response()->json([
                'error' => $createPlace['message']
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'data' => [
                'message' => $createPlace['message']
            ]
        ], Response::HTTP_OK);
    }
}
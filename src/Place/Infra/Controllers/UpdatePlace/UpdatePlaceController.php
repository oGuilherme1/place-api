<?php

declare(strict_types=1);

namespace Src\Place\Infra\Controllers\UpdatePlace;

use Illuminate\Http\JsonResponse;
use Src\Place\Application\UseCase\UpdatePlace\UpdatePlaceUseCase;
use Src\Place\Infra\Requests\UpdatePlace\UpdatePlaceRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdatePlaceController
{

    public function __construct(private readonly UpdatePlaceUseCase $useCase)
    {
    }

    public function execute(UpdatePlaceRequest $request): JsonResponse
    {
        $updatePlace = $this->useCase->execute($request->createDto());

        if(!$updatePlace['success']){
            return response()->json([
                'error' => $updatePlace['message']
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'data' => [
                'message' => $updatePlace['message']
            ]
        ], Response::HTTP_OK);
    }
}
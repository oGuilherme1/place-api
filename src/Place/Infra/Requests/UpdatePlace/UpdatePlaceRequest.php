<?php

namespace Src\Place\Infra\Requests\UpdatePlace;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Src\Place\Application\Dto\CreatePlace\CreatePlaceDto;
use Src\Place\Application\Dto\UpdatePlace\UpdatePlaceDto;

class UpdatePlaceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'The id field is required.',
            'id.string' => 'The id field must be a string.',
            'id.max' => 'The id field cannot be longer than 255 characters.',

            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.max' => 'The name field cannot be longer than 255 characters.',
            
            'city.required' => 'The city field is required.',
            'city.string' => 'The city field must be a string.',
            'city.max' => 'The city field cannot be longer than 255 characters.',
            
            'state.required' => 'The state field is required.',
            'state.string' => 'The state field must be a string.',
            'state.max' => 'The state field cannot be longer than 255 characters.',
        ];
    }


    public function createDto(): UpdatePlaceDto
    {
        return UpdatePlaceDto::create(
            ...$this->validated()
        );
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}

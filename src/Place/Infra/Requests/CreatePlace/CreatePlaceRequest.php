<?php

namespace Src\Place\Infra\Requests\CreatePlace;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Src\Place\Application\Dto\CreatePlace\CreatePlaceDto;

class CreatePlaceRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
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


    public function createDto(): CreatePlaceDto
    {
        return CreatePlaceDto::create(
            null,
            ...$this->validated()
        );
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}

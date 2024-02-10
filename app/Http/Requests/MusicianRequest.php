<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MusicianRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', 'unique:musicians,name'],
            'genre' => ['required'],
            'image' => ['required'],
        ];

        if ($this->route()->uri === 'api/musicians/edit/{musician}') {
            // If the route name is 'edit-event', add the unique validation rule with the event ID.
            $rules['name'] = ['required', 'unique:musicians,name,' . $this->route('musician')];
        }

        if ($this->route()->uri === 'api/musicians' || $this->route()->uri === 'api/musicians/unpaginated') {
            $rules = [];
        }

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'data' => $validator->errors(),
                'message' => "Data validation failed."
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}

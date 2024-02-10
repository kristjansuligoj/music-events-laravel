<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class SongRequest extends FormRequest
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
            'musician' => 'required',
            'title' => ['required', 'unique:songs,title'],
            'length' => ['required', 'integer', 'between:10,300'],
            'releaseDate' => ['required', 'date', 'before:today'],
            'authors' => ['required'],
            'genre' => ['required'],
        ];

        if ($this->route()->uri === 'api/songs/edit/{song}') {
            // If the route name is 'edit-event', add the unique validation rule with the event ID.
            $rules['title'] = ['required', 'unique:songs,title,' . $this->route('song')];
        }

        if ($this->route()->uri === 'api/songs') {
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

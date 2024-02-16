<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class EventRequest extends FormRequest
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
            'name' => ['required', 'unique:events,name'],
            'address' => ['required', 'unique:events,address'],
            'date' => ['required', 'date', 'date_format:Y-m-d', 'after:today'],
            'time' => ['required'],
            'description' => ['required'],
            'ticketPrice' => ['required', 'integer', 'between:10,300'],
            'musician' => ['required'],
        ];

        if ($this->route()->uri === 'api/events/edit/{event}') {
            // If the route name is 'edit-event', add the unique validation rule with the event ID.
            $rules['name'] = ['required', 'unique:events,name,' . $this->route('event')];
            $rules['address'] = ['required', 'unique:events,address,' . $this->route('event')];
        }

        if ($this->route()->uri === 'api/events') {
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

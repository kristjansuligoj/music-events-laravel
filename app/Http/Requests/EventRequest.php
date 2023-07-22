<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'date' => ['required', 'date', 'after:today'],
            'time' => ['required'],
            'description' => ['required'],
            'ticketPrice' => ['required', 'integer', 'between:10,300'],
            'musician' => ['required'],
        ];

        if ($this->route()->uri === 'events/edit/{event}') {
            // If the route name is 'edit-event', add the unique validation rule with the event ID.
            $rules['name'] = ['required', 'unique:events,name,' . $this->route('event')];
            $rules['address'] = ['required', 'unique:events,address,' . $this->route('event')];
        }

        return $rules;
    }
}
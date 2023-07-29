<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        ];

        if ($this->route()->uri === 'songs/edit/{song}') {
            // If the route name is 'edit-event', add the unique validation rule with the event ID.
            $rules['title'] = ['required', 'unique:songs,title,' . $this->route('song')];
        }

        if ($this->route()->uri === 'songs') {
            $rules = [];
        }

        return $rules;
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NoteRequest extends FormRequest
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
        return [
            'category_id' => 'required',
            'title' => ['required', 'min:5', 'max:30'],
            'noteContent' => ['required', 'max:500'],
            'priority' => ['required', 'integer', 'min:1' , 'max:5'],
            'deadline' => ['required', 'date', 'after:now'],
            'tags' => ['required', 'max:200'],
            'public' => 'required'
        ];
    }
}

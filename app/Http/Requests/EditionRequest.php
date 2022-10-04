<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditionRequest extends FormRequest
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
            'title' => ['required'],
            'publisher' => ['required'],
            'language' => ['required','alpha'],
            'format' => ['string'],
            'isStandalone' => ['boolean'],
            'isClosed' => ['boolean'],
            'description' => ['nullable'],
        ];
    }

    public function messages(){
        return [
            'title.required' => 'La edición necesita un título',
            'publisher.required' => 'La edición necesita una editorial',
            'language.required' => 'Debe especificar el idioma',
            'language.alpha' => 'El idioma solo puede contener letras.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtworkRequest extends FormRequest
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
            'title' => ['required', 'min:4', 'max:15'],
            'description' => ['required', 'min:4', 'max:30'],
            'imgUrl' => ['required', 'image', 'mimes:jpg,png', 'max:8192'],
        ];
    }

    public function messages(){
        return [
            'title.required' => 'El título es obligatorio',
            'description.required' => 'La descripción es obligatoria',
            'imgUrl.required' => 'La imagen es obligatoria',
            'title.min' => 'El título debe ser de al menos 4 carateres',
            'title.max' => 'El título no debe superar los 15 carateres',
            'description.min' => 'La descripción debe ser de al menos 4 carateres',
            'description.max' => 'La descripción no debe superar los 30 carateres',
            'imgUrl.image' => 'El archivo no es una imagen',
            'imgUrl.mimes' => 'La imagen debe ser formato .jpg o .png',
            'imgUrl.max' => "El tamaño de la imagen debe ser menor a 8MB (8192 KB)"
        ];
    }
}

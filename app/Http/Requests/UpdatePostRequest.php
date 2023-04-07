<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'image' => 'image|nullable',
            'description' => 'required|string|max:255',
            'visibility' => 'boolean',
        ];
    }
    public function messages()
    {
        return [
            "title" => [
                'required' => "Il nome è obbligatorio",
                'max' => "Puoi utilizzare un massimo di :max caratteri",
            ],
            "image.image" => "Il file che hai inserito non è un immagine",
            "description" => [
                'required' => "La descrizione è obbligatoria",
                'max' => "Puoi utilizzare un massimo di :max caratteri",
            ],
        ];
    }
}

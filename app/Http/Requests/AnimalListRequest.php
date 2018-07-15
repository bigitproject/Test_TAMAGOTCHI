<?php

namespace App\Http\Requests;

class AnimalListRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'dog' => ['nullable', 'integer', 'exists:animals_types,id'],
            'cat' => ['nullable', 'integer', 'exists:animals_types,id'],
            'raccoon' => ['nullable', 'integer', 'exists:animals_types,id'],
            'penguin' => ['nullable', 'integer', 'exists:animals_types,id'],
        ];
    }
}

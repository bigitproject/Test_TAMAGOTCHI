<?php
/**
 * Created by PhpStorm.
 * User: tina
 * Date: 7/12/18
 * Time: 4:53 PM
 */

namespace App\Http\Requests;


class AnimalRequest extends Request
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['nullable', 'integer', 'exists:animals_types,id'],
        ];
    }
}
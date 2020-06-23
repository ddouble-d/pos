<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'nama' => 'required|string|max:100',
            'email' => 'nullable|email',
            'hp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'avatar' => 'nullable|image',
        ];
    }
}

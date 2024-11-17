<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'min:2', 'max:50'],
            'email' => ['required', 'email' ],
            'phone' => ['required', 'string' , 'min:10' ,'max:25' ],
            'title' => ['required', 'string', 'max:60'],
            'body' => ['required', 'string', 'min:20' , 'max:500']
        ];
    }
}

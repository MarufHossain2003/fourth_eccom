<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReturnProducts extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'c_name'        => 'required|string',
            'c_phone'       => 'required|string',
            'c_email'       => 'required|email',
            'address'       => 'required|string',
            'product_id'    => 'required|integer',
            'define_issue'  => 'required|string',
            'image'         => 'required|image|max:2048'
        ];
    }
}

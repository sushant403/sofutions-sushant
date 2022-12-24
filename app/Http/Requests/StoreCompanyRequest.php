<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('isAdmin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'company_name' => [
                'string',
                'required',
            ],
            'company_email' => [
                'string',
                'nullable',
            ],
            'company_logo' => [
                'nullable',
                'image',
                'dimensions:min_width=100,min_height=100'
            ],
            'company_website' => [
                'string',
                'nullable',
            ],
            'phone' => [
                'nullable',
                'regex:/^[6-9][0-9]{9}$/',
                'max:13',
            ],
            'email' => [
                'nullable',
                'email'
            ]
        ];
    }
}

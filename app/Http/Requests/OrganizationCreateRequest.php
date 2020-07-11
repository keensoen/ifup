<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationCreateRequest extends FormRequest
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
            'general_name'  => ['required', 'string'],
            'parish'        => ['required', 'string'],
            'contact_person'=> ['required', 'string'],
            'phone'         => ['numeric', 'required'],
            'address'       => ['required']  
        ];
    }
}

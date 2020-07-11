<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class MemberRequestForm extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name'    => ['required', 'alpha', 'max:50'],
            'middle_name'   => ['nullable', 'alpha', 'max:50'],
            'surname'       => ['required', 'alpha', 'max:50'],
            'birthday'      => ['required'],
            'tel'           => ['required', 'numeric', 'unique:member'],
            'email'         => ['nullable', 'email'],
            'address'       => ['required'],
            'service_interest_id'  => ['required'],
            'baptized'      => ['sometimes', 'string'],
            'past_life_experience'  => ['required_if:baptized,on'],
            'like_visited'      => ['sometimes', 'string'],
            'availability'      => ['required_if:like_visited,on'],
            'photo'         => ['sometimes', 'mimes:jpeg,png,jpg', 'max:2048'],
            'comment1'      => ['sometimes', 'string'],
            'comment'       => ['required_if:comment1,on']
        ];
    }

    // public function messages()
    // {
    //     return [
            
    //     ];
    // }
}

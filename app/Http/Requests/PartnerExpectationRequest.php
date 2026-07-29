<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PartnerExpectationRequest extends FormRequest
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
            'general'                   => ['nullable'],
            'partner_height'            => ['nullable', 'max:50'],
            'partner_weight'            => ['nullable', 'max:50'],
            'partner_marital_status'    => ['nullable'],
            'partner_children_acceptable' => ['nullable', 'max:20'],
            'residence_country_id'      => ['nullable'],
            'partner_religion_id'       => ['nullable'],
            'smoking_acceptable'        => ['nullable', 'max:20'],
            'drinking_acceptable'       => ['nullable', 'max:20'],
            'partner_diet'              => ['nullable', 'max:50'],
            'partner_manglik'           => ['nullable', 'max:50'],
            'language_id'               => ['nullable'],
            'partner_country_id'        => ['nullable'],
            'partner_state_id'          => ['nullable'],
            'pertner_complexion'        => ['nullable', 'max:50'],
        ];
    }

    // public function failedValidation(Validator $validator)
    // {
    //     // dd($this->expectsJson());
    //     if ($this->expectsJson()) {
    //         throw new HttpResponseException(response()->json([
    //             'message' => $validator->errors()->all(),
    //             'result' => false
    //         ], 422));
    //     } else {
    //         throw (new ValidationException($validator))
    //             ->errorBag($this->errorBag)
    //             ->redirectTo($this->getRedirectUrl());
    //     }
    // }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator; 
use App\Exceptions\CustomValidationException;


class StoreUserRequest extends FormRequest
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
            'id' => 'required|string|unique:users,_id',
            'password' => 'required|string|',
            'name' => 'required|regex:/^[a-zA-Z\s]+$/|',
            'email' => 'required|email|unique:users,email',
            'job' => 'required|regex:/^[a-zA-Z\s]+$/|',
            'cv' => 'required|url|',
            'user_image' => 'required|url|',
            'experiences' => 'sometimes|required|array|',
            'experiences.*.start_date' => 'sometimes|required|date_format:d/m/Y',
            'experiences.*.end_date' => 'sometimes|required|date_format:d/m/Y',
            'experiences.*.location' => 'sometimes|required|string',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new CustomValidationException($validator);
    }
}

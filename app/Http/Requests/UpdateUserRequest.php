<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator; 
use App\Exceptions\CustomValidationException;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->_id === $this->user;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'password' => 'sometimes|required|string|',
            'name' => 'sometimes|required|regex:/^[a-zA-Z\s]+$/',
            'email' => 'sometimes|required|email|unique:users,email',
            'job' => 'sometimes|required|regex:/^[a-zA-Z\s]+$/|',
            'cv' => 'sometimes|required|url|',
            'user_image' => 'sometimes|required|url|',
            'experiences' => 'sometimes|required|array|',
            'experiences.*.start_date' => 'sometimes|required|date_format:d/m/Y',
            'experiences.*.end_date' => 'sometimes|required|date_format:d/m/Y',
            'experiences.*.location' => 'sometimes|required|string',
        ];;
    }

    protected function failedValidation(Validator $validator) {
        throw new CustomValidationException($validator);
    }
}

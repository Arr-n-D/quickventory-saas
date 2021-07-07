<?php

namespace App\Requests;

use App\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;


/**
 * Class RegisterRequest
 * @package App\Requests
 *
 * @property-read $username
 * @property-read $email
 * @property-read $date_of_birth
 * @property-read $password
 */
class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email:rfc,dns|unique:users|max:255',
            'date_of_birth' => 'required|date_format:Y-m-d|',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ];
    }
}

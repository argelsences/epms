<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $payload = $this->post('payload');
        $id = $payload['id'];
        $this->sanitize($payload);

        return [
            '*.name' => ['required', 'min:3'],
            '*.email' => ['required', 'email', Rule::unique((new User)->getTable())->ignore($id ?? null)],
            '*.password' => [$id ? 'nullable' : 'required', 'min:8']
        ];
    }

    /**
     * Sanitization of variables using native PHP sanitization
     */
    private function sanitize($input){
        // input fields here eg,
        $input['name'] = filter_var($input['name'], FILTER_SANITIZE_STRING);

        $this->replace($input);
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'payload.email.unique' => 'The email has already been taken',
        ];
    }
}

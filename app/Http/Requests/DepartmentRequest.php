<?php

namespace App\Http\Requests;

use App\Department;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
        $payload = $this->post('payload');
        //$id = $payload['id'];
        $email = $payload['email'];
        $url = $payload['url'];
        $id = $payload['id'];
        $this->sanitize($payload);

        return [
            '*.name'  => ['required', 'max:255'],
            '*.email' => ['required', 'email', Rule::unique((new Department)->getTable())->ignore($id ?? null)],
            '*.url'   => ['required', Rule::unique((new Department)->getTable())->ignore($id ?? null)],
            // and so on
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
}

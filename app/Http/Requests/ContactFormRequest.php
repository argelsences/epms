<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
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
    public function rules() {
        /*
        $validatedData = $request->validate([
            'g_recaptcha_response' => 'required|captcha',
            'name' => 'required|max:255',
            'email' => 'required|email',
            'message' => 'required|max:255',
        ]);
        */
        $this->sanitize();

        return [
            'g_recaptcha_response'  => ['required', 'captcha'],
            'name' => ['required', 'max:80'],
            'email' => ['required', 'email'],
            'message' => ['required', 'max:255']
            // and so on
        ];
    }

    /**
     * Sanitization of variables using native PHP sanitization
     */
    private function sanitize(){
        $input = $this->all();
        // input fields here eg,
        $input['name'] = filter_var($input['name'], FILTER_SANITIZE_STRING);
        $input['message'] = filter_var($input['message'], FILTER_SANITIZE_STRING);
        $input['email'] = filter_var($input['email'], FILTER_SANITIZE_EMAIL);

        $this->replace($input);
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'name.required' => 'The name is required',
            'email.required' => 'The email is required',
            'message.required' => 'The message is required',
        ];
    }
}

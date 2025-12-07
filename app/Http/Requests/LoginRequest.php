<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class LoginRequest extends FormRequest
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
            'email' => [
                'required',
                'max:191',
                'email:rfc,dns,spoof'
            ],
            'password' => [
                'required',
                'min:8',
                'max:16',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'メールアドレス',
            'password' => 'パスワード',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスまたはパスワードに誤りがあります。',
            'email.email' => '有効なメールアドレスを指定してください。',
            'password.required' => 'メールアドレスまたはパスワードに誤りがあります。',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        logger()->error('$errors', $errors);

        $messages = [];
        foreach ($errors as $field_errors) {
            foreach ($field_errors as $row) {
                $messages[] = $row;
            }
        }
        $error_messages = implode("\n", $messages);

        throw new HttpResponseException(response()->json(['error' => $error_messages], Response::HTTP_BAD_REQUEST));
    }
}

<?php

namespace App\Http\Requests;

class UserRegisterRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'token'=> "required",
            'name' => "required|min:2|max:60",
            'email'=> "required|email",
            'phone'=> "required|regex:/^[\+]{0,1}380([0-9]{9})$/i",
            'position_id' => "required|integer|min:1|exists:App\Models\Position,id",
            'photo' => "required|mimes:jpg,jpeg|dimensions:min_width=70,min_height=70|max:5120"
        ];
    }

    public function messages(): array
    {
        return[
            'name.min'=> 'The name must be at least 2 characters.',
            'email.email' => 'The email must be a valid email address.',
            'phone.required' => "The phone field is not required.",
            'phone.regex' => 'The phone field is invalid.',
            'position_id.integer' => 'The position id must be an integer.',
            'photo.max' =>  "The photo may not be greater than 5 Mbytes.",
            'photo.required' =>  "Image is invalid."
        ];
    }

}

<?php

namespace App\Http\Requests;

class UsersRequest extends ApiFormRequest
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
            'count' => "nullable|integer|min:1|max:100",
            'offset' => 'nullable|integer',
            'page' => "nullable|integer|min:1"
        ];
    }

    public function messages()
    {
        return [
            'count.integer' => 'The count must be an integer.',
            'count.min' => "The count must be at least 1.",
            'count.max' => "The count must be no more that 100.",
            'offset.integer' => 'The offset must be an integer.',
            'page.integer' => 'The page must be an integer.',
            'page.min' => "The page must be at least 1."
        ];
    }

}

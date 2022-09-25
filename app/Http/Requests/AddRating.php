<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddRating extends FormRequest
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
            // 'username' => 'required|string',
            'survey_id' => 'required|numeric',
            'comment' => 'required|string',
            'score' => 'required|numeric|between:0,10',
        ];
    }
}

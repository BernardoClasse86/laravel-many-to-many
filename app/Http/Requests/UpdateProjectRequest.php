<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest

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
            'title' => [
                'required',
                'string',
                'max:100',
                'min:3',
                Rule::unique('projects', 'title')->ignore($this->project)
            ],
            'description' => 'nullable|string|',
            'client_name' => 'nullable|string|',
            'project_url' => 'required|max:255|url|',
            'project_date' => 'required|date|',
            'type_id' => 'nullable|exists:types,id'
        ];
    }
}

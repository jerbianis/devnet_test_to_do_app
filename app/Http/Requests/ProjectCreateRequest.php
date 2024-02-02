<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectCreateRequest extends FormRequest
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
            'project_name' => ['required','string','max:30',Rule::unique('projects','name')],
            'project_description' => ['required','string','max:200'],
        ];
    }

    public function attributes()
    {
        return [
            'project_name' => 'project name',
            'project_description' => 'project description'
        ];
    }
}

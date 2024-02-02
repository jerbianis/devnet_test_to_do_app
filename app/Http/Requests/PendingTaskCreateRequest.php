<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PendingTaskCreateRequest extends FormRequest
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
            'project' => ['required'],
            'selected_project_id' => ['required'],
            'task_name' => ['required','string','max:80'],
            'priority' => ['required',Rule::in(['low', 'medium','high'])],
            'estimation' => ['required',Rule::in(['S','M','L','XL'])],
        ];
    }

    public function messages()
    {
        return [
            'selected_project_id.required' => 'You should select the project from the autocomplete list.',
        ];
    }
    public function attributes()
    {
        return [
            'task_name' => 'task',
        ];
    }
}

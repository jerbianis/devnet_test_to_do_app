<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskUpdateRequest extends FormRequest
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
            'task_name' => ['required','string','max:80'],
            'priority' => ['required',Rule::in(['low', 'medium','high'])],
            'employee' => ['nullable','string'],
            'selected_employee_email' => ['required_with:employee'],
            'estimation' => ['nullable',Rule::in(['0','S','M','L','XL'])],
        ];
    }
}

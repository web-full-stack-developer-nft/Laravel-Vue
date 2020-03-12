<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'task_name' => 'required',
            'issue_id' => 'required',
            'user_id' => 'required',
            'status_id' => 'required', 
            'priority' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'task_name.required' => 'Task name is required',
            'issue_id.required'  => 'Issue is required',
            'user_id.required'  => 'Responsible person is required',
            'status_id.required'  => 'Task status is required',
            'priority.required'  => 'Task priority is required',
        ];
    }
}

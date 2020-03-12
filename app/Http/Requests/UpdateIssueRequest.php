<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIssueRequest extends FormRequest
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
            'title' => 'required',
            'project_id' => 'required',
            'issue_type_id' => 'required',
            'status_id' => 'required', 
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
            'title.required' => 'Issue title is required',
            'project_id.required'  => 'Project is required',
            'issue_type_id.required'  => 'Issue type is required',
            'status_id.required'  => 'Issue status is required',
        ];
    }
}

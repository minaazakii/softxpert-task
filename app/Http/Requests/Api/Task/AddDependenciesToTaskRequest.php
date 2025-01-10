<?php

namespace App\Http\Requests\Api\Task;

use Illuminate\Foundation\Http\FormRequest;

class AddDependenciesToTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dependencies_tasks_ids' => 'required|array',
            'dependencies_tasks_ids.*' => 'integer|exists:tasks,id',
        ];
    }

    public function messages(): array
    {
        return [
            'dependencies_tasks_ids.*.exists' => 'Dependencies tasks ids must exist in the tasks table',
        ];
    }
}

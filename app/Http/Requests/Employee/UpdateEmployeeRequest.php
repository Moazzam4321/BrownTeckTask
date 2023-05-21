<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateEmployeeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(Request $request): array
    {
       // dd($request->updatedFields);
        return [
            'employeeId'=> 'required',
            'updatedFields[first_name]' => 'nulaable|min:3',
            'updatedFields[last_name]' => 'nullable|min:3',
            'updatedFields[email]' => 'nullable|email',
            'updatedFields[phone]' => 'nullable|regex:/^[0-9]{10}$/',
        ];
    }
}

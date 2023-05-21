<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AddEmployeeRequest extends FormRequest
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
        //dd($request);
        return [
            //
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'company_id'=> 'nullable',
            'email'=> 'nullable|email',
            'Phone' => 'nullable|regex:/^[0-9]{10}$/',
        ];
    }
}

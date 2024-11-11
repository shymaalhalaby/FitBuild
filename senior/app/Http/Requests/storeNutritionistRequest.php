<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeNutritionistRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required| email| unique:members,email',
            'password' => 'sometimes|required|string',
            'phone_number' => 'sometimes|required|digits_between:10,15',
            'Age' => 'sometimes|required|integer|min:0',
            'gender' => 'in:male|female',
            'WorkHours'=>'required|string',
            'training_price' => 'required|string',
            'work_type' => 'required|in:Freelance,WithGym',
        ];
    }
}

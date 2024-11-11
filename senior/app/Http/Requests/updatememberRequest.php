<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updatememberRequest extends FormRequest
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
            // 'email' => 'required| email| unique:members,email',
             'password' => 'sometimes|required|string',
            'gender' => 'required|in:male,female',
            'phone_number' => 'required|string',
            'GOAL' => 'required|string',
            'Subscription_type'=>'nullable',
            'AT' => 'required|in:Home,Gym',
            'Age' => 'required|integer|min:0',
            'illness' => 'nullable|string',
            'Physical_case' => 'nullable|string',
            'Hieght' => 'required|numeric|min:0',
            'Wieght' => 'required|numeric|min:0',
            'target_Wieght' => 'required|numeric|min:0',
            'nutritionist_id' => 'sometimes|nullable|exists:nutritionists,id',
            'coach_id' => 'sometimes|nullable|exists:coaches,id',

        ];
    }
}

<?php

namespace App\Http\Requests\SubTask;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubTaskRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'title' => 'required|string|max:255',
            'task_id' => 'required|exists:tasks,id',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed'
        ];
    }
    public function messages()
    {
        return [
            'user_id.required' => 'يجب تحديد مستخدم',
            'user_id.exists' => 'المستخدم المحدد غير موجود',
            'title.required' => 'عنوان المهمة مطلوب',
            'title.max' => 'يجب ألا يتجاوز العنوان 255 حرفًا',
            'status.required' => 'حالة المهمة مطلوبة',
            'status.in' => 'حالة المهمة غير صالحة'
        ];
    }

     public function attributes()
    {
        return [
            'user_id' => 'المستخدم',
            'title' => 'العنوان',
            'description' => 'الوصف',
            'status' => 'الحالة'
        ];
    }

}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Context;

class ExpenseRequest extends FormRequest
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
        $rules = [];
        $method = strtolower($this->getMethod());

        if ($method != "post") {
            $rules['id'] = ["exists:expenses,id"];
        } 
        
        if (in_array($method, ["post", "patch", "put"])) {
            $rules = array_merge($rules, [
                "description" => ["required"],
                "expense_date" => ["required", "date_format:Y-m-d", "after:1900-01-01", "before:now"],
                "amount" => ["required", "decimal:0,2", "gt:0"],
                "type" => ["required", "in:travel,equipment,others"],
                "type_details" => ["required_if:type,others"],
                "project_id" => ["required", "exists:projects,id"],
            ]);

            $user = Context::get("user");
            if ($user->is_admin()) {
                $rules["status"] = ["required", "in:approved,pending,rejected"];
            }
        }

        return $rules;
    }

    protected function prepareForValidation() {
        if ($id = $this->route('id')) {
            $this->merge(['id' => $id]);
        }
    }

    protected function failedValidation(Validator $validator) {
        $error = $validator->errors()->first();
        throw new HttpResponseException(
            response()->json(['error' => $error], 400)
        );
    }
}

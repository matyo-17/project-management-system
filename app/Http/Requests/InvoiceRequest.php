<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class InvoiceRequest extends FormRequest
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
            $rules['id'] = ["exists:invoices,id"];
        } 
        
        if (in_array($method, ["post", "patch", "put"])) {
            $rules = array_merge($rules, [
                "due_date" => ["required", "date_format:Y-m-d", "after:today"],
                "amount" => ["required", "decimal:0,2", "gt:0"],
                "project_id" => ["required", "exists:projects,id"],
            ]);
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

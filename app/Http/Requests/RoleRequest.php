<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            $rules['id'] = ["exists:roles,id"];
        } 
        
        if (in_array($method, ["post", "patch", "put"])) {
            $rules = array_merge($rules, [
                "name" => ["required"],
                "admin" => ["required"],
                "status" => ["required", "boolean"],
                "permissions" => ["nullable", "array", "exists:permissions,id"],
            ]);
        }

        return $rules;
    }
}

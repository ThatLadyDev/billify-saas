<?php

namespace App\Http\Requests;

use App\Actions\GetTenant;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateSubscriptionRequest extends FormRequest
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
            'tenant' => 'required|uuid',
            'plan' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                // Fetch tenant information
                $tenant = (new GetTenant())->execute($this->tenant);
                if (!$tenant) {
                    $validator->errors()->add(
                        'tenant',
                        'Tenant not found'
                    );
                }
            }
        ];
    }
}

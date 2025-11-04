<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ClientStatusEnum;
class ClientRequest extends FormRequest
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
        $clientId = $this->route('client'); 

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('clients')->ignore($clientId), 
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('clients')->ignore($clientId),
            ],
            'address' => ['required', 'string', 'max:500'],
            'balance' => ['nullable', 'numeric'],
            'status' => ['required', 'in:' . ClientStatusEnum::active->value . ',' . ClientStatusEnum::inactive->value],
        ];
    }
}

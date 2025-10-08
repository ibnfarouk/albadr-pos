<?php

namespace App\Http\Requests\Admin;

use App\Enums\UnitStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $Enum = UnitStatusEnum::class;
        return [
            'name' => 'required|string|max:255|unique:units,name,' . $this->route('unit'),
            'status' => $UnitStatusEnum::labels(),


        ];
    }
}

<?php

namespace App\Http\Requests\Order;

use App\Enums\Order\OrderByEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
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
            'date' => ['nullable', 'string', 'max:255'],
            'userId' => ['nullable', 'integer', 'exists:users,id'],
            'orderBy' => ['nullable', Rule::enum(OrderByEnum::class)],
            'test' => ['string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->orderBy) {
            $this->merge(['orderBy' => OrderByEnum::ID_DESC->value]);
        }
    }
}

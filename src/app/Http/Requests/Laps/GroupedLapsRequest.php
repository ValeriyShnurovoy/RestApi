<?php

namespace App\Http\Requests\Laps;

use Illuminate\Foundation\Http\FormRequest;

class GroupedLapsRequest extends FormRequest
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
            'driver_numbers' => ['nullable', 'array'],
            'driver_numbers.*' => ['int', 'min:1'],

            'sum_time' => ['nullable', 'boolean'],

            'lap_range' => ['nullable', 'array'],
            'lap_range.0' => ['integer', 'min:1'],
            'lap_range.1' => ['integer', 'min:1'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $lapRange = $this->input('lap_range', null);
            if ($lapRange && $lapRange[0] > $lapRange[1]) {
                $validator->errors()->add('lap_range', 'The start of the lap range must be less than or equal to the end.');
            }
        });
    }
}

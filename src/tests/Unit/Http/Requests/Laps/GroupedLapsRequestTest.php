<?php

namespace Tests\Unit\Http\Requests\Laps;

use App\Http\Requests\Laps\GroupedLapsRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class GroupedLapsRequestTest extends TestCase
{
    public function test_valid_data_passes_validation(): void
    {
        $data = [
            'driver_numbers' => [1, 2, 3],
            'sum_time' => true,
            'lap_range' => [1, 5],
        ];

        $request = new GroupedLapsRequest();
        $validator = Validator::make($data, $request->rules());
        $request->withValidator($validator);

        $this->assertTrue($validator->passes());
    }

    public function test_invalid_driver_numbers_fail(): void
    {
        $data = [
            'driver_numbers' => [0, -2, 'abc'],
        ];

        $request = new GroupedLapsRequest();
        $validator = Validator::make($data, $request->rules());
        $request->withValidator($validator);

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('driver_numbers.0', $validator->errors()->messages());
    }

    public function test_lap_range_start_greater_than_end_fails(): void
    {
        $data = [
            'lap_range' => [5, 1],
        ];

        $validator = Validator::make($data, (new GroupedLapsRequest())->rules());

        (new GroupedLapsRequest())->withValidator($validator);

        $validator->after(function ($validator) use ($data) {
            $lapRange = $data['lap_range'] ?? null;
            if ($lapRange && $lapRange[0] > $lapRange[1]) {
                $validator->errors()->add('lap_range', 'The start of the lap range must be less than or equal to the end.');
            }
        });

        $this->assertFalse($validator->passes());
        $this->assertStringContainsString(
            'The start of the lap range must be less than or equal to the end.',
            implode(' ', $validator->errors()->all())
        );
    }

    public function test_nullable_fields_pass_when_absent(): void
    {
        $data = []; // пустой запрос

        $request = new GroupedLapsRequest();
        $validator = Validator::make($data, $request->rules());
        $request->withValidator($validator);

        $this->assertTrue($validator->passes());
    }
}

<?php

namespace Tests\Feature\Http\Controllers;

use App\Application\Laps\GroupedLapsService;
use Tests\TestCase;
use Mockery;

class LapsControllerFeatureTest extends TestCase
{
    public function test_grouped_returns_json(): void
    {
        $filters = [
            'driver_numbers' => ['44','7'],
            'sum_time' => '1',
            'lap_range' => ['1','5'],
        ];

        $mockService = Mockery::mock(GroupedLapsService::class);
        $mockService->shouldReceive('execute')
                    ->once()
                    ->with(Mockery::type('array')) // любой массив
                    ->andReturn([
                ['driver_number' => 44, 'lap_number' => 1, 'duration' => 100],
                ['driver_number' => 7, 'lap_number' => 2, 'duration' => 105],
            ]);

        $this->app->instance(GroupedLapsService::class, $mockService);

        $response = $this->getJson('/api/laps/grouped', $filters);

        $response->assertStatus(200)
                 ->assertJson([
                     ['driver_number' => 44, 'lap_number' => 1, 'duration' => 100],
                     ['driver_number' => 7, 'lap_number' => 2, 'duration' => 105],
                 ]);
    }

    public function test_invalid_request_returns_validation_error(): void
    {
        $filters = [
            'driver_numbers' => ['0','-7'],
            'lap_range' => ['5','1'],
        ];

        $response = $this->getJson('/api/laps/grouped?' . http_build_query($filters));
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['driver_numbers.0','driver_numbers.1','lap_range']);
    }
}

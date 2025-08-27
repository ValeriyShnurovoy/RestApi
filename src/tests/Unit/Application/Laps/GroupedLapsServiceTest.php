<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Laps;

use App\Application\Laps\GroupedLapsService;
use App\Domain\Laps\Lap;
use App\Domain\Laps\LapRepositoryInterface;
use PHPUnit\Framework\TestCase;

class GroupedLapsServiceTest extends TestCase
{
    public function testReturnsGroupedLapsForSingleDriver(): void
    {
        $lap1 = new Lap(1, 44, 30.1, 28.5, 29.2);
        $lap2 = new Lap(2, 44, 29.9, 28.7, 29.5);

        $mockRepo = $this->createMock(LapRepositoryInterface::class);
        $mockRepo->method('getLaps')
                 ->with([44], null)
                 ->willReturn([$lap1, $lap2]);

        $service = new GroupedLapsService($mockRepo);

        $result = $service->execute([
            'driver_numbers' => [44],
            'lap_range' => null,
            'sum_time' => true,
        ]);

        $this->assertCount(2, $result);
        $this->assertEquals(87.8, $result[1][44]);
        $this->assertEquals(88.1, $result[2][44]);
    }

    public function testFiltersByLapRange(): void
    {
        $lap1 = new Lap(1, 44, 30.1, 28.5, 29.2);
        $lap2 = new Lap(2, 44, 29.9, 28.7, 29.5);
        $lap3 = new Lap(3, 44, 30.0, 28.8, 29.6);

        $mockRepo = $this->createMock(LapRepositoryInterface::class);
        $mockRepo->method('getLaps')
                 ->with([44], [2,3])
                 ->willReturn([$lap2, $lap3]);

        $service = new GroupedLapsService($mockRepo);

        $result = $service->execute([
            'driver_numbers' => [44],
            'lap_range' => [2,3],
            'sum_time' => true,
        ]);

        $this->assertCount(2, $result);
        $this->assertEquals(88.1, $result[2][44]);
        $this->assertEquals(88.4, $result[3][44]);
    }

    public function testReturnsSectorDurationsWhenDataTypeIsSectors(): void
    {
        $lap = new Lap(1, 44, 30.1, 28.5, 29.2);

        $mockRepo = $this->createMock(LapRepositoryInterface::class);
        $mockRepo->method('getLaps')
                 ->with([44], null)
                 ->willReturn([$lap]);

        $service = new GroupedLapsService($mockRepo);

        $result = $service->execute([
            'driver_numbers' => [44],
            'lap_range' => null,
        ]);

        $this->assertEquals([
            'sector_1' => 30.1,
            'sector_2' => 28.5,
            'sector_3' => 29.2,
        ], $result[1][44]);
    }
}

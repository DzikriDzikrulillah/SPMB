<?php

namespace Tests\Unit;

use App\Services\WaspasService;
use Illuminate\Support\Collection;
use Tests\TestCase;

class WaspasCostNormalizationTest extends TestCase
{
  public function test_min_positive_cost_ignores_zero_and_negative_values(): void
  {
    $service = new class extends WaspasService {
      public function getMinPositiveValue(array $values): ?float
      {
        return $this->resolveMinPositiveCostValue(collect($values));
      }

      public function normalizeCostValue(float $value, ?float $minPositive): float
      {
        return $this->normalizeCostIncomeForCalculation($value, $minPositive);
      }
    };

    $this->assertSame(1000000.0, $service->getMinPositiveValue([0, 1000000, 2000000, 5000000, 10000000]));
    $this->assertSame(1.0, $service->normalizeCostValue(1000000.0, 1000000.0));
    $this->assertSame(0.5, $service->normalizeCostValue(2000000.0, 1000000.0));
    $this->assertSame(0.2, $service->normalizeCostValue(5000000.0, 1000000.0));
    $this->assertSame(0.1, $service->normalizeCostValue(10000000.0, 1000000.0));
    $this->assertSame(1.0, $service->normalizeCostValue(0.0, 1000000.0));
    $this->assertSame(0.0, $service->normalizeCostValue(-500000.0, 1000000.0));
  }

  public function test_no_positive_value_returns_safe_zero_without_division_by_zero(): void
  {
    $service = new class extends WaspasService {
      public function getMinPositiveValue(array $values): ?float
      {
        return $this->resolveMinPositiveCostValue(collect($values));
      }

      public function normalizeCostValue(float $value, ?float $minPositive): float
      {
        return $this->normalizeCostIncomeForCalculation($value, $minPositive);
      }
    };

    $this->assertNull($service->getMinPositiveValue([0, -1000, -2000]));
    $this->assertSame(0.0, $service->normalizeCostValue(0.0, null));
    $this->assertSame(0.0, $service->normalizeCostValue(-1500.0, null));
  }
}

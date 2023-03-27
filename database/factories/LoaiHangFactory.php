<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoaiHang>
 */
class LoaiHangFactory extends Factory
{
    protected $model = \App\Models\LoaiHang::class;

    public function definition(): array
    {
        return [
            'ten_loai_hang' => $this->faker->text(50),
            'id_trang_thai' => $this->faker->numberBetween($min = 1, $max = 3),
            'mo_ta' => $this->faker->text(255),
        ];
    }
}

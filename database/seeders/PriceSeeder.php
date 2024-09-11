<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Price;
class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $price = [
            0,10,15,20,25,30
        ];
        foreach ($price as $value) {
            Price::create([
                'value' => $value
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        $currencies = [
            ['name' => 'US Dollar', 'code' => 'USD'],
            ['name' => 'Euro', 'code' => 'EUR'],
            ['name' => 'Japanese Yen', 'code' => 'JPY'],
            ['name' => 'British Pound', 'code' => 'GBP'],
            ['name' => 'Australian Dollar', 'code' => 'AUD'],
            ['name' => 'Canadian Dollar', 'code' => 'CAD'],
            // Add more currencies as needed
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}

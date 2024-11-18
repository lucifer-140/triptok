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
            ['name' => 'Swiss Franc', 'code' => 'CHF'],
            ['name' => 'Chinese Renminbi', 'code' => 'CNY'],
            ['name' => 'Indian Rupee', 'code' => 'INR'],
            ['name' => 'Brazilian Real', 'code' => 'BRL'],
            ['name' => 'South African Rand', 'code' => 'ZAR'],
            ['name' => 'Singapore Dollar', 'code' => 'SGD'],
            ['name' => 'Hong Kong Dollar', 'code' => 'HKD'],
            ['name' => 'New Zealand Dollar', 'code' => 'NZD'],
            ['name' => 'Mexican Peso', 'code' => 'MXN'],
            ['name' => 'Russian Ruble', 'code' => 'RUB'],
            ['name' => 'Indonesian Rupiah', 'code' => 'IDR'],
            ['name' => 'Turkish Lira', 'code' => 'TRY'],
            ['name' => 'Norwegian Krone', 'code' => 'NOK'],
            ['name' => 'Danish Krone', 'code' => 'DKK'],
            ['name' => 'Swedish Krona', 'code' => 'SEK'],
            ['name' => 'Thai Baht', 'code' => 'THB'],
            ['name' => 'Philippine Peso', 'code' => 'PHP'],
            ['name' => 'Vietnamese Dong', 'code' => 'VND'],
            ['name' => 'Malaysian Ringgit', 'code' => 'MYR'],
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}

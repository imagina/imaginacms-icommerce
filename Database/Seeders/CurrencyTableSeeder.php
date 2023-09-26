<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Icommerce\Entities\Currency;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        $copSeed = Currency::where('code', 'COP')->first();

        if (! isset($copSeed->id)) {
            Currency::create([
                'code' => 'COP',
                'symbol_left' => '$',
                'symbol_right' => '',
                'decimals' => '',
                'value' => 1,
                'status' => 1,
                'default_currency' => true,

            ]);
        }
    }
}

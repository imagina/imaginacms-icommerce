<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class IcommerceDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(OrderStatusTableSeeder::class);
        $this->call(ItemTypeTableSeeder::class);
        $this->call(CurrencyTableSeeder::class);
        $this->call(StoreTableSeeder::class);
        $this->call(NotificationRulesTableSeeder::class);
        //$this->call(IformQuoteTableSeeder::class);
        $this->call(IformRequestQuoteTableSeeder::class);
        //$this->call(IformLetMeKnowWhenProductIsAvailableTableSeeder::class);
        $this->call(CreateFormsTableSeeder::class);


    }
}

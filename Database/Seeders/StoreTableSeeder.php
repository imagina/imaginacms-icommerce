<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Icommerce\Entities\Store;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $default = Store::where('name', 'Default')->first();

        if (! isset($default->id)) {
            Store::create([
                'name' => 'Default',
                'address' => 'N/a',
                'phone' => '00000000',

            ]);
        }
    }
}

<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
// Events
use Modules\Icommerce\Events\FormIsCreating;

class CreateFormsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        event(new FormIsCreating());
    }
}

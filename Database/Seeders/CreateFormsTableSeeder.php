<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

// Events
use Modules\Icommerce\Events\FormIsCreating;

class CreateFormsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    
    Model::unguard();

    event(new FormIsCreating());
    

  }

}
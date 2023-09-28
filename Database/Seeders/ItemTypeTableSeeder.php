<?php

namespace Modules\Icommerce\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Icommerce\Entities\ItemType;

class ItemTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $itemTypes = config('asgard.icommerce.config.itemTypes');

        foreach ($itemTypes as $type) {
            $statusTrans = $type['title'];

            foreach (['en', 'es'] as $locale) {
                $data = [
                    'id' => $type['id'],
                    $locale => [
                        'title' => $type['title'],
                    ],
                ];
                $itemType = ItemType::find($type['id']);
                if (isset($itemType->id)) {
                    $itemType->update($data);
                } else {
                    $itemType = ItemType::create($data);
                }
            }//End Foreach
        }//End Foreach
    }
}

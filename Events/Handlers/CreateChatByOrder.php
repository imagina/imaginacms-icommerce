<?php

namespace Modules\Icommerce\Events\Handlers;

use Modules\Isite\Entities\Organization;

class CreateChatByOrder
{
    public function handle($event = null)
    {
        //\Log::info('Icommerce: Handler - Save Points =======');
        if (is_module_enabled('Ichat') && setting('icommerce::chatByOrderEnable', null, false)) {
            $order = $event->order;
            $tenant = function_exists('tenant') ? tenant() : null;
            $users = [];
            if (isset($order->customer_id)) {
                array_push($users, ['user_id' => $order->customer_id]);
            }
            if (isset($tenant->id)) {
                array_push($users, [
                    'user_id' => $tenant->user_id,
                ]);
            } elseif (isset($order->organization_id) && ! empty($order->organization_id)) {
                $organization = Organization::find($order->organization_id);
                array_push($users, [
                    'user_id' => $organization->user_id,
                ]);
            } else {
                $usersToNotify = json_decode(setting('icommerce::usersToNotify', null, '[]'));
                foreach ($usersToNotify as $userId) {
                    array_push($users, [
                        'user_id' => $userId,
                    ]);
                }
            }

            $data = [
                'entity_id' => $order->id,
                'entity_type' => get_class($order),
                'private' => true,
                'users' => $users,
            ];
            // dd($data,app("Modules\Ichat\Services\ConversationService"));
            // Create Point
            $pointCreated = app("Modules\Ichat\Services\ConversationService")->create($data);
        }// Validation If Module
    }
}

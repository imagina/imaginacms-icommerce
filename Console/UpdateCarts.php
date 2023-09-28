<?php

namespace Modules\Icommerce\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class UpdateCarts extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cart:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command update the cart to status Abandoned';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $cartRepository = app('Modules\Icommerce\Repositories\CartRepository');
        $carts = $cartRepository->getItemsBy(json_decode(json_encode(['filter' => ['status' => 1], 'include' => [], 'take' => null])));

        foreach ($carts as $item) {
            $this->cartRepository->update($item, ['status' => 0]);
        }
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments(): array
    {
        return [

        ];
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}

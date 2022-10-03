<?php

namespace App\Modules\User\Console;

use App\Modules\User\Entities\User;
use Illuminate\Console\Command;

class ActivateUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'users:activate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'activate users after disable period finished';

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
     *
     * @return mixed
     */
    public function handle()
    {
        $this->getUsers()->update([
            'deactivated_from' => null,
            'deactivated_at' => null,
        ]);
    }

    private function getUsers()
    {
        $users = User::whereNotNull('deactivated_from')
            ->where('deactivated_at', today());
        return $users;
    }
}

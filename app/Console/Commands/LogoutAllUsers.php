<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class LogoutAllUsers extends Command
{
    protected $signature = 'logout:all';
    protected $description = 'Log out all users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->tokens->each(function ($token, $key) {
                $token->delete();
            });
        }
    
        $this->info('All users have been logged out.');
    }
    
}

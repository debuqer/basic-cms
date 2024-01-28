<?php

namespace App\Console\Commands;

use App\Domain\User\Constants\UserRole;
use App\Models\Blog\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AssignRolesCommand extends Command
{
    protected $signature = 'app:assign-roles-command';


    protected $description = 'Assigns default roles to users';


    public function handle()
    {
        DB::table('users')->where('email', 'admin@local.dev')->update(['role' => UserRole::Admin->value]);
        DB::table('users')->where('email', 'author@local.dev')->update(['role' => UserRole::Author->value]);

        Article::factory(10)->drafted()->create();
        Article::factory(10)->published()->create();
    }
}

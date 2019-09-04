<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;

class UsersTableAddDefilerIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defiler_users = DB::connection('mysql2')
            ->table('user as u')
            ->join("lis_tourney_player as li", 'li.id_user', '=', 'u.id')
            ->select('u.login', 'u.id', 'li.id_user')
            ->groupBy('li.id_user')
            ->get();
        foreach ($defiler_users as $user) {
            try {
                $check = DB::table('users')->where('name',  trim($user->login))->exists();

                if($check) {
                    DB::table('users')
                        ->where('email', $user->login)
                        ->update(['defiler_id' => $user->id]);
                }
            } catch (\Exception $e) {
                dd($e, $check);
            }
        }
    }
}

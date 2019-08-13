<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;

class TourneyUserTableUpdateSeeder extends Seeder
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
                    ->select('u.login', 'li.id_user')
                    ->groupBy('li.id_user')
                    ->get();      
        foreach ($defiler_users as $user) {
            try {
                $check = DB::table('users')->where('name',  trim($user->login))->exists();
                $index = 16700;
                $insert_user = array();
            
                if($check) {                
                } else {               
                    $insert_user = array( 
                        'name' => $user->login,
                        'email' => $user->login,
                        'password' => '',
                        'user_role_id' => 0
                    );
                    User::create($insert_user);
                    $index++;
                }
            } catch (\Exception $e) {
                dd($e, $check, $insert_user );
            }
        }       
    }
}

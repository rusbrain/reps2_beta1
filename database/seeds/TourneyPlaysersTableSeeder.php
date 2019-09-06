<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\{User, TourneyList, TourneyPlayer};

class TourneyPlaysersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tourney_players = DB::connection('mysql2')
                    ->table('user as u')
                    ->join("lis_tourney_player as li", 'li.id_user', '=', 'u.id')
                    ->select('u.login', 'li.*')
                    ->get();
        foreach ($tourney_players as $player) {
            try {
                $user = DB::table('users')->where('name',  trim($player->login))->first();
                $user_id = $user->id;
                $tourney = DB::table('tourney_lists')->where('tourney_id',  $player->id_tourney)->first();
                if(!empty($tourney)){
                    $tourney_id = $tourney->id;

                    $insert_player = array(
                        'tourney_id' => $tourney_id,
                        'defiler_player_id' => $player->id,
                        'user_id' => $user_id,
                        'check_in' => $player->checkin == 'YES' ? 1 : 0,
                        'description' => $player->description,
                        'place_result' => $player->place_result
                    );
                    TourneyPlayer::create($insert_player);
                }


            } catch (\Exception $e) {
                dd($e,$player );
            }
        }

    }
}

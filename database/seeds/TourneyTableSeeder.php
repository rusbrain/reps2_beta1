<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\TourneyList;

class TourneyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status_array = array(
            0=> 'ANNOUNCE', 1=> 'REGISTRATION', 2=> 'CHECK-IN', 3=> 'GENERATION', 4=> 'STARTED', 5=> 'FINISHED'
        );

        $visibilities = array( 0=> 'HIDDEN', 1=> 'VISIBLE' );
        $map_types = array( 0=> 'NONE', 1=> 'FIRSTBYREMOVING', 2=> 'FIRSTBYROUND');
        $rankings = array(0=> 'NO', 1=> 'YES');


        $tourney_lists = DB::connection('mysql2')
                    ->table("lis_tourney")                  
                    ->where('visible', 'VISIBLE')
                    ->select('*')
                    ->get();      
        foreach ($tourney_lists as $tourney) {
            try {
                    
                $insert_tourneys = array( 
                    'tourney_id' => $tourney->id,
                    'name' => $tourney->name,
                    'place' => $tourney->place,
                    'prize_pool' => $tourney->prize_pool,
                    'status' => array_search($tourney->state, $status_array),
                    'visible' => array_search($tourney->visible, $visibilities),
                    'maps' => $tourney->maps,
                    'rules_link' => $tourney->rules_link,
                    'vod_link' => $tourney->vod_link,
                    'logo_link' => $tourney->logo_link,
                    'map_selecttype' =>  array_search($tourney->map_selecttype, $map_types),
                    'importance' => $tourney->importance,
                    'is_ranking' => array_search($tourney->is_ranking, $rankings),
                    'password' => $tourney->password,
                    'checkin_time' => date('Y-m-d H:i:s', $tourney->time_checkin),
                    'start_time' => date('Y-m-d H:i:s', $tourney->time_start),
                    'created_at' => date('Y-m-d H:i:s', $tourney->time_reg),
                    'updated_at' => date('Y-m-d H:i:s', $tourney->time_reg),
                );
                TourneyList::create($insert_tourneys);                
               
            } catch (\Exception $e) {
                dd($e,$insert_tourneys );
            }
        }     
    }
}

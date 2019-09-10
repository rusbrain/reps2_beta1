<?php

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UpdateRaceDefilerUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $raceArray = array(
            'zerg' => 'Z',
            'protoss'=>'P',
            'terran'=>'T'
        );
        $defiler_users = DB::connection('mysql2')
            ->table('user_info')
            ->select('id', 'race')
            ->get();
        foreach ($defiler_users as $user) {
            try {
                DB::table('users')
                    ->where('defiler_id', $user->id)
                    ->update(['race' => (empty($user->race) ? 'ALL' : $raceArray[$user->race])]);

            } catch (\Exception $e) {
                dd($e );
            }
        }
    }
}

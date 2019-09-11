<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\ReplayMap;

class UpdateTourneyMaps extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tourneys = DB::table('tourney_lists')->get();
        foreach ($tourneys as $item) {
            if (trim($item->maps) != '') {

                $maps = explode(",", $item->maps);
                $regMapIDs = array();
                foreach ($maps as $m) {
                    $map = trim($m);
                    $checkMap = DB::table('replay_maps')->where('name', $map)->first();
                    if (!$checkMap) {
                        $createMap = ReplayMap::create([
                            'name' => $map,
                            'url' => '/storage/maps/jpg256/' . $map . '.jpg'
                        ]);
                        $regMapIDs[] = $createMap->id;
                    } else {
                        $regMapIDs[] = $checkMap->id;
                        continue;
                    }

                }
                if (!empty($regMapIDs)) {
                    DB::table('tourney_lists')
                        ->where('id', $item->id)
                        ->update(['maps' => implode(",", $regMapIDs)]);
                }
            }
        }
    }
}

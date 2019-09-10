<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\File;
use App\TourneyMatch;

class TourneyFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $matches = DB::table('tourney_matches')->select('id','rep1','rep2','rep3','rep4','rep5','rep6','rep7')->get();
        foreach ($matches as $match) {
            foreach ($match as $key => $repCol) {
                if($key == 'id' || $repCol == '#WO#') continue;
                try{
                    if ($repCol) {
                        $filedata = array(
                            'link'=>'/storage/tourney/'.$repCol,
                            'resource_type' => ''
                        );
                        $tourney_file = File::create($filedata);

                        $updateMatch = DB::table('tourney_matches')
                            ->where('id', $match->id)
                            ->update([$key => $tourney_file->id]);

                    }

                } catch (\Exception $e){
                    dd($e);
                }
            }

        }
    }
}

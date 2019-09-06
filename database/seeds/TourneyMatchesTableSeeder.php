<?php

use App\TourneyPlayer;
use App\TourneyMatch;
use App\TourneyList;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TourneyMatchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $actionArray = [0 => 'TOP', 1 => 'GOTO_P1', 2 => 'GOTO_P2', 3 => 'NONE'];

    public function run()
    {
        $defiler_matches = DB::connection('mysql2')->table('lis_tourney_match')->get();
        foreach ($defiler_matches as $match) {
            try {
                $tourney = TourneyList::where('tourney_id', $match->id_tourney)->first();
                $player1 = TourneyPlayer::where('defiler_player_id', $match->id_player1)->first();
                $player2 = TourneyPlayer::where('defiler_player_id', $match->id_player2)->first();
                if (!empty($match) && !empty($tourney)) {
                    $insert_match = array(
                        'tourney_id' => $tourney->id,
                        'match_id' => $match->id_match,
                        'round' => $match->round,
                        'round_id' => $match->round_id,
                        'player1_id' => !empty($player1) ? $player1->id : 0,
                        'player2_id' => !empty($player2) ? $player2->id : 0,
                        'player1_score' => $match->score_player1,
                        'player2_score' => $match->score_player2,
                        'win_score' => $match->score_win,
                        'winner_action' => array_search($match->winner_action, $this->actionArray),
                        'winner_value' => $match->winner_value,
                        'looser_action' => array_search($match->looser_action, $this->actionArray),
                        'looser_value' => $match->looser_value,
                        'played' => ($match->played == 'YES') ? 1 : 0,
                        'rep1' => $match->rep1,
                        'rep2' => $match->rep2,
                        'rep3' => $match->rep3,
                        'rep4' => $match->rep4,
                        'rep5' => $match->rep5,
                        'rep6' => $match->rep6,
                        'rep7' => $match->rep7,
                    );
                    TourneyMatch::create($insert_match);
                }


            } catch (\Exception $e) {
                dd($e, $match);
            }
        }
    }
}

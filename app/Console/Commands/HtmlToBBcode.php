<?php

namespace App\Console\Commands;

use App\Services\GeneralViewHelper;
use Illuminate\Console\Command;
use App\Services\HtmlToBBcodeParserHelper;
use Illuminate\Support\Facades\DB;
use Log;

class HTMLToBbcode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convertHtmlToBbcode {type}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public $general_helper;
    public $htmltobbcode_helper;

    public function __construct()
    {
        parent::__construct();
        $this->general_helper = new GeneralViewHelper;
        $this->htmltobbcode_helper = new HtmlToBBcodeParserHelper;
    }

    /**
     * Get type Forum, Replay, Comment, Stream, etc
     * @return array|string|null
     *
     */
    private function get_type()
    {
        return $this->argument("type");
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get command type {forum, replay, comment, stream}
        $type = $this->get_type();
        switch ($type) {
            case 'forum':
                $tablename = 'forum_topics';
                break;
            case 'replay':
                $tablename = 'replays';
                break;
            case 'comment':
                $tablename = 'comments';
                break;
            case 'stream':
                $tablename = 'streams';
                break;
            default:
                dd('no type');
                break;
        }

        //Get data by table name and command type

        $data = DB::table($tablename)
            ->where('is_parsed', 0)
//            ->where('id',131)
            ->limit(50000)
            ->get();

        $progressBar = $this->output->createProgressBar($data->count());
        $progressBar->start();

        foreach ($data as $item) {

            try {
                $content = $this->general_helper->lowerTagconvert($item->content);
                $content = $this->general_helper->closeAllTags($content);
                $content = $this->general_helper->encodeUrls($content);
//                $content="";
                $bbcode_content = $this->htmltobbcode_helper->html_bbcode_format($content);
                $parsed_content = urldecode(html_entity_decode($bbcode_content));

                if ($type == 'forum') {
                    $parsed_preview_content = null;
                    if (!empty($item->preview_content)) {

                        $preview_content = $this->general_helper->lowerTagconvert(($item->preview_content));
                        $preview_content = $this->general_helper->closeAllTags($preview_content);
                        $preview_content = $this->general_helper->encodeUrls($preview_content);
                        $bbcode_preview_content = $this->htmltobbcode_helper->html_bbcode_format(($preview_content));
                        $parsed_preview_content = urldecode(html_entity_decode($bbcode_preview_content));
                    }

                    $update_array = array(
                        'content' => $parsed_content,
                        'preview_content' => $parsed_preview_content,
                        'is_parsed' => 1
                    );
                } else {
                    $update_array = array(
                        'content' => $parsed_content,
                        'is_parsed' => 1
                    );
                }

                DB::table($tablename)
                    ->where('id', $item->id)
                    ->update($update_array);
//                 dd($bbcode_content,urldecode(html_entity_decode($parsed_content)));
            } catch (\Exception $e) {
                Log::error($tablename . " => " . $item->id);
//                dd($e->getMessage());
            }
            $progressBar->advance();
        }
    }
}

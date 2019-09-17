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
    protected $signature = 'convertHtmlToBbcode';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //Get All forum topics data
        $topics = DB::table('forum_topics')
            ->where('is_parsed', 0)
//            ->where('id', 42478)
            ->get();
        $progressBar = $this->output->createProgressBar($topics->count());
        $progressBar->start();
        $n = 0;
        foreach ($topics as $forum) {
            $n++;
            $content = $this->general_helper->lowerTagconvert($forum->content);
            $preview_content = $this->general_helper->lowerTagconvert(($forum->preview_content));

            try {
                $bbcode_content = $this->htmltobbcode_helper->html_bbcode_format($content);
                $parsed_content = urldecode(html_entity_decode($bbcode_content));

                $bbcode_preview_content = $this->htmltobbcode_helper->html_bbcode_format(($preview_content));
                $parsed_preview_content = urldecode(html_entity_decode($bbcode_preview_content));

                DB::table('forum_topics')
                    ->where('id', $forum->id)
                    ->update(['content' => $parsed_content, 'preview_content'=>$parsed_preview_content, 'is_parsed' => 1]);
                // dd(urldecode(html_entity_decode($bbcode)));
            } catch (\Exception $e) {
                Log::error($forum->id);
            }
            $progressBar->advance();
        }
    }
}

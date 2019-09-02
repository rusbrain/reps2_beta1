<?php


namespace App\Console\Commands;


use App\File;
use Illuminate\Console\Command;

class CleanOldReplayFilesCommand extends Command
{
    protected $signature = 'replays:clean_files';

    protected $description = 'Command description';

    public function handle()
    {
        File::query()->leftJoin('replays', 'files.id', '=', 'replays.file_id')
            ->whereIn('files.resource_type', ['replay', 'replay_archive'])
            ->whereNull('replays.id')->delete();
    }
}

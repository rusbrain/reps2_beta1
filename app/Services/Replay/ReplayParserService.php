<?php


namespace App\Services\Replay;


use App\Exceptions\ReplayParserException;
use App\Replay;
use App\ReplayMap;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class ReplayParserService
{
    protected $commandPath = 'bin/m.rep';

    public function parseFile(UploadedFile $file)
    {
        $command = base_path($this->commandPath) . ' ' . $file->path();

        $cliOutput = null;
        $cliResult = null;

        exec($command, $cliOutput, $cliResult);
        if ($cliResult !== 0) {
            throw new ReplayParserException($cliOutput ?: '', $cliResult);
        }

        $data = json_decode(implode('', $cliOutput));
        if (is_null($data)) {
            throw new \InvalidArgumentException('Unable parse output json');
        }

        $replayMap = $this->detectMap($data);

        return [
            'map_id' => $replayMap ? $replayMap->id : null,
            'first_name' => $this->detectFirstName($data),
            'second_name' => $this->detectSecondName($data),
            'first_race' => $this->detectFirstRace($data),
            'first_location' => $this->detectFirstLocation($data),
            'second_race' => $this->detectSecondRace($data),
            'second_location' => $this->detectSecondLocation($data),
            'first_APM' => $this->detectFirstAPM($data),
            'second_APM' => $this->detectSecondAPM($data),
            'replay_time' => $this->detectReplayTime($data),
        ];
    }

    /** @return ReplayMap|null */
    protected function detectMap($data)
    {
        return ReplayMap::findByTitle($data->Header->Map);
    }

    protected function detectFirstRace($data)
    {
        return array_search($data->Header->Players[0]->Race->Name, Replay::$races_full);
    }

    protected function detectSecondRace($data)
    {
        return array_search($data->Header->Players[1]->Race->Name, Replay::$races_full);
    }

    protected function detectFirstLocation($data)
    {
        return $data->Header->Players[0]->SlotID;
    }

    protected function detectSecondLocation($data)
    {
        return $data->Header->Players[1]->SlotID;
    }

    protected function detectFirstName($data)
    {
        return $data->Header->Players[0]->Name;
    }

    protected function detectSecondName($data)
    {
        return $data->Header->Players[1]->Name;
    }

    protected function detectFirstAPM($data)
    {
        return $data->Computed->PlayerDescs[0]->APM;
    }

    protected function detectSecondAPM($data)
    {
        return $data->Computed->PlayerDescs[1]->APM;
    }

    protected function detectReplayTime($data)
    {
        return (new Carbon($data->Header->StartTime))->format('Y-m-d');
    }
}

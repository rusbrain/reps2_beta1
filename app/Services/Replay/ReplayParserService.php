<?php


namespace App\Services\Replay;


use App\Exceptions\ReplayParserException;
use App\Replay;
use App\ReplayMap;
use Illuminate\Http\UploadedFile;

class ReplayParserService
{
    protected $commandPath = 'bin/screp';

    public function parseFile(UploadedFile $file)
    {
        $command = base_path($this->commandPath) . ' ' . $file->path();

        $cliOutput = null;
        $cliResult = null;

        exec($command, $cliOutput, $cliResult);
        if ($cliResult !== 0) {
            throw new ReplayParserException($cliOutput);
        }

        $data = json_decode(implode('', $cliOutput));
        if (is_null($data)) {
            throw new \InvalidArgumentException('Unable parse output json');
        }

        $replayMap = $this->detectMap($data);

        return [
            'map_id' => $replayMap ? $replayMap->id : null,
            'first_race' => $this->detectFirstRace($data),
            'first_location' => $this->detectFirstLocation($data),
            'second_race' => $this->detectSecondRace($data),
            'second_location' => $this->detectSecondLocation($data),
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
}

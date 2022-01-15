<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Interfaces\CsvDataInterface;
use Illuminate\Support\Facades\File;

class CsvDataService implements CsvDataInterface
{
    public function convertData(string $filePath): array
    {   
        $csv = File::get($filePath);
        $data = array_map("str_getcsv", explode("\n", $csv));
        $csvLength = count($data);
        $value = 0;

        for($i = 2; $i < $csvLength - 1; $i++){
            if(isset($data[$i][4])){
                $value += (float) $data[$i][4];
            }
        }

        $value = round($value/$csvLength,1);

        return [
            'scale' => $data[1][0],
            'city' => $data[1][1],
            'date' => $data[1][2],
            'time' => date('H:i'),
            'value' => (string) $value
        ];
    }
}
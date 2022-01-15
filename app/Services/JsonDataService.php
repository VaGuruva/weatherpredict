<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Interfaces\JsonDataInterface;
use Illuminate\Support\Facades\File;

class JsonDataService implements JsonDataInterface
{
    public function convertData(string $filePath): array
    {
        $json = File::get($filePath);
        $data = json_decode($json, TRUE);
        $value = 0;

        foreach($data['predictions']['prediction'] as $prediction){
            $value += (float) $prediction['value'];
        }

        $value = round($value/count($data['predictions']['prediction']),1);

        return [
            'scale' => $data['predictions']['scale'],
            'city' => $data['predictions']['city'],
            'date' => $data['predictions']['date'],
            'time' => date('H:i'),
            'value' => (string) $value
        ];
        
        return $data;
    }
}
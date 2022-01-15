<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Interfaces\XmlDataInterface;
use Illuminate\Support\Facades\File;

class XMLDataService implements XmlDataInterface
{
    public function convertData(string $filePath): array
    {
        $contents = File::get($filePath);
        $xml = simplexml_load_string($contents, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $data = json_decode($json,TRUE);
        $value = 0;

        foreach($data['prediction'] as $prediction){
            $value += (float) $prediction['value'];
        }

        $value = round($value/count($data['prediction']),1);

        return [
            'scale' => $data['@attributes']['scale'],
            'city' => $data['city'],
            'date' => $data['date'],
            'time' => date('H:i'),
            'value' => (string) $value
        ];
    }
}
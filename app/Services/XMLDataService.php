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
        $xml = simplexml_load_string($contents);
        $json = json_encode($xml);
        $data = json_decode($json, TRUE);
        return $data;
    }
}
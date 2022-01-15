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
        return $data;
    }
}
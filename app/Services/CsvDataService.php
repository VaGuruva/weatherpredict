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
        return $data;
    }
}
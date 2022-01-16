<?php

namespace App\Services;

use App\Interfaces\DateCheckServiceInterface;

class DateCheckService implements DateCheckServiceInterface
{
    public function dateCheck(string $date): bool
    {
        $nowTimestamp = time();
        $dateTimestamp = strtotime($date);
        $datediff = $dateTimestamp - $nowTimestamp;
        return round($datediff / (60 * 60 * 24)) > 10? true : false;
    }
}
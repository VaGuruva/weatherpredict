<?php

namespace App\Interfaces;

interface DateCheckServiceInterface 
{
    public function dateCheck(string $date): bool;
}
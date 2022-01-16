<?php

namespace App\Interfaces;
use Illuminate\Database\Eloquent\Model;

interface DataProcessingServiceInterface 
{
    public function storePartnerPrediction(string $partnerName): ?Model;
}
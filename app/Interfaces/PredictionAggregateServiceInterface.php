<?php

namespace App\Interfaces;

interface PredictionAggregateServiceInterface 
{
    public function aggregate(string $scale, string $weatherElement, string $city): string;
    public function convertValueToScale(string $weatherElement, string $requiredScale, string $scaleToConvert, float $value): float;
}
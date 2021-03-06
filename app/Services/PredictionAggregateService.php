<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Interfaces\PredictionAggregateServiceInterface;
use App\Repository\PredictionRepositoryInterface;
use App\Repository\WeatherElementRepositoryInterface;
use \Exception;

class PredictionAggregateService implements PredictionAggregateServiceInterface
{
    private $weatherElementRepository;
    private $predictionRepository;

    public function __construct(WeatherElementRepositoryInterface $weatherElementRepository, PredictionRepositoryInterface $predictionRepository)
    {
        $this->predictionRepository = $predictionRepository;
        $this->weatherElementRepository = $weatherElementRepository;
    }

    public function aggregate(string $scale, string $weatherElement, string $city, string $date): string
    {   
        $availableScales = [];
        $otherScales = [];
        $value = 0;

        //Ensure input is lowercase
        $scale = strtolower($scale);
        $weatherElement = strtolower($weatherElement);

        $allpredictions = $this->predictionRepository->findBy3Columns(
            ['scale' => $scale],
            ['city' => $city],
            ['date' => $date]
        );

        $storedWeatherElements = $this->weatherElementRepository->findBy(
            ['type' => $weatherElement]
        );
        
        //Get all defined scales for weather element type
        foreach($storedWeatherElements as $storedWeatherElement){
            $storedElementScale = strtolower($storedWeatherElement->scale);
            $availableScales[$storedElementScale] = $storedElementScale;
        }

        //Remove required scale from available scales
        unset($availableScales[$scale]);
        
        //Calculate total value for all predictions
        foreach($allpredictions as $prediction){
            $predictionScale = strtolower($prediction->scale);
        
            //Get total value for require element
            if($predictionScale === $scale){
                $value += (float) $prediction->value;
            }

            //Convert other scales to required scale
            if($predictionScale !== $scale && $predictionScale === $availableScales[$predictionScale]){
                $value += $this->convertValueToScale($weatherElement, $scale, $predictionScale, (float)$prediction->value);
            }
        }

        return (string) $value/count($allpredictions);
    }

    public function convertValueToScale(string $weatherElement, string $requiredScale, string $scaleToConvert, float $value): float
    {

        $conversionMap = [
            'temperature' => 
            [
                'celcius' => 
                [
                    'fahrenheit' => ($value * 9/5) + 32,
                    'kelvin' => $value + 273.15
                ],
                'fahrenheit' => 
                [
                    'celcius' => ($value - 32) * 5/9,
                    'kelvin' => ($value - 32) * 5/9 + 273.15
                ],
                'kelvin' => 
                [
                    'celcius' => $value - 273.15,
                    'fahrenheit' => ($value - 273.15) * 9/5 + 32
                ]
            ]
        ];

        //Index definition gate keepers
        if(!$conversionMap[$weatherElement]){
         throw new Exception('Weather element does not exist.');   
        }

        if(!$conversionMap[$weatherElement][$scaleToConvert]){
            throw new Exception('Scale to convert does not exist.');   
        }

        if(!$conversionMap[$weatherElement][$scaleToConvert][$requiredScale]){
            throw new Exception('Require scale does not exist.');   
        }

        return $conversionMap[$weatherElement][$scaleToConvert][$requiredScale];
    }

}
<?php

namespace App\Services;
use App\Repository\PredictionRepositoryInterface;
use App\Repository\PartnersRepositoryInterface;
use App\Interfaces\CsvDataInterface;
use App\Interfaces\JsonDataInterface;
use App\Interfaces\XmlDataInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;
use App\Interfaces\DataProcessingServiceInterface;
use Illuminate\Database\Eloquent\Model;

class DataProcessingService implements DataProcessingServiceInterface
{
    private $predictionRepository;
    private $partnersRepository;
    private $csvDataService;
    private $jsonDataService;
    private $xmlDataService;
    private $processingStrategy;
    private $publicPath;

    public function __construct(PredictionRepositoryInterface $predictionRepository, PartnersRepositoryInterface $partnersRepository, CsvDataInterface $csvDataService, JsonDataInterface $jsonDataService, XmlDataInterface $xmlDataService)
    {
        $this->predictionRepository = $predictionRepository;
        $this->partnersRepository = $partnersRepository;
        $this->csvDataService = $csvDataService;
        $this->jsonDataService = $jsonDataService;
        $this->xmlDataService = $xmlDataService;
        $this->processingStrategy = [
            "xml" => $this->xmlDataService,
            "json" => $this->jsonDataService,
            "csv" => $this->csvDataService,
        ];
        $this->publicPath = public_path("data-sources");
    }

    /**
     * Store prediction from partner data source.
     *
     * @return void
     */
    public function storePartnerPrediction(string $partnerName): ?Model
    {
        $partner = $this->partnersRepository->findByColumn('name', $partnerName);
        $result = [];

        if(isset($partner->name)){
            $files = File::allFiles("$this->publicPath/$partner->name");
            
            foreach($files as $key => $filePath){
                $result = $this->processingStrategy[strtolower($filePath->getExtension())]->convertData($filePath);
            }

            $existingPredictionList = $partner->predictions()->get();

            if(count($existingPredictionList) > 0){
                $existingPrediction = $existingPredictionList[0];
                $this->predictionRepository->update($existingPrediction->id, $result);
                $prediction = $existingPrediction->fresh();
            } else {
                $prediction = $this->predictionRepository->create($result);
                $prediction->partners()->attach($partner);
                
            }

            return $prediction;
        }

    }

    /**
     * Refresh prediction for each partner.
     *
     * @return void
     */
    public function refreshPartnerPredictions(): void
    {
        $files = File::allFiles($this->publicPath);
        foreach($files as $file){
            $this->storePartnerPrediction($file->getRelativePath());
        }
    }

}
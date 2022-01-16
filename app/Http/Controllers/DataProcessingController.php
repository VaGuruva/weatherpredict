<?php

namespace App\Http\Controllers;
use App\Repository\PredictionRepositoryInterface;
use App\Repository\PartnersRepositoryInterface;
use App\Interfaces\CsvDataInterface;
use App\Interfaces\JsonDataInterface;
use App\Interfaces\XmlDataInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\PredictionsResource;
use Illuminate\Support\Facades\File;
use \Exception;

class DataProcessingController extends Controller
{
   private $predictionRepository;
   private $partnersRepository;
   private $csvDataService;
   private $jsonDataService;
   private $xmlDataService;
   private $processingStrategy;
  
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
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \App\Http\Resources\PredictionsResource
     */
    public function storePartnerPredictions(Request $request)
    {
        try {
            $partner = $this->partnersRepository->findByColumn('name', $request->route('partner'));
            $publicPath = public_path("data-sources");
            $result = [];
    
            if(isset($partner->name)){
                $files = File::allFiles("$publicPath/$partner->name");
                foreach($files as $key => $filePath){
                    $result = $this->processingStrategy[strtolower($filePath->getExtension())]->convertData($filePath);
                }
                $prediction = $this->predictionRepository->create($result);
                $prediction->partners()->attach($partner);

                return PredictionsResource::collection([$prediction]);
            }else{
                return response()->json(['message' => 'No partner by that name exists.'], 404);
            }

        } catch (Exception $e) {
            report($e);
            return response()->json(['message' => 'Failed to store partner prediction Internal Server Error.'.$e], 500);
        }

    }
}
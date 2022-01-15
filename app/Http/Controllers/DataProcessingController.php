<?php

namespace App\Http\Controllers;
use App\Repository\PredictionRepositoryInterface;
use App\Repository\PartnersRepositoryInterface;
use App\Http\Resources\UsersResource;
use App\Interfaces\CsvDataInterface;
use App\Interfaces\JsonDataInterface;
use App\Interfaces\XmlDataInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

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
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storePartnerPredictions(Request $request)
    {
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
        }

    }
}
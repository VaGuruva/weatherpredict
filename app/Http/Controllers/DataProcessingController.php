<?php

namespace App\Http\Controllers;
use App\Repository\DataProcessingInterface;
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
   private $dataProcessingRepository;
   private $partnersRepository;
   private $csvDataService;
   private $jsonDataService;
   private $xmlDataService;
   private $processingStrategy;
  
   public function __construct(DataProcessingInterface $dataProcessingRepository, PartnersRepositoryInterface $partnersRepository, CsvDataInterface $csvDataService, JsonDataInterface $jsonDataService, XmlDataInterface $xmlDataService)
   {
       $this->dataProcessingRepository = $dataProcessingRepository;
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
        $path = public_path("data-sources");

        if(isset($partner->name)){
            $files = File::allFiles("$path/$partner->name");
            foreach($files as $key => $path){
                $result = $this->processingStrategy[strtolower($path->getExtension())]->convertData($path);
            }
            dd($result);
            // save data $this->dataProcessingRepository->create($xmlResult);
        }

    }
}
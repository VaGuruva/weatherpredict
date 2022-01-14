<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartnerRequest;
use App\Models\Partner;
use App\Http\Resources\PartnersResource;
use App\Repository\PartnersRepositoryInterface;
use \Illuminate\Http\Request;
use Throwable;

class PartnersController extends Controller
{
    private $partnersRepository;
  
    public function __construct(PartnersRepositoryInterface $partnersRepository)
    {
        $this->partnersRepository = $partnersRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $partners = $this->partnersRepository->all();
            return PartnersResource::collection($partners);
        } catch (Throwable $e) {
            report($e);
            return response()->json(['message' => 'Failed to get resource Internal Server Error.'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePartnerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePartnerRequest $request)
    {
        try {
            $partner =  $this->partnersRepository->create($request->all());
            return PartnersResource::collection([$partner]);
        } catch (Throwable $e) {
            report($e);
            return response()->json(['message' => 'Failed to create resource Internal Server Error.'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        try {
            $partner = $this->partnersRepository->findById($partner->id);
            return PartnersResource::collection([$partner]);
        } catch (Throwable $e) {
            report($e);
            return response()->json(['message' => 'Failed to get resource Internal Server Error.'], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Partner $partner)
    {
        try {
            $updateResult = $this->partnersRepository->update($partner->id, $request->all());
            if($updateResult){
                return PartnersResource::collection([$partner->fresh()]);
            }
        } catch (Throwable $e) {
            report($e);
            return response()->json(['message' => 'Update failed Internal Server Error.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partner $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        try{
            $deleteResult = $this->partnersRepository->deleteById($partner->id);
            return response($deleteResult, 204);

        } catch (Throwable $e){
            report($e);
            return response()->json(['message' => 'Delete failed Internal Server Error.'], 500);
        }
    }
}

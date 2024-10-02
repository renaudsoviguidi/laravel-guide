<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\StoreEtablissementRequest;
use App\Http\Requests\UpdateEtablissementRequest;
use App\Http\Resources\EtablissementResource;
use App\Interfaces\EtablissementRepositoryInterface;
use App\Models\Etablissement;
use Illuminate\Support\Facades\DB;

class EtablissementController extends Controller
{
    private EtablissementRepositoryInterface $etablissementRepositoryInterface;

    public function __construct(EtablissementRepositoryInterface $etablissementRepositoryInterface)
    {
        $this->etablissementRepositoryInterface = $etablissementRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = $this->etablissementRepositoryInterface->index();
        return ApiResponseClass::sendResponse(EtablissementResource::collection($data),'',200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEtablissementRequest $request)
    {
        //
        $details =[
            'nom_etablissement' => $request->nom_etablissement,
            'nom_dirigeant' => $request->nom_dirigeant,
            'email_etablissement' => $request->email_etablissement,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse, 
        ];
        DB::beginTransaction();
        try{
             $product = $this->etablissementRepositoryInterface->store($details);

             DB::commit();
             return ApiResponseClass::sendResponse(new EtablissementResource($product),'Établissement créé avec succès',201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $etablissement = $this->etablissementRepositoryInterface->getById($id);

        return ApiResponseClass::sendResponse(new EtablissementResource($etablissement),'',200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $etablissement = $this->etablissementRepositoryInterface->getById($id);

        return ApiResponseClass::sendResponse(new EtablissementResource($etablissement),'',200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEtablissementRequest $request, $id)
    {
        //
        $updateDetails =[
            'nom_etablissement' => $request->nom_etablissement,
            'nom_dirigeant,' => $request->nom_dirigeant,
            'email_etablissement' => $request->email_etablissement,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse, 
        ];
        DB::beginTransaction();
        try{
             $etablissement = $this->etablissementRepositoryInterface->update($updateDetails,$id);

             DB::commit();
             return ApiResponseClass::sendResponse('Établissement modifié avec succès','',201);

        }catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $this->etablissementRepositoryInterface->delete($id);

        return ApiResponseClass::sendResponse('Établissement supprimé avec succès','',204);
    }
}

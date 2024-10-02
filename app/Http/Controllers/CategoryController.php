<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepositoryInterface;

    public function __construct(CategoryRepositoryInterface $categoryRepositoryInterface)
    {
        $this->categoryRepositoryInterface = $categoryRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = $this->categoryRepositoryInterface->index();
        return ApiResponseClass::sendResponse(CategoryResource::collection($data),'',200);
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
    public function store(StoreCategoryRequest $request)
    {
        //
        $details =[
            'libelle' => $request->libelle,
            'description' => $request->description
        ];
        DB::beginTransaction();
        try{
             $product = $this->categoryRepositoryInterface->store($details);

             DB::commit();
             return ApiResponseClass::sendResponse(new CategoryResource($product),'Catégorie créée avec succès',201);

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
        $category = $this->categoryRepositoryInterface->getById($id);

        return ApiResponseClass::sendResponse(new CategoryResource($category),'',200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $category = $this->categoryRepositoryInterface->getById($id);

        return ApiResponseClass::sendResponse(new CategoryResource($category),'',200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        //
        $updateDetails =[
            'libelle' => $request->libelle,
            'description' => $request->description
        ];
        DB::beginTransaction();
        try{
             $category = $this->categoryRepositoryInterface->update($updateDetails,$id);

             DB::commit();
             return ApiResponseClass::sendResponse('Catégorie modifiée avec succès','',201);

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
        $this->categoryRepositoryInterface->delete($id);

        return ApiResponseClass::sendResponse('Catégorie supprimée avec succès','',204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    private ProductRepositoryInterface $productRepositoryInterface;

    public function __construct(productRepositoryInterface $productRepositoryInterface)
    {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = $this->productRepositoryInterface->index();
        return ApiResponseClass::sendResponse(ProductResource::collection($data), '', 200);
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
    /**
     * @requestMediaType multipart/form-data
     */
    public function store(StoreProductRequest $request)
    {
        //

        $details = [
            'nom' => $request->nom,
            'details' => $request->details,
            'prix' => $request->prix,
            'category_id' => $request->category_id,
        ];
        if ($request->hasFile('image')) {
            $details['image'] = $this->uploadImage($request->image);
        }
        DB::beginTransaction();
        try {
            $product = $this->productRepositoryInterface->store($details);

            DB::commit();
            return ApiResponseClass::sendResponse(new ProductResource($product), 'Produit créé avec succès', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $product = $this->productRepositoryInterface->getById($id);

        return ApiResponseClass::sendResponse(new ProductResource($product), '', 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $product = $this->productRepositoryInterface->getById($id);

        return ApiResponseClass::sendResponse(new ProductResource($product), '', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        //
        $updateDetails = [
            'nom' => $request->nom,
            'details' => $request->details,
            'prix' => $request->prix,
            'category_id' => $request->category_id,
            'image' => $request->image
        ];
        DB::beginTransaction();
        try {
            $product = $this->productRepositoryInterface->update($updateDetails, $id);

            DB::commit();
            return ApiResponseClass::sendResponse('Produit modifié avec succès', '', 201);
        } catch (\Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $this->productRepositoryInterface->delete($id);

        return ApiResponseClass::sendResponse('Produit supprimé avec succès', '', 204);
    }

    /**
     * Upload an image to the public/products directory and return the filename.
     *
     * @param  \Illuminate\Http\UploadedFile  $image
     * @return string|null
     */
    protected function uploadImage($image)
    {
        if ($image) {
            $allowedfileExtension = ['jpeg', 'jpg', 'webp', 'png', 'JPEG', 'JPG', 'PNG', 'WEBP'];
            $extension_image = $image->getClientOriginalExtension();
            $check = in_array($extension_image, $allowedfileExtension);

            //Vérifier la taille du fichier
            $maxSize = 1024 * 1024 * 3; // 3Mo
            if ($image->getSize() > $maxSize) {
                return back()->with('error', 'La taille du document ne doit pas dépasser 3 Mégaoctets');
            }

            if ($check) {
                $name_image =  "product_image_"  . date('Ymd-His') . '.' . $extension_image;
                $image->storeAs('product', $name_image, 'public');
            } else {
                return redirect()->back()->with('error', 'Echec de l\'enregistrement. Format du document interdit');
            }
            return $name_image;
        }

        return null;
    }
}

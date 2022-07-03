<?php

namespace App\Http\Controllers\V1;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\V1\ProductResource;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**TODO = Error handling */

    public function index()
    {
        /** Mengambil semua data product dan dikembalikan ke ProductResource
         * cek di App\Http\Resources\V1\ProductResource;
         */
        $product = Product::all();
        return ProductResource::collection($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        /** Mengambil semua request product, validasi dilakukan di StoreProductRequest. 
         * termasuk category_id(required), cek validasi
        */
        try {
            DB::beginTransaction();
            $cekKategori = Category::find($request->category_id);
            if($cekKategori!= null){
                $product = Product::Create($request->all());
                /** Attach id product ke pivot table category_product */
                $product->category()->attach($request->category_id);
                DB::commit();
                return new ProductResource($product);
            }else{
                /** return gagal jika category tidak ada */
                return response('Gagal. Category Id tidak ditemukan',400);
            }
            
        } catch (\Exception $ex) {
            DB::rollback();
            return response('Gagal. Pesan Error: '.$ex->getMessage(),400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());
        return new ProductResource($product) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        /** delete product, respond string kosong dan response code 204
         * TODO = Response message
         */
        $product->delete();
        return response('',204);
    }
}

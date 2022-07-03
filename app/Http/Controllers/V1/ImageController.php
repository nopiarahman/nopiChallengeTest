<?php

namespace App\Http\Controllers\V1;

use App\Models\Image;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use App\Http\Resources\V1\ImageResource;
use App\Http\Requests\UpdateImageRequest;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** Mengambil semua data product dan dikembalikan ke ImageResource
         * cek di App\Http\Resources\V1\ImageResource;
         */
        $image = Image::all();
        return ImageResource::collection($image);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreImageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImageRequest $request)
    {
        /** Mengambil semua request product, validasi dilakukan di StoreProductRequest. 
         * termasuk category_id(required), cek validasi
        */
        // try {
        //     DB::beginTransaction();
        //     $cekKategori = Product::find($request->product_id);
        //     if($cekKategori!= null){
        //         $image = Image::Create($request->all());
        //         /** Attach id product ke pivot table category_product */
        //         $image->product()->attach($request->product_id);
        //         DB::commit();
        //         return new ImageResource($image);
        //     }else{
        //         /** return gagal jika category tidak ada */
        //         return response('Gagal. Product Id tidak ditemukan',400);
        //     }
            
        // } catch (\Exception $ex) {
        //     DB::rollback();
        //     return response('Gagal. Pesan Error: '.$ex->getMessage(),400);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        return new ImageResource($image);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateImageRequest  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateImageRequest $request, Image $image)
    {
        $image->update($request->all());
        return new ImageResource($image) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        $image->product()->detach();
        $image->delete();
        return response('Product dihapus');
    }
}

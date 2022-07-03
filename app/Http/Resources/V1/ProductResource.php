<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function cekImages()
    {
        $file=[];
        foreach($this->image as $image){
            $file[]=$image->file;
        }
        return $file;
    }
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'description'=>$this->description,
            'images'=>$this->cekImages()
        ];
    }
}

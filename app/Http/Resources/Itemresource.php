<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Brandresource;
use App\Http\Resources\SubcategoryResource;

class Itemresource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public static $wrap = 'item';
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'codeno' => $this->codeno,
            'name' => $this->name,
            'photo' => url($this->photo),
            'price'=>$this->price,
            'discount'=>$this->discount,
            'detail'=>$this->description,
            'brand'=>new Brandresource($this->brand),
            'subcategory'=>new SubcategoryResource($this->subcategory),
            'created_at' => $this->created_at->format("Y-m-d H:i:s"),
            'updated_at' => $this->updated_at->format("Y-m-d H:i:s"),
        ];
    }
}

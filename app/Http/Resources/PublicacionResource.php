<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ImageResource;

class PublicacionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
       return [
        'id'=>$this->id,
         'body'=>$this->body,
         'imagenes'=>ImageResource::collection($this->imagen),
         'user'=>new UserResource($this->user),
         'created_at'=>$this->created_at,
         'updated_at'=>$this->updated_at
       ];
    }
}

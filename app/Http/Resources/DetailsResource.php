<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'product_id' => $this->product_id,
            'product' => $this->product,
            'qty' => $this->qty,
            'price' => 'Rp. '. number_format($this->price,0,'.','.'),
            'total' => 'Rp. '. number_format($this->price,0,'.','.'),
        ];
    }
}

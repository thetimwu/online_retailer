<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Book extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'isbn' => $this->isbn,
            'title' => $this->title,
            'author' => $this->author,
            'category' => $this->category,
            'price' => $this->price
        ];
    }

    public function with($request) {
        return [
            'Created by' => 'Tim Wu'
        ];
    }
}

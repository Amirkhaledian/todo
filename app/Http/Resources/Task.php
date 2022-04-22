<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Task extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
<<<<<<< HEAD
=======
            //'labels' => $this->labels->toArray(),
>>>>>>> d08678e8a96dd825cdfaf17379d6d30508649bb0
            'labels' => Label::collection($this->labels),
        ];
    }
}

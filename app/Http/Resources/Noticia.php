<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Noticia extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        // return [
        //     'id' => $this->id,
        //     'titulo' => $this->titulo,
        //     'contenido' => $this->contenido,
        //     // 'created_at' => $this[0]->created_at,
        //     // 'updated_at' => $this[0]->updated_at,
        // ];
    }
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Noticia;
use App\Http\Resources\Noticia as NoticiaResource;
class NoticiaController extends Controller
{
    public function show ($id=NULL)
    {   

        if ($id!=NULL) {
            $datos = Noticia::find($id);
            return new NoticiaResource(Noticia::find($id));
        } else {
            return NoticiaResource::collection(Noticia::all());
        }
    }
}

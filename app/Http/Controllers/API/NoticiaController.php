<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Noticia;
use Validator;


class NoticiaController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noticias = Noticia::all();


        return $this->sendResponse($noticias->toArray(), 'Noticias Consultadas.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'titulo' => 'required',
            'contenido' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $noticia = Noticia::create($input);


        return $this->sendResponse($noticia->toArray(), 'Noticia Creada.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $noticia = Noticia::find($id);


        if (is_null($noticia)) {
            return $this->sendError('Noticia no encontrada.');
        }


        return $this->sendResponse($noticia->toArray(), 'Noticia recuperada.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Noticia $noticia)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'titulo' => 'required',
            'contenido' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $noticia->name = $input['titulo'];
        $noticia->detail = $input['contenido'];
        $noticia->save();


        return $this->sendResponse($noticia->toArray(), 'Noticia actualizada.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Noticia $noticia)
    {
        $noticia->delete();


        return $this->sendResponse($noticia->toArray(), 'Noticia borrada.');
    }
}

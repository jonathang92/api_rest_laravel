<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
// use App\Http\Controllers\API\BaseController as BaseController;
use FoursquareApi;

class FourSquareController extends BaseController
{
    public function consulta()
    {   
        $client_key = config('services.foursquare.clientKey');
        $client_secret = config('services.foursquare.clientSecret');
        $foursquare = new FoursquareApi($client_key,$client_secret,'','v2','es');
        $endpoint = "venues/explore";
	
        // $params = array("query"=>"kentuky", "m"=>"swarm", "limit"=>"20", 'radius'=>"2000","locale"=>"es","ll" => "lat,long");
        // $params = array("query"=>"havanna", "m"=>"swarm", "limit"=>"50", 'radius'=>"20000","ll" => "-34.52645509489846,-58.334962144737176");
        $params = array("ll" => "-34.5927171,-58.3813378", 'radius'=>"20000", "query"=>"comida tailandesa");
        // $params = array("near"=>"Thames 1144");
        // $response = $foursquare->GetPublic($endpoint,$params);
        $venues = $foursquare->GetPublic($endpoint ,$params);
        $resultados = json_decode($venues);
        $cantidad = $resultados->response->totalResults;
        $query = $resultados->response->query;
        $searchLocation = $resultados->response->headerFullLocation;
        // $radio = $resultados->response->suggestedRadius;
        $advertencia = "";
        if (isset($resultados->response->warning->text)) {
            $advertencia = $resultados->response->warning->text;
        }
        if ($cantidad=="0") {
            $advertencia = "No hay resultados para \"".$query."\". Prueba algo más general, restablece tus filtros o amplía el área de búsqueda.";
        }
        $places = $resultados->response->groups[0]->items;
        $lugares = array();
        if ($cantidad>0) {
            foreach ($places as $key => $place) {
                $lugares[$key]['nombre'] = $place->venue->name;
                $lugares[$key]['id'] = $place->venue->id;
                $lugares[$key]['fsurl'] = "https://foursquare.com/v/".$place->venue->id;
                $lugares[$key]['locacion']['direccion'] = $place->venue->location->address;
                $lugares[$key]['locacion']['lat'] = $place->venue->location->lat;
                $lugares[$key]['locacion']['lng'] = $place->venue->location->lng;
                $lugares[$key]['locacion']['lng'] = $place->venue->location->lng;
                $lugares[$key]['locacion']['ciudad'] = $place->venue->location->city;
                $lugares[$key]['locacion']['provincia'] = $place->venue->location->state;
                $lugares[$key]['locacion']['pais'] = $place->venue->location->country;
                foreach ($place->venue->categories as $key2 => $categoria) {
                    $lugares[$key]['categorias'][$key2]['id'] = $categoria->id;
                    $lugares[$key]['categorias'][$key2]['nombre'] = $categoria->name;
                    $lugares[$key]['categorias'][$key2]['icono'] = $categoria->icon->prefix."88.png";
                }
                if (isset($place->venue->url)) {
                    $lugares[$key]['url'] = $place->venue->url;
                } else {
                    $lugares[$key]['url'] = "";
                }
                if (isset($place->venue->hours)) {
                    if (isset($place->venue->hours->status)) {
                        $lugares[$key]['horas']['estatus'] = $place->venue->hours->status;
                    } else {
                        $lugares[$key]['horas']['estatus'] = "";
                    }
                    $lugares[$key]['horas']['abierto'] = $place->venue->hours->isOpen;
                    $lugares[$key]['horas']['feriado'] = $place->venue->hours->isLocalHoliday;
                } else {
                    $lugares[$key]['horas']=array();
                }
            }
        }
        $json=array();
        $json['total'] = $cantidad;
        $json['busqueda'] = $query;
        $json['localizacion'] = $searchLocation;
        // $json['radio'] = $radio;
        $json['advertencia'] = $advertencia;
        $json['lugares'] = $lugares;
        $json['error'] = ($cantidad>0) ? false : true;
        return response()->json($json);
    }
}

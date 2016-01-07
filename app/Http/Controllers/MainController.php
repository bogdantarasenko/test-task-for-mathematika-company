<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

use DB;

class MainController extends Controller
{
    //
    public function index(){

        $data = DB::select("select * from main ");

    	return view('index',['data'=>$data]);
    }

    public function add($id = null){

    	$lang = 0;
        
        $headerOptions = [
            'http' => [
                'method' => "GET",
                'header' => "Accept-language:en\r\n".
                "Cookie:remixlang=$lang\r\n"
            ]
            
        ];

        $methodUrl = 'http://api.vk.com/method/database.getCountries?v=5.5&need_all=1&count=1000';

        $streamContext = stream_context_create($headerOptions);

        $json = file_get_contents($methodUrl,false,$streamContext);

        $array = json_decode($json,true);

        $cities = $array['response']['items'];


    	return view('add',['cities' => $cities,'id' => $id]);

    }

    public function getcitieslist(Request $request){
    	
        $lang = 0;
        $headerOptions = [
            'http' => [
                'method' => "GET",
                'header' => "Accept-language:en\r\n".
                "Cookie:remixlang=$lang\r\n"
            ]
            
        ];

        $country_id = $request->id_country;

        $methodUrl = "http://api.vk.com/method/database.getCities?v=5.5&country_id=$country_id&count=100";

        $streamContext = stream_context_create($headerOptions);
        $json = file_get_contents($methodUrl,false,$streamContext);
        $array = json_decode($json,true);

        $json_cities = json_encode($array['response']['items']);


        return $json_cities;

    	
    }

    public function addtodb(Request $request){

        $data = json_decode($request->jsondata,true);
        
        $lang = $data['language'];
        $city = $data['city'];
        $country =  $data['country'];

        $insert = DB::insert("insert into main (country,language,city) values('$country','$lang','$city')");
        
        if($insert == 1){
            return "Добавлено успешно";
        }else{
            return "Ошибка при добавлении";
        }
    }

    public function delete($id){

        $delete = DB::delete("delete from `main` where id = '$id'");

        if($delete){
            return redirect('/');
        }
    }

    public function update(Request $request){

        $data = json_decode($request->jsondata,true);
        
        $id = $data['userid'];
        $lang = $data['language'];
        $city = $data['city'];
        $country =  $data['country'];

        $update = DB::update("update main set country = '$country',language = '$lang',city = '$city' where id = $id");
        
        if($update == 1){
            return "Обновлено успешно";
        }else{
            return "Ошибка при Обновленииы";
        }
    }

}

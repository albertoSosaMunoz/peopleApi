<?php

namespace App\Http\Controllers;

use App\Models\googleAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\HelperAPI\GoogleController;
 

class GoogleApiController extends Controller
{
    /**
     * forma la direccion donde se tiene que acceder para obtener el app_code
     */
    public static function run(){

        $client_id      = "155879370556-6ot179b6cijrloupg62tl5o90hf107f8.apps.googleusercontent.com";
        $client_secret  = "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";
        $token_uri      = "http://localhost/google-api/auth";
        $response_type  = "code";//"token id_token";
        $redirect_uri   = "urn:ietf:wg:oauth:2.0:oob";//"http://127.0.0.1:8000/auth";
        $login_hint     = 'albertososamunoz@gmail.com';

        dd( GoogleController::get());
        //dd( GoogleController::post());
         //obtenemos el codigo para pedir los tokens
        //GoogleController::obtain_google_api_code($client_id,'code','albertososamunoz@gmail.com');
        //$response = GoogleController::obtain_google_api_token($client_id, $client_secret);
        dd(GoogleController::refresh_google_api_token($client_id,$client_secret));
        
    }

}

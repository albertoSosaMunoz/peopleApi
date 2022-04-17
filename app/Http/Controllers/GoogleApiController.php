<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleApiController extends Controller
{
    /**
     * forma la direccion donde se tiene que acceder para obtener el app_code
     */
    public static function run(){

        $client_id      = "155879370556-6ot179b6cijrloupg62tl5o90hf107f8.apps.googleusercontent.com";
        $client_secret  = "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";
        $token_uri      = "http://localhost/google-api/auth";
        $auth_uri       = "https://accounts.google.com/o/oauth2/auth";
        $grant_type     = "authorization_code";//"client_credentials";
        $scope          = "https://www.googleapis.com/auth/contacts";
        $response_type  = "code";//"token id_token";
        $redirect_uri   = "urn:ietf:wg:oauth:2.0:oob";//"http://127.0.0.1:8000/auth";
        $code           = "4/0AX4XfWggiPm5Q4bzgzywamCiPXAroG2YAVAEUie4NP8vM4NQoIY6xxblrTRmsy377aDWMw";
        $login_hint = "albertososamunoz@gmail.com";

        $full_url = [
            'client_id' => $client_id,
            'redirect_uri' =>$redirect_uri ,
            'scope' => $scope ,
            'response_type'=>$response_type,
            'login_hint' => $login_hint,
                    ];
        
        $google_curl = curl_init();
        curl_setopt( $google_curl, CURLOPT_URL , $auth_uri . '?' . http_build_query($full_url));
        print_r($auth_uri . '?' . http_build_query($full_url));
        //curl_setopt( $google_curl, CURLOPT_POST, TRUE);
        //curl_setopt( $google_curl, CURLOPT_POSTFIELDS, $curl_get_data);
        curl_setopt( $google_curl, CURLOPT_HEADER, TRUE);
        curl_setopt( $google_curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($google_curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($google_curl, CURLOPT_MAXREDIRS, 10);
        
        $response = curl_exec($google_curl);
                    
        //print_r($response);
        print_r(curl_getinfo($google_curl,CURLINFO_REDIRECT_URL));

    }
/**
 * Devuelve el auth token necesario para acceder a una api de google * 
 */
    public static function google_api_redirect(){
        
        $code           = null;
        $client_id      = "155879370556-6ot179b6cijrloupg62tl5o90hf107f8.apps.googleusercontent.com";
        $client_secret  = "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";       
        $redirect_uri   = "urn:ietf:wg:oauth:2.0:oob";//"http://127.0.0.1:8000/auth";
        $grant_type     = "authorization_code";
        $token_uri      = "https://accounts.google.com/o/oauth2/token";
        $full_url       = [
                           'client_id'     => $client_id,
                           'client_secret' => $client_secret,
                           'redirect_uri'  => $redirect_uri ,
                           'grant_type'    => 'authorization_code',
                           'code'          => $code,
                          ];
        
        $google_curl = curl_init();
        curl_setopt( $google_curl, CURLOPT_URL , $token_uri);        
        curl_setopt( $google_curl, CURLOPT_POST, TRUE);
        curl_setopt( $google_curl, CURLOPT_POSTFIELDS, $full_url);
        curl_setopt( $google_curl, CURLOPT_HEADER, FALSE);
        curl_setopt( $google_curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($google_curl, CURLOPT_FOLLOWLOCATION, 1);
        //curl_setopt($google_curl, CURLOPT_MAXREDIRS, 10);
        $response = curl_exec($google_curl);

        print_r($response);

    }

}

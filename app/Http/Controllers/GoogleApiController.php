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
        $login_hint     = 'albertososamunoz@gmail.com';

        $full_url = [
            'client_id' => $client_id,
            'redirect_uri' =>$redirect_uri ,
            'scope' => $scope ,
            'response_type'=>$response_type,
            'login_hint' => $login_hint,
                    ];

        print_r(GoogleApiController::obtain_google_api_code($client_id, $redirect_uri, $scope, $response_type, $login_hint));
        die();
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
        
        $access_token      = "vya29.A0ARrdaM_VnrbPwIAMrc1Ruvk2o6Y0cCmeugrYYQBA2GFyqhdq7pbkq3njPN_jtBj2cNJp6H8NmKkGDx1L0vn6dDotBrNeklpSy5X74rlSNj65-HsKtbJjlt3VeKqHN600RNf1beKof3qEkBJ3DkVXf-j5tS9X";
        $refresh_token     = "1//03Rz-pnzRkO5xCgYIARAAGAMSNwF-L9IrPfT76SeRwzT8-QxpwnEk0f8tGUQQdkHYt7h4StB0-D37mgsvYuwHm3aoyFI7if7YoSo";
        $code              = "4/1AX4XfWiIbHydtRFdFCqejcy-13qx-M-QPTSQolMB0Sjj64RBSoskTIp0flI";
        $client_id         = "155879370556-6ot179b6cijrloupg62tl5o90hf107f8.apps.googleusercontent.com";
        $client_secret     = "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";       
        $redirect_uri      = "urn:ietf:wg:oauth:2.0:oob";//"http://127.0.0.1:8000/auth";
        $grant_type        = "authorization_code";
        $token_uri         = "https://accounts.google.com/o/oauth2/token";
        $refresh_token_uri = "https://oauth2.googleapis.com/token";
                                  
        $response = GoogleApiController::obtain_google_api_token($client_id, $client_secret, $redirect_uri, $token_uri,  $code );

        $refresh_token = $response['refresh_token'];
        $access_token  = $response['access_token'];
        GoogleApiController::refresh_google_api_token($client_id, $client_secret, $redirect_uri, $refresh_token);

    }

    /**
     * devuelve url para obtener code
     */
    public static function obtain_google_api_code($client_id, $redirect_uri, $scope, $response_type,$login_hint = null){

        $auth_uri = "https://accounts.google.com/o/oauth2/auth";

        $full_url = [
            'client_id' => $client_id,
            'redirect_uri' =>$redirect_uri ,
            'scope' => $scope ,
            'response_type'=>$response_type,
            'login_hint' => $login_hint,
                    ];

        $google_curl = curl_init();
        curl_setopt( $google_curl, CURLOPT_URL , $auth_uri . '?' . http_build_query($full_url));
        return ($auth_uri . '?' . http_build_query($full_url));

        /*curl_setopt( $google_curl, CURLOPT_URL , $auth_uri . '?' . http_build_query($full_url));
        print_r($auth_uri . '?' . http_build_query($full_url));
        //curl_setopt( $google_curl, CURLOPT_POST, TRUE);
        //curl_setopt( $google_curl, CURLOPT_POSTFIELDS, $curl_get_data);
        curl_setopt( $google_curl, CURLOPT_HEADER, TRUE);
        curl_setopt( $google_curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($google_curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($google_curl, CURLOPT_MAXREDIRS, 10);
        
        $response = curl_exec($google_curl);
                    
        //print_r($response);
        print_r(curl_getinfo($google_curl,CURLINFO_REDIRECT_URL));*/
        
    }
    /**
     * devuelvetoken y refresh_token
     */
    public static function obtain_google_api_token($client_id, $client_secret, $redirect_uri, $token_uri,  $code, $grant_type = 'authorization_code'){
        $full_url          = [
            'client_id'     => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri'  => $redirect_uri ,
            'grant_type'    => $grant_type,                           
            'code'          => $code,
          ];

          $google_curl = curl_init();
          curl_setopt( $google_curl, CURLOPT_URL, $token_uri);   
          curl_setopt( $google_curl, CURLOPT_POST, TRUE);          
          curl_setopt( $google_curl, CURLOPT_POSTFIELDS, $full_url);
          curl_setopt( $google_curl, CURLOPT_HEADER, FALSE);
          curl_setopt( $google_curl, CURLOPT_RETURNTRANSFER, TRUE);
          curl_setopt($google_curl, CURLOPT_FOLLOWLOCATION, 1);
          //curl_setopt($google_curl, CURLOPT_MAXREDIRS, 10);

          return json_decode(curl_exec($google_curl));  
    }

    /**
     * permite refrescar el token con el refresh_token
     */
    public static function refresh_google_api_token($client_id,$client_secret,$redirect_uri, $refresh_token, $grant_type = 'refresh_token'){
        $refresh_token_uri            = 'https://oauth2.googleapis.com/token';
        $refresh_token_full_url       = [
            'client_id'     => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri'  => $redirect_uri ,
            'grant_type'    => $grant_type,                           
            'refresh_token' => $refresh_token
            ];

        $google_curl = curl_init();
        curl_setopt( $google_curl, CURLOPT_URL , $refresh_token_uri);        
        curl_setopt( $google_curl, CURLOPT_POST, TRUE);
        curl_setopt( $google_curl, CURLOPT_POSTFIELDS, $refresh_token_full_url);        
        curl_setopt( $google_curl, CURLOPT_HEADER, FALSE);
        curl_setopt( $google_curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($google_curl, CURLOPT_FOLLOWLOCATION, 1);
        //curl_setopt($google_curl, CURLOPT_MAXREDIRS, 10);
        return curl_exec($google_curl);
                       
    }
}

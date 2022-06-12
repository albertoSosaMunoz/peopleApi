<?php

namespace App\Http\Controllers\HelperAPI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


//auth token url
define('TOKEN_URL','https://accounts.google.com/o/oauth2/token');
//refresh token url
define('REFRESH_TOKEN_URL','https://oauth2.googleapis.com/token');
//oauth code
define('AUTH_URL','https://accounts.google.com/o/oauth2/auth');
// last google code
define('GOOGLE_CODE','4/1AX4XfWivNucnod7bKR_NW4273eW_ghYbJfe5eF9eJGebArptd6weyehomKY');
//redirect uri auto
define('REDIRECT_URI', 'urn:ietf:wg:oauth:2.0:oob');
//refresh token , always same when token auth expire
define('REFRESH_TOKEN','1//03FsHAEhKOTWnCgYIARAAGAMSNwF-L9IrajsPyPxR4vR-WaYKpS8lbbUYkOSInCnwej199OFmPbovdHgaStYsr9GBeenjHTLpr84');

class GoogleController extends Controller
{
    public static function get( $scope = 1){

        switch ($scope){
            case 1:
                $scope='https://people.googleapis.com/v1/people/me/connections';
            break;
            default:
            break;
        }
        
        //campos disponibles 
        //https://developers.google.com/people/api/rest/v1/people/get
 
        $query = [
            'personFields' => 'names,emailAddresses,phoneNumbers'
        ];
        //dd(json_encode($query));
        $response =    Http::withHeaders([
            'Authorization' => 'Bearer ya29.A0ARrdaM-GSn817q8WOyDOx_YjPtqhIqJ6VbZNVJgsh0SXA6NY734WxZLKrNux6b8CgJW4YhcYDGnBXhI0sd2MyeMEPWbfUio_bREjt1mpO3q12k1yhP_I1se-Or66QGroG13FNNir2-RpmrP9_bHzINitEk-QOwYUNnWUtBVEFTQVRBU0ZRRl91NjFWRENaLS04QUJ2c3Y0TTZ1OHp4SHlsQQ0165'
        ])->get( $scope, $query);

       return $response->json();
    }

    public static function post( $scope = 'https://people.googleapis.com/v1/people:createContact' ){

        $query = array(
            "phoneNumbers" => array(
                array(
                    "value" => "989856565"
                )
            ),
            "names" => array(
                array(
                    "givenName" => "Juanico el tontico"
                )
            )
        );
        $response =    Http::withHeaders([
            'Authorization' => 'Bearer ya29.A0ARrdaM-GSn817q8WOyDOx_YjPtqhIqJ6VbZNVJgsh0SXA6NY734WxZLKrNux6b8CgJW4YhcYDGnBXhI0sd2MyeMEPWbfUio_bREjt1mpO3q12k1yhP_I1se-Or66QGroG13FNNir2-RpmrP9_bHzINitEk-QOwYUNnWUtBVEFTQVRBU0ZRRl91NjFWRENaLS04QUJ2c3Y0TTZ1OHp4SHlsQQ0165'
        ])->post( $scope, $query);

       return $response->json();
    }

     /**
     * devuelve url para obtener code, copiar code en GOOGLE_CODE
     */
    public static function obtain_google_api_code($client_id, $response_type , $login_hint, $scope =  'https://www.googleapis.com/auth/contacts'){

        $full_url = [
            'client_id' => $client_id,
            'redirect_uri' => REDIRECT_URI ,
            'scope' => $scope ,
            'response_type'=>$response_type,
            'login_hint' => $login_hint,
                    ];

        return (AUTH_URL . '?' . http_build_query($full_url));
                    
    }

    /**
     * devuelvetoken y refresh_token usando el code de, obtain_google_api_code
     */
    public static function obtain_google_api_token($client_id, $client_secret, $grant_type = 'authorization_code'){
        $full_url          = [
            'client_id'     => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri'  => REDIRECT_URI ,
            'grant_type'    => $grant_type,                           
            'code'          => GOOGLE_CODE,
          ];

        $result = Http::post(TOKEN_URL,$full_url);
        return json_decode($result);
    }

    /**
     * permite refrescar el token con el refresh_token
     */
    public static function refresh_google_api_token($client_id,$client_secret, $grant_type = 'refresh_token'){
 
        $refresh_token_full_url       = [
            'client_id'     => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri'  => REDIRECT_URI,
            'grant_type'    => $grant_type,                           
            'refresh_token' => REFRESH_TOKEN
            ];

        $response = Http::post( REFRESH_TOKEN_URL, $refresh_token_full_url);
        return $response->json();
                       
    }
}

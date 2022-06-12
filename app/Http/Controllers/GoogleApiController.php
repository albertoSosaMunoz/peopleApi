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

        //dd( GoogleController::get());
        //dd( GoogleController::post());
         //obtenemos el codigo para pedir los tokens
        //GoogleController::obtain_google_api_code($client_id,'code','albertososamunoz@gmail.com');
        //$response = GoogleController::obtain_google_api_token($client_id, $client_secret);
        //dd(GoogleController::refresh_google_api_token($client_id,$client_secret));
        dd(GoogleApiController::convert_clientify_to_people());
    }

    public static function sync_clientify_contacts( $clientify_api_key, $clientify_contact ){
        
        //fetch all contacts from google people

    }

    public static function convert_clientify_to_people( $clientify_contact = []){

        $people_contact = [];
        $phone_array    = [];
        $emails_array   = [];

        $clientify_contact['first_name'] = 'alberto';
        $clientify_contact['last_name'] = 'muñoz';
        //people contact_name
        $people_contact["names"] = array(
            array(
                "givenName" => $clientify_contact['first_name'] . ' ' . $clientify_contact['last_name']
            )
            );
        
        //people contact_phone
        
        $clientify_contact['phones'] = array( 
            array(
                'phone' => '12345',
                'type' => '1'
            )
        );

        foreach ($clientify_contact['phones'] as $single_phone){
            $phone_array= $single_phone['phone'];
        }
        $people_contact["phoneNumbers"]= array(
            array(
                "value" => $phone_array
            )
            );
            
        //people contact_email
        $clientify_contact['emails'] = array( 
            array(
                'email' => 'alberto@gmail.com',
                'type' => '1'
            )
        );

        foreach ($clientify_contact['emails'] as $single_email){
            $emails_array = $single_email['email'];
        }
        $people_contact["emailAddresses"] = array(
            array(
                "value" => $emails_array
            )
        );

        return $people_contact;
        
    }

}

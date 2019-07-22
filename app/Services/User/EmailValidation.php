<?php
/**
 * User: user
 * Date: 19.07.19
 * Time: 10:54
 */

namespace App\Services\User;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailValidation
{    
    /**
     * validation email user Neverbonce API
     */
    public static function check_email($email)
    {
        $nb_email_valid = false;
        $nb_apikey = env("NEVERBOUNCE_API_KEY");
        $curl = curl_init();
        $nb_api_check_url = 'https://api.neverbounce.com/v4/single/check?key='.$nb_apikey.'&email='.$email;

        curl_setopt_array($curl, array(
            CURLOPT_URL =>$nb_api_check_url ,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        $res = json_decode($response);

        $valid_result = ['valid', 'catchall', 'unknown'];
        $invalid_result = ['invalid', 'disaposable'];

        if ($res->status == 'success') {
            if (in_array($res->result, $valid_result)) {
                $nb_email_valid = true;
            }
        }
        return $nb_email_valid;
    }
}

<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\Log;


class verify_payments
{

    //construct fucntionm
    public function __construct()
    {
        return true;
        // Log::info('construct call');
        session_start();
        // require_once '../verify_payments.php';
        // require_once 'verify_payments.php';
        $domain_local = $_SERVER["SERVER_NAME"];
        if (isset($_SESSION["expired"])) {
            // Log::info('already set exprired construct');
            // session_destroy();
            if ($_SESSION["expired"] == "no")
                return;
            else $this->makePayment($domain_local);
        }

        $domain_local = str_replace('.', '-', $domain_local);
        $response = $this->httpPost('https://developer360.in/api/get-website-details', array('domain' => $domain_local));
        $json = json_decode($response, true);


        if (
            $json !== null && !$json['error']
        ) {
            // Log::info('all good to construct');
            $days_left = $json['website']['expiry_days'];
            // $domain = $json['website']['domain'];
            if ($days_left <= 0) {
                $_SESSION["expired"] = "yes";
                $this->makePayment($domain_local);
            } else {
                $_SESSION["expired"] = "no";
            }
        } else {
            // Log::info('json null or error is true construct');
            $_SESSION["expired"] = "yes";
            $this->makePayment($domain_local);
        }
    }

    function makePayment($domain)
    {
        header("Location: https://developer360.in/make-website-payment/" . $domain);
        exit();
    }

    function httpPost($url, $data)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}

<?php


/*
 * This file is part of the Laravel Paystack package.
 *
 * (c) Mujtech Mujeeb <mujeeb.muhideen@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mujhtech\Varspay;
use Illuminate\Support\Facades\Config;

class Varspay {


    /**
	 * @var string Varspay.com API Endpoint
	 */

    private $endpoint = 'https://api.varspay.com/v1';

	/**
	 * @var string API Public Key
	 */
    private $apiKey;
    

    public function __construct() {
		$this->setApiKey();
    }
    

    /**
	 * @param string $apiKey API Public Key
	 * @return APIClient
	 */
	public function setApiKey() {
		$this->apiKey = Config::get('varspay-tech.apiKey');
		return $this;
    }


    public function getBalance(){

        $result = $this->request('user/balance', [], 'POST');

        return $result;

    }


    public function getMe(){

        $result = $this->request('me', [], 'POST');

        return $result;

    }


    public function getAlerts($acctNo){

        $result = $this->request('alerts?accountNumber='.$acctNo, [], 'GET');

        return $result;

    }


    public function retrieveAccountNumber($email){

        $result = $this->request('user/nuban', ['userEmail' => $email], 'POST');

        return $result;

    }


    public function changePin($email, $pin){

        $result = $this->request('user/pin', ['email' => $email, 'newPin' => $pin], 'POST');

        return $result;

    }



    public function changePassword($email, $pin){

        $result = $this->request('user/password', ['email' => $email, 'newPassword' => $pin], 'POST');

        return $result;

    }

    public function bankList(){

        $result = $this->request('banks', [], 'GET');

        return $result;

    }


    public function resolveBvn($bvn){

        $result = $this->request('resolve-bvn', ['bvn' => $bvn], 'POST');

        return $result;

    }


    public function resolveAccount($acctNo, $bankCode){

        $result = $this->request('resolve-account', [
            'accountnumber' => $acctNo,
            'bankcode' => $bankCode
        ], 'POST');

        return $result;

    }


    public function createVirtualAccount($acctName){

        $result = $this->request('createvirtualaccount', [
            'name' => $acctName
        ], 'POST');

        return $result;

    }


    public function getAllVirtualAccount(){

        $result = $this->request('virtualaccount', [], 'POST');

        return $result;

    }


    public function getVirtualAccountTransaction($acctNo){

        $result = $this->request('virtualaccount/listtransactions', [
            'virtualaccount' => $acctNo
        ], 'POST');

        return $result;

    }


    public function transferToVarspay($amount, $email){

        $result = $this->request('transfer/own', [
            'amount' => $amount,
            'email' => $email
        ], 'POST');

        return $result;

    }


    public function transferToOtherBank($amount, $bankCode, $description, $acctNo, $acctName){

        $result = $this->request('transfer/other', [
            'amount' => $amount,
            'bankCode' => $bankCode,
            'description' => $description,
            'accountNumber' => $acctNo,
            'accountName' => $acctName
        ], 'POST');

        return $result;

    }

    public function transferToOtherBankBulk($bulk){

        $result = $this->request('transfer/other/bulk', [
            'bulkList' => $bulk
        ], 'POST');

        return $result;

    }


    public function getSingleTransferDetails($ref){

        $result = $this->request('transfer/details/single?reference='.$ref, [], 'GET');

        return $result;

    }


    public function getBulkTransferDetails($ref){

        $result = $this->request('transfer/details/bulk?batchReference='.$ref, [], 'GET');

        return $result;

    }



    public function airtimeProviders(){

        $result = $this->request('airtime/providers', [], 'POST');

        return $result;

    }


    public function airtimePurchase($amount, $phone, $provider){

        $result = $this->request('airtime/buy', [
            'amount' => $amount,
            'phoneNumber' => $phone,
            'providerShortCode' => $provider
        ], 'POST');

        return $result;

    }


    public function airtimeQueris($ref){

        $result = $this->request('airtime/query', [
            'reference' => $ref
        ], 'POST');

        return $result;

    }



    public function airtimeSwapProviders(){

        $result = $this->request('airtime/swap/providers', [], 'POST');

        return $result;

    }

    public function airtimeSwap($amount, $phone, $provider){

        $result = $this->request('airtime/swap', [
            'amount' => $amount,
            'phoneNumber' => $phone,
            'provider' => $provider
        ], 'POST');

        return $result;

    }
    



    /**
	 * @param string $method
	 * @param array $params
     * @param array $type
	 */
	private function request($method, $params = [], $type) {

		if (empty($this->apiKey) ) {
			return 'Error: API Key are not set.';
		}

		$url = $this->endpoint . '/' . $method;


        if($type == "POST"){

            $data = json_encode($params, 320);
        
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: Bearer ".$this->api_key
            ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            
            if ($err) {
                return "cURL Error #:" . $err;
            } else {
                return json_decode($response, true);
            }

        } elseif($type == "GET"){

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: Bearer ".$this->api_key
            ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            
            if ($err) {
                return "cURL Error #:" . $err;
            } else {
                return json_decode($response, true);
            }

        } else {
            return 'Undefined Method Type';
        }
	}

}
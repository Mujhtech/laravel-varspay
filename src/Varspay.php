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
     * Set api key
	 * @param string $apiKey API Public Key
	 * @return 
	 */
	public function setApiKey() {
		$this->apiKey = Config::get('varspay-tech.apiKey');
    }


    /**
     * Fetch your current balance
     * @param 
     * @return array
     */


    public function getBalance(){

        $result = $this->request('user/balance', [], 'POST');

        return $result;

    }


    /**
     * Fetch all information about yourself
     * @param
     * @return array
     */


    public function getMe(){

        $result = $this->request('me', [], 'POST');

        return $result;

    }


    /**
     * Fetch all alerts 
     * @param $acctNo
     * @return array
     */


    public function getAlerts($acctNo){

        $result = $this->request('alerts?accountNumber='.$acctNo, [], 'GET');

        return $result;

    }


    /**
     * Retrieve Account Number
     * @param $email
     * @return array
     */


    public function retrieveAccountNumber($email){

        $result = $this->request('user/nuban', ['userEmail' => $email], 'POST');

        return $result;

    }


    /**
     * Change transaction pin
     * @param $email, $pin
     * @return array
     */


    public function changePin($email, $pin){

        $result = $this->request('user/pin', ['email' => $email, 'newPin' => $pin], 'POST');

        return $result;

    }

    /**
     * Change password
     * @param $email, $password
     * @return array
     */

    public function changePassword($email, $password){

        $result = $this->request('user/password', ['email' => $email, 'newPassword' => $password], 'POST');

        return $result;

    }


    /**
     * Fetch list of available banks
     * @param
     * @return array
     */

    public function bankList(){

        $result = $this->request('banks', [], 'GET');

        return $result;

    }


    /**
     * Fetch information about bvn (Note: This cost 25 per call)
     * @param $bvn
     * @return array
     */


    public function resolveBvn($bvn){

        $result = $this->request('resolve-bvn', ['bvn' => $bvn], 'POST');

        return $result;

    }


    /**
     * Fetch information about an account
     * @param $acctNo, $bankCode
     * @return array
     */


    public function resolveAccount($acctNo, $bankCode){

        $result = $this->request('resolve-account', [
            'accountnumber' => $acctNo,
            'bankcode' => $bankCode
        ], 'POST');

        return $result;

    }


    /**
     * Create a virtual account
     * @param $acctName
     * @return array
     */


    public function createVirtualAccount($acctName){

        $result = $this->request('createvirtualaccount', [
            'name' => $acctName
        ], 'POST');

        return $result;

    }

    /**
     * Fetch all virtual accounts
     * @param 
     * @return array
     */


    public function getAllVirtualAccount(){

        $result = $this->request('virtualaccount', [], 'POST');

        return $result;

    }

    /**
     * Fetch all transaction on a specific virtual account
     * @param $acctNo
     * @return array
     */


    public function getVirtualAccountTransaction($acctNo){

        $result = $this->request('virtualaccount/listtransactions', [
            'virtualaccount' => $acctNo
        ], 'POST');

        return $result;

    }

    /**
     * Single transfer to varspay account
     * @param $amount, $email
     * @return array
     */

    public function transferToVarspay($amount, $email){

        $result = $this->request('transfer/own', [
            'amount' => $amount,
            'email' => $email
        ], 'POST');

        return $result;

    }

    /**
     * Single transfer to other bank
     * @param $amount, $bankCode, $description, $acctNo, $acctName
     * @return array
     */

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

    /**
     * Bulk transfer to other bank
     * @param $bulk = [ array( "amount" => "100", "narration" => "Test Transfer", "accountname" => "OLUCHI AMARA", "bankname" => "ECOBANK", "accountnumber" => "8883116789", "bankcode"=> "000010"), array( "amount" => "100", "narration" => "Test Transfer", "accountname" => "OLUCHI AMARA", "bankname" => "ECOBANK", "accountnumber" => "8883116789", "bankcode"=> "000010") ]
     * @return array
     */

    public function transferToOtherBankBulk($bulk){

        $result = $this->request('transfer/other/bulk', [
            'bulkList' => $bulk
        ], 'POST');

        return $result;

    }

    /**
     * Query single transfer transaction
     * @param subaccount code
     * @return array
     */


    public function getSingleTransferDetails($ref){

        $result = $this->request('transfer/details/single?reference='.$ref, [], 'GET');

        return $result;

    }


    /**
     * Queries bulk transfer transaction
     * @param $ref code
     * @return array
     */

    public function getBulkTransferDetails($ref){

        $result = $this->request('transfer/details/bulk?batchReference='.$ref, [], 'GET');

        return $result;

    }


    /**
     * Fetch airtime provider
     * @param 
     * @return array
     */


    public function airtimeProviders(){

        $result = $this->request('airtime/providers', [], 'POST');

        return $result;

    }


    /**
     * Purchase an airtime
     * @param $amount, $phone, $provider code
     * @return array
     */


    public function airtimePurchase($amount, $phone, $provider){

        $result = $this->request('airtime/buy', [
            'amount' => $amount,
            'phoneNumber' => $phone,
            'providerShortCode' => $provider
        ], 'POST');

        return $result;

    }

    /**
     * Fetch airtime transaction queires
     * @param $ref code
     * @return array
     */

    public function airtimeQueris($ref){

        $result = $this->request('airtime/query', [
            'reference' => $ref
        ], 'POST');

        return $result;

    }

    /**
     * List of airtim swap providers
     * 
     * @return array
     */

    public function airtimeSwapProviders(){

        $result = $this->request('airtime/swap/providers', [], 'POST');

        return $result;

    }

    /**
     * create an airtimeswap transaction
     * @param $amount, $phone, $provider code
     * @return array
     */

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
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: Bearer ".$this->apiKey
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
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Content-Type: application/json",
                "Authorization: Bearer ".$this->apiKey
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
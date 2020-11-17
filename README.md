# laravel-varspay
> A Laravel Package for working with Varspay seamlessly


## Installation

[PHP](https://php.net) 5.4+ or [HHVM](http://hhvm.com) 3.3+, and [Composer](https://getcomposer.org) are required.

To get the latest version of Laravel Paystack, simply require it

```bash
composer require mujhtech/laravel-varspay
```

Or add the following line to the require block of your `composer.json` file.

```
"mujhtech/laravel-varspay": "1.0.*"
```

You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.


Once Laravel Varspay is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

```php
'providers' => [
    ...
    Mujhtech\Varspay\VarspayServiceProvider::class,
    ...
]
```

> If you use **Laravel >= 5.5** you can skip this step and go to [**`configuration`**](https://github.com/unicodeveloper/laravel-paystack#configuration)

* `Unicodeveloper\Paystack\PaystackServiceProvider::class`

Also, register the Facade like so:

```php
'aliases' => [
    ...
    'Varspay' => Mujhtech\Varspay\Facades\Varspay::class,
    ...
]
```


## Configuration

You can publish the configuration file using this command:

```bash
php artisan vendor:publish --provider="Mujhtech\Varspay\VarspayServiceProvider"
```

A configuration-file named `varspay-tech.php` with some sensible defaults will be placed in your `config` directory:

```php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API KEY
    |--------------------------------------------------------------------------
    |
    |
    */

    'apiKey' => getenv('VARSPAY_API_KEY'),

];
```


## Usage

Open your .env file and add your api key like so:

```php
VARSPAY_API_KEY=vp_live_xxxxxxxxxxx
```
*If you are using a hosting service like heroku, ensure to add the above details to your configuration variables.*


Let me explain the fluent methods this package provides a bit here.
```php
/**
     * Fetch your current balance
     * @param 
     * @return array
     */
Varspay::getBalance()

/**
 * Alternatively, use the helper.
 */
varspay()->getBalance();

/**
     * Fetch all information about yourself
     * @param
     * @return array
     */
Varspay::getMe();

/**
 * Alternatively, use the helper.
 */
varspay()->getMe();

/**
     * Fetch all alerts 
     * @param $acctNo
     * @return array
     */
Varspay::getAlerts($acctNo);

/**
 * Alternatively, use the helper.
 */
varspay()->getAlerts($acctNo);


/**
     * Retrieve Account Number
     * @param $email
     * @return array
     */
Varspay::retrieveAccountNumber($email);

/**
 * Alternatively, use the helper.
 */
varspay()->retrieveAccountNumber($email);


/**
     * Change transaction pin
     * @param $email, $pin
     * @return array
     */
Varspay::changePin($email, $pin);

/**
 * Alternatively, use the helper.
 */
varspay()->changePin($email, $pin);

/**
     * Change password
     * @param $email, $password
     * @return array
     */
Varspay::changePassword($email, $password);

/**
 * Alternatively, use the helper.
 */
varspay()->changePassword($email, $password);


/**
     * Fetch list of available banks
     * @param
     * @return array
     */
Varspay::bankList();

/**
 * Alternatively, use the helper.
 */
varspay()->bankList();


/**
     * Fetch information about bvn (Note: This cost 25 per call)
     * @param $bvn
     * @return array
     */
Varspay::resolveBvn($bvn);

/**
 * Alternatively, use the helper.
 */
varspay()->resolveBvn($bvn);


/**
     * Fetch information about an account
     * @param $acctNo, $bankCode
     * @return array
     */
Varspay::resolveAccount($acctNo, $bankCode);

/**
 * Alternatively, use the helper.
 */
varspay()->resolveAccount($acctNo, $bankCode);


/**
     * Create a virtual account
     * @param $acctName
     * @return array
     */
Varspay::createVirtualAccount($acctName);

/**
 * Alternatively, use the helper.
 */
varspay()->createVirtualAccount($acctName);


/**
     * Fetch all virtual accounts
     * @param 
     * @return array
     */
Varspay::getAllVirtualAccount();

/**
 * Alternatively, use the helper.
 */
varspay()->getAllVirtualAccount();


/**
     * Fetch all transaction on a specific virtual account
     * @param $acctNo
     * @return array
     */
Varspay::getVirtualAccountTransaction($acctNo);

/**
 * Alternatively, use the helper.
 */
varspay()->getVirtualAccountTransaction($acctNo);


/**
     * Single transfer to varspay account
     * @param $amount, $email
     * @return array
     */
Varspay::transferToVarspay($amount, $email);

/**
 * Alternatively, use the helper.
 */
varspay()->transferToVarspay($amount, $email);


/**
     * Single transfer to other bank
     * @param $amount, $bankCode, $description, $acctNo, $acctName
     * @return array
     */
Varspay::transferToOtherBank($amount, $bankCode, $description, $acctNo, $acctName);

/**
 * Alternatively, use the helper.
 */
varspay()->transferToOtherBank($amount, $bankCode, $description, $acctNo, $acctName);


/**
     * Bulk transfer to other bank
     * @param $bulk = [ array( "amount" => "100", "narration" => "Test Transfer", "accountname" => "OLUCHI AMARA", "bankname" => "ECOBANK", "accountnumber" => "8883116789", "bankcode"=> "000010"), array( "amount" => "100", "narration" => "Test Transfer", "accountname" => "OLUCHI AMARA", "bankname" => "ECOBANK", "accountnumber" => "8883116789", "bankcode"=> "000010") ]
     * @return array
     */
Varspay::transferToOtherBankBulk($bulk);

/**
 * Alternatively, use the helper.
 */
varspay()->transferToOtherBankBulk($bulk);



/**
     * Query single transfer transaction
     * @param subaccount code
     * @return array
     */
Varspay::getSingleTransferDetails($ref);

/**
 * Alternatively, use the helper.
 */
varspay()->getSingleTransferDetails($ref);


/**
     * Queries bulk transfer transaction
     * @param $ref code
     * @return array
     */
Varspay::getBulkTransferDetails($ref);

/**
 * Alternatively, use the helper.
 */
varspay()->getBulkTransferDetails($ref);

/**
     * Fetch airtime provider
     * @param 
     * @return array
     */
Varspay::airtimeProviders();

/**
 * Alternatively, use the helper.
 */
varspay()->airtimeProviders();

/**
     * Purchase an airtime
     * @param $amount, $phone, $provider code
     * @return array
     */
Varspay::airtimePurchase($amount, $phone, $provider);

/**
 * Alternatively, use the helper.
 */
varspay()->airtimePurchase($amount, $phone, $provider);

/**
     * Fetch airtime transaction queires
     * @param $ref code
     * @return array
     */
Varspay::airtimeQueris($ref);

/**
 * Alternatively, use the helper.
 */
varspay()->airtimeQueris($ref);

/**
     * List of airtim swap providers
     * 
     * @return array
     */
Varspay::airtimeSwapProviders();

/**
 * Alternatively, use the helper.
 */
varspay()->airtimeSwapProviders();

/**
     * create an airtimeswap transaction
     * @param $amount, $phone, $provider code
     * @return array
     */
Varspay::airtimeSwap($amount, $phone, $provider);

/**
 * Alternatively, use the helper.
 */
varspay()->airtimeSwap($amount, $phone, $provider);
```


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


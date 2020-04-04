# Omnipay: Buckaroo (JSON)

An Omnipay module for the Buckaroo payment processor. This library uses the new JSON-based API, whereas [thephpleague/omnipay-buckaroo](https://github.com/thephpleague/omnipay-buckaroo) uses the old API.

## Installation

```
composer require league/omnipay martijndwars/omnipay-buckaroo-json
```

## Usage

```php
$gateway = \Omnipay\Omnipay::create('BuckarooJson');  
$gateway->setWebsiteKey('');
$gateway->setSecretKey('');

$response = $gateway->purchase([
    'amount' => '12.34',
    'currency' => 'EUR',
    'culture' => 'nl-nL',
    'transactionId' => '1',
    'returnUrl' => 'https://webshop.com/checkout/return',
    'pushUrl' => 'https://webshop.com/checkout/notify',
])->send();

if ($response->isSuccessful()) {
    var_dump($response);
} elseif ($response->isRedirect()) {
    $response->redirect();
} else {
    echo $response->getMessage();
}
```


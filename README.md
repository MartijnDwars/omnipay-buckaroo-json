# Omnipay: Buckaroo (JSON)

An Omnipay module for the Buckaroo payment processor. This library uses the new JSON-based API, whereas [thephpleague/omnipay-buckaroo](https://github.com/thephpleague/omnipay-buckaroo) uses the old API.

## Installation

```
composer require league/omnipay martijndwars/omnipay-buckaroo-json
```

## Usage

To redirect to Buckaroo's payment screen and let the user choose between iDeal, PayPal, MasterCard, Visa:

```php
$gateway = \Omnipay\Omnipay::create('\MartijnDwars\Omnipay\Buckaroo\Gateway');
$gateway->setWebsiteKey('');
$gateway->setSecretKey('');
$gateway->setTestMode(true);

$response = $gateway->purchase([
    'amount' => '12.34',
    'currency' => 'EUR',
    'culture' => 'nl-nL',
    'transactionId' => '1',
    'paymentMethod' => 'ideal,paypal,mastercard,visa',
    'description' => 'Acme order #1',
    'returnUrl' => 'https://webshop.com/checkout/return',
    'pushUrl' => 'https://webshop.com/checkout/notify',
])->send();

if ($response->isRedirect()) {
    redirect($response->redirect());
} else {
    echo $response->getMessage();
}
```

If you want to use a specific payment method:

```php
...

$response = $gateway->purchase([
    ...
    'paymentMethod' => 'ideal',
    ...
])->send();

...
```

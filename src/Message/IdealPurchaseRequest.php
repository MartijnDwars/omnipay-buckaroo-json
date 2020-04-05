<?php

namespace MartijnDwars\Omnipay\Buckaroo\Message;

/**
 * Buckaroo iDeal Purchase Request
 */
class IdealPurchaseRequest extends BaseRequest
{
    public function getData()
    {
        return [
            'Currency' => 'EUR',
            'AmountDebit' => 10.0,
            'Invoice' => 'testinvoice 123',
            'ClientIP' => [
                'Type' => 0,
                'Address' => '0.0.0.0',
            ],
            'Services' => [
                'ServiceList' => [
                    0 => [
                        'Name' => 'ideal',
                        'Action' => 'Pay',
                        'Parameters' => [
                            0 => [
                                'Name' => 'issuer',
                                'Value' => 'ABNANL2A',
                            ]
                        ]
                    ]
                ]
            ]
        ];

        /*
        $data = parent::getData();
        $data['Brq_payment_method'] = 'ideal';

        if ($this->getIssuer()) {
            $data['Brq_service_ideal_issuer'] = $this->getIssuer();
        }

        return $data;
        */
    }
}


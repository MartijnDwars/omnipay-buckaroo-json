<?php

namespace MartijnDwars\Omnipay\Buckaroo\Message\Request;

use Exception;
use MartijnDwars\Omnipay\Buckaroo\Message\Response\PurchaseResponse;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Create a payment with the Buckaroo API.
 *
 * @see https://dev.buckaroo.nl/apis
 * @method PurchaseResponse send()
 */
class PurchaseRequest extends AbstractBuckarooRequest
{
    /**
     * @return boolean
     */
    public function isRecurrent()
    {
        return $this->getParameter('recurrent');
    }

    /**
     * @param $recurrent
     * @return PurchaseRequest
     */
    public function setRecurrent($recurrent)
    {
        return $this->setParameter('recurrent', true);
    }

    /**
     * @inheritDoc
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('websiteKey', 'secretKey', 'amount', 'currency');

        $data = [
            'Currency' => $this->getCurrency(),
            'AmountDebit' => (float) $this->getAmount(),
            'Invoice' => $this->getTransactionId(),
            'Description' => $this->getDescription(),
        ];

        if ($this->getPaymentMethod()) {
            // If the payment method is iDeal, then the issuer should be present or ContinueOnIncomplete should be set
            if ($this->containsIdeal() && $this->getIssuer() == null) {
                $data['ContinueOnIncomplete'] = true;
            }

            $data['ContinueOnIncomplete'] = true;
            $data['ServicesSelectableByClient'] = $this->getPaymentMethod();
        }

        if ($this->getIssuer()) {
            $data['Services']['ServiceList'] = [
                [
                    'Name' => 'ideal',
                    'Action' => 'Pay',
                    'Parameters' => [
                        [
                            'Name' => 'issuer',
                            'Value' => $this->getIssuer()
                        ]
                    ]
                ]
            ];
        }

        if ($this->getReturnUrl() != null) {
            $data['ReturnURL'] = $this->getReturnUrl();
        }

        if ($this->getNotifyUrl() != null) {
            $data['PushURL'] = $this->getNotifyUrl();
        }

        if ($this->isRecurrent()) {
            $data['StartRecurrent'] = true;
        }

        return $data;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function sendData($data)
    {
        $response = $this->sendRequest(self::POST, 'transaction', $data);

        return $this->response = new PurchaseResponse($this, $response);
    }

    /**
     * Check if the list of payment methods contains ideal.
     *
     * @return bool
     */
    private function containsIdeal()
    {
        return stristr($this->getPaymentMethod(), 'ideal') !== false;
    }
}

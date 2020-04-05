<?php

namespace MartijnDwars\Omnipay\Buckaroo\Message\Response;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    const SUCCESS = '190';

    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        return static::SUCCESS === $this->getCode();
    }

    public function getCode()
    {
        if (!isset($this->data['BRQ_STATUSCODE'])) {
            return null;
        }
        return $this->data['BRQ_STATUSCODE'];
    }

    public function getMessage()
    {
        if (!isset($this->data['BRQ_STATUSMESSAGE'])) {
            return null;
        }
        return $this->data['BRQ_STATUSMESSAGE'];
    }

    public function getTransactionReference()
    {
        if (!isset($this->data['BRQ_PAYMENT'])) {
            return null;
        }
        return $this->data['BRQ_PAYMENT'];
    }

    public function getTransactionId()
    {
        if (!isset($this->data['BRQ_INVOICENUMBER'])) {
            return null;
        }
        return $this->data['BRQ_INVOICENUMBER'];
    }
}
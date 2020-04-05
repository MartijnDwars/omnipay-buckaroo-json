<?php

namespace MartijnDwars\Omnipay\Buckaroo\Message\Request;

use MartijnDwars\Omnipay\Buckaroo\Message\Response\CompletePurchaseResponse;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Retrieve a single payment object by its payment token.
 *
 * @see https://dev.buckaroo.nl/apis
 * @method CompletePurchaseResponse send()
 */
class CompletePurchaseRequest extends AbstractBuckarooRequest
{
    /**
     * @inheritDoc
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('websiteKey', 'secretKey');

        $originalData = $this->httpRequest->request->all();
        $data = array_change_key_case($originalData, CASE_UPPER);

        $signature = isset($data['BRQ_SIGNATURE']) ? strtolower($data['BRQ_SIGNATURE']) : null;

        if ($signature !== $this->generateSignature($originalData)) {
            throw new InvalidRequestException('Incorrect signature');
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    public function generateSignature($data)
    {
        uksort($data, 'strcasecmp');

        $str = '';
        foreach ($data as $key => $value) {
            if (strcasecmp($key, 'brq_signature') === 0) {
                continue;
            }
            $str .= $key.'='.urldecode($value);
        }

        return sha1($str.$this->getSecretKey());
    }
}

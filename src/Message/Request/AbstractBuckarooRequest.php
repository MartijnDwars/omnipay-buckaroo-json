<?php

namespace MartijnDwars\Omnipay\Buckaroo\Message\Request;

use Exception;
use MartijnDwars\Omnipay\Buckaroo\Gateway;
use Omnipay\Common\Message\AbstractRequest;

abstract class AbstractBuckarooRequest extends AbstractRequest
{
    const POST = 'POST';
    const TEST_ENDPOINT = 'https://testcheckout.buckaroo.nl/json/';
    const LIVE_ENDPOINT = 'https://checkout.buckaroo.nl/json/';

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        if ($this->getParameter('testMode') === true) {
            return self::TEST_ENDPOINT;
        } else {
            return self::LIVE_ENDPOINT;
        }
    }

    /**
     * @return string
     */
    public function getWebsiteKey()
    {
        return $this->getParameter('websiteKey');
    }

    /**
     * @param $websiteKey
     * @return $this
     */
    public function setWebsiteKey($websiteKey)
    {
        return $this->setParameter('websiteKey', $websiteKey);
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * @param $secretKey
     * @return $this
     */
    public function setSecretKey($secretKey)
    {
        return $this->setParameter('secretKey', $secretKey);
    }

    /**
     * @param $method
     * @param $endpoint
     * @param $data
     * @return array
     * @throws Exception
     */
    public function sendRequest($method, $endpoint, $data)
    {
        $versions = [
            'Omnipay-Buckaroo/' . Gateway::GATEWAY_VERSION,
            'PHP/' . phpversion(),
        ];

        $websiteKey = $this->getWebsiteKey();
        $secretKey = $this->getSecretKey();
        $uri = $this->getBaseUrl() . $endpoint;
        $strippedUri = self::stripUri($uri);
        $body = json_encode($data);
        $nonce = bin2hex(random_bytes(16));
        $time = time();
        $signature = base64_encode(md5($body ,true));
        $parts = $websiteKey . $method . $strippedUri . $time . $nonce . $signature;
        $hmac = hash_hmac('sha256', $parts, $secretKey, true);
        $hash = base64_encode($hmac);

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'hmac ' . $websiteKey . ':' . $hash . ':' . $nonce . ':' . $time,
            'User-Agent' => implode(' ', $versions),
            'Culture' => 'nl-NL',
        ];

        $response = $this->httpClient->request($method, $uri, $headers, $body);

        return json_decode($response->getBody(), true);
    }

    private static function stripUri($uri)
    {
        if (substr($uri, 0, 8) == 'https://') {
            $uri = substr($uri, 8);
        }

        if (substr($uri, 0, 7) == 'http://') {
            $uri = substr($uri, 7);
        }

        return strtolower(urlencode($uri));
    }
}

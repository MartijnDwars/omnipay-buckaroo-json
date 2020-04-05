<?php

namespace MartijnDwars\Omnipay\Buckaroo;

use MartijnDwars\Omnipay\Buckaroo\Message\Request\CompletePurchaseRequest;
use MartijnDwars\Omnipay\Buckaroo\Message\Request\PurchaseRequest;
use Omnipay\Common\AbstractGateway;

/**
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
 */
class Gateway extends AbstractGateway
{
    const GATEWAY_VERSION = '1.0';

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'Buckaroo';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'websiteKey' => '',
            'secretKey' => '',
            'testMode' => false,
        );
    }

    /**
     * @return string
     */
    public function getWebsiteKey()
    {
        return $this->getParameter('websiteKey');
    }

    /**
     * @param string $websiteKey
     * @return Gateway
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
     * @param string $secretKey
     * @return Gateway
     */
    public function setSecretKey($secretKey)
    {
        return $this->setParameter('secretKey', $secretKey);
    }

    /**
     * @param  array $parameters
     * @return PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        /** @var PurchaseRequest $request */
        $request = $this->createRequest(PurchaseRequest::class, $parameters);

        return $request;
    }

    /**
     * @param  array $parameters
     * @return CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = [])
    {
        /** @var CompletePurchaseRequest $request */
        $request = $this->createRequest(CompletePurchaseRequest::class, $parameters);

        return $request;
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
        // TODO: Implement @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
    }
}
<?php

namespace MartijnDwars\Omnipay\Buckaroo\Message\Response;

use MartijnDwars\Omnipay\Buckaroo\Message\Request\AbstractBuckarooRequest;
use Omnipay\Common\Message\RedirectResponseInterface;
use RuntimeException;

class PurchaseResponse implements RedirectResponseInterface
{
    /**
     * @var AbstractBuckarooRequest
     */
    private $request;

    /**
     * @var array
     */
    private $response;

    /**
     * PurchaseResponse constructor.
     *
     * @param AbstractBuckarooRequest $request
     * @param array $response
     */
    public function __construct(AbstractBuckarooRequest $request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        return $this->response;
    }

    /**
     * @inheritDoc
     */
    public function getRedirectUrl()
    {
        throw new RuntimeException('TODO');
    }

    /**
     * @inheritDoc
     */
    public function getRedirectMethod()
    {
        throw new RuntimeException('TODO');
    }

    /**
     * @inheritDoc
     */
    public function getRedirectData()
    {
        throw new RuntimeException('TODO');
    }

    /**
     * @inheritDoc
     */
    public function redirect()
    {
        if (!isset($this->response['RequiredAction'])) {
            return false;
        }

        if (!isset($this->response['RequiredAction']['RedirectURL'])) {
            return false;
        }

        return $this->response['RequiredAction']['RedirectURL'];
    }

    /**
     * @inheritDoc
     */
    public function getRequest()
    {
        throw new RuntimeException('TODO');
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful()
    {
        throw new RuntimeException('TODO');
    }

    /**
     * @inheritDoc
     */
    public function isRedirect()
    {
        if (!isset($this->response['RequiredAction'])) {
            return false;
        }

        if (!isset($this->response['RequiredAction']['Name'])) {
            return false;
        }

        return $this->response['RequiredAction']['Name'] == 'Redirect';
    }

    /**
     * @inheritDoc
     */
    public function isCancelled()
    {
        throw new RuntimeException('TODO');
    }

    /**
     * @inheritDoc
     */
    public function getMessage()
    {
        throw new RuntimeException('TODO');
    }

    /**
     * @inheritDoc
     */
    public function getCode()
    {
        throw new RuntimeException('TODO');
    }

    /**
     * @inheritDoc
     */
    public function getTransactionReference()
    {
        throw new RuntimeException('TODO');
    }
}
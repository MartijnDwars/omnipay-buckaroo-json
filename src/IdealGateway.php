<?php

namespace MartijnDwars\Omnipay\Buckaroo;

/**
 * Buckaroo iDeal Gateway
 */
class IdealGateway extends BuckarooGateway
{
    public function getName()
    {
        return 'Buckaroo iDeal';
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\MartijnDwars\Buckaroo\Message\IdealPurchaseRequest', $parameters);
    }
}


<?php

namespace SchulIT\KivutoBundle\Client;

use SchulIT\KivutoBundle\User\DataResolverInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class FakeKivutoClient extends AbstractKivutoClient {

    public function __construct($account, $endpoint, $secretKey, DataResolverInterface $dataResolver, RequestStack $requestStack) {
        parent::__construct($account, $endpoint, $secretKey, $dataResolver, $requestStack);
    }

    public function getRedirectUrl() {
        $requestData = $this->getRequestData();
        $url = sprintf('%s?%s', $this->endpoint, $requestData);

        return $url;
    }
}
<?php

namespace SchoolIT\KivutoBundle\Client;

use SchoolIT\KivutoBundle\User\DataResolverInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class FakeKivutoClient extends AbstractKivutoClient {

    public function __construct($endpoint, $secretKey, DataResolverInterface $dataResolver, RequestStack $requestStack) {
        parent::__construct($endpoint, $secretKey, $dataResolver, $requestStack);
    }

    public function getRedirectUrl() {
        $requestData = $this->getRequestData();
        $url = sprintf('%s?%s', $this->endpoint, $requestData);

        return $url;
    }
}
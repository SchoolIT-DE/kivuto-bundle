<?php

namespace SchulIT\KivutoBundle\Client;

use SchulIT\KivutoBundle\User\DataResolverInterface;
use Symfony\Component\HttpFoundation\RequestStack;

abstract class AbstractKivutoClient implements KivutoClientInterface {

    protected $endpoint;
    protected $secretKey;

    protected $dataResolver;
    protected $requestStack;

    public function __construct($endpoint, $secretKey, DataResolverInterface $dataResolver, RequestStack $requestStack) {
        $this->endpoint = $endpoint;
        $this->secretKey = $secretKey;

        $this->dataResolver = $dataResolver;
        $this->requestStack = $requestStack;
    }

    protected function getRequestData() {
        $data = [
            'account' => null,
            'username' => $this->dataResolver->getUsername(),
            'key' => $this->secretKey,
            'last_name' => mb_substr($this->dataResolver->getLastname(), 0, 50),
            'first_name' => mb_substr($this->dataResolver->getFirstname(), 0, 50),
            'shopper_ip' => $this->requestStack->getMasterRequest()->getClientIp(),
            'academic_statuses' => $this->dataResolver->getAcademicStatus(),
            'email' => mb_substr($this->dataResolver->getEmail(), 0, 100)
        ];

        return http_build_query($data);
    }

    public abstract function getRedirectUrl();
}
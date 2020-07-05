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
            'last_name' => $this->substr($this->dataResolver->getLastname(), 0, 50),
            'first_name' => $this->substr($this->dataResolver->getFirstname(), 0, 50),
            'shopper_ip' => $this->requestStack->getMasterRequest()->getClientIp(),
            'academic_statuses' => $this->dataResolver->getAcademicStatus(),
            'email' => $this->substr($this->dataResolver->getEmail(), 0, 100)
        ];

        return http_build_query($data);
    }

    protected function substr($string, $start, $length = null) {
        if(function_exists('mb_substr')) {
            return mb_substr($string, $start, $length);
        }

        return substr($string, $start, $length);
    }

    public abstract function getRedirectUrl();
}
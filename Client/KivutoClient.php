<?php

namespace SchulIT\KivutoBundle\Client;

use GuzzleHttp\Client;
use SchulIT\KivutoBundle\User\DataResolverInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpFoundation\RequestStack;

class KivutoClient extends AbstractKivutoClient {

    private $httpClient;
    private $logger;

    public function __construct($account, $endpoint, $secretKey, Client $httpClient, DataResolverInterface $dataResolver, RequestStack $requestStack, LoggerInterface $logger = null) {
        parent::__construct($account, $endpoint, $secretKey, $dataResolver, $requestStack);

        $this->httpClient = $httpClient;
        $this->logger = $logger ?? new NullLogger();
    }

    public function getRedirectUrl() {
        $requestData = $this->getRequestData();
        $response = $this->httpClient->post($this->endpoint, [
            'body' => json_encode($requestData),
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ]);

        $statusCode = $response->getStatusCode();
        $content = $response->getBody()->getContents();

        if($statusCode === 200) {
            return $content;
        }

        $this->logger
            ->critical(sprintf('Expected status code 200, got %d', $statusCode), [
                'response' => $response->getBody()
            ]);

        throw new KivutoException(
            sprintf('Expected status code 200 (got %d)', $statusCode)
        );
    }
}
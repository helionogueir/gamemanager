<?php

namespace module\main\driver;

use DomainException;
use GuzzleHttp\Client;
use module\main\usecase\TranslateToLanguage;

class ServiceClient
{

    private $client = null;

    public function __construct(string $servicename)
    {
        global $CFG;
        if (!empty($CFG->service) && !empty($CFG->service->{$servicename})) {
            $service = $CFG->service->{$servicename};
            if (!empty($service->uri) && !empty($service->port) && !empty($service->timeout)) {
                $this->client = new Client(Array(
                    'base_uri' => "{$service->uri}:{$service->port}",
                    'timeout' => $service->timeout
                ));
            }
        }
        if (!($this->client instanceof Client)) {
            $lang = (new TranslateToLanguage());
            throw (new DomainException($lang->translate('driver:service:notfound', 'main', array(
                'servicename' => $servicename
            ))));
        }
        return $this;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

}

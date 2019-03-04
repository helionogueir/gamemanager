<?php

namespace module\event\entity;

use Exception;
use module\main\Entity;
use module\main\driver\ServiceClient;
use module\main\driver\Authentication;

class Event_Person_PersonId implements Entity
{

    public function __construct()
    {
        return $this;
    }

    public function get(string $personid): array
    {
        $data = array();
        try {
            if (!empty($personid)) {
                if ($token = (new Authentication())->encode()) {
                    if ($client = (new ServiceClient('event'))->getClient()) {
                        $response = $client->get("/person/{$personid}", Array(
                            'headers' => Array(
                                'Content-Type' => 'application/json',
                                'Cache-Control' => 'no-cache',
                                'Authorization' => $token
                            )
                        ));
                        $metadata = json_decode($response->getBody()->getContents());
                        if (!empty($metadata->data) && is_array($metadata->data)) {
                            $data = $metadata->data;
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            // Put #analytics here!
        }
        return $data;
    }

}
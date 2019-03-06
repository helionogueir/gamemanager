<?php

namespace module\challenge\entity;

use module\main\Entity;
use module\main\driver\UserSession;
use module\main\driver\ServiceClient;
use module\main\driver\Authentication;

class Challenge_Group_GroupId_Match implements Entity
{

    public function __construct()
    {
        return $this;
    }

    public function get(int $groupid)
    {
        $data = null;
        if (!empty($groupid)) {
            if ($authorization = (new Authentication())->encode()) {
                if ($client = (new ServiceClient('challenge'))->getClient()) {
                    $response = $client->get("group/{$groupid}/match", Array(
                        'headers' => Array(
                            'Content-Type' => 'application/json',
                            'Cache-Control' => 'no-cache',
                            'Authorization' => $authorization
                        ),
                        'body' => json_encode(array(
                            'personid' => (new UserSession())->get()->personid
                        ))
                    ));
                    $metadata = json_decode($response->getBody()->getContents());
                    if (!empty($metadata->data) && is_array($metadata->data)) {
                        $data = $metadata->data;
                    }
                }
            }
        }
        return $data;
    }

}

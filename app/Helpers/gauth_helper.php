<?php
function client()
{
    $data = file_get_contents(ROOTPATH . "config.json");
    $config = json_decode($data, TRUE);
    $client = new Google_Client();
    $client->setClientId($config['gauth']['id']);
    $client->setClientSecret($config['gauth']['secret']);
    $client->setAccessType("offline");
    $client->setIncludeGrantedScopes(true);
    $client->addScope('email');
    $client->addScope('profile');
    return $client;
}

function Oauth2($client)
{
    $service = new \Google\Service\Oauth2($client);
    return $service;
}

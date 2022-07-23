<?php
function ambilconfig()
{
    $data = file_get_contents(ROOTPATH . "config.json");
    $config = json_decode($data, TRUE);
    return $config;
}
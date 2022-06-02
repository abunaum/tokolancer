<?php
function getadmin()
{
    $role = new \App\Models\Role();
    $getrole = $role->where('rules', 1)->findAll();
    return $getrole;
}
function verifadmin()
{
    helper(['user']);
    $role = new \App\Models\Role();
    $getrole = $role->where('iduser', user()->id)->first();
    $rules = $getrole['rules'];
    if($rules == 1){
        $hasil = 'valid';
    } else{
        $hasil = 'invalid';
    }

    return $hasil;
}

<?php
function user()
{
    $user = new \App\Models\User();
    $getuser = $user->asObject()->where('id', session()->get('id'))->first();

    return $getuser;
}

<?php
function cek_login()
{
    if(session('logged_in') != true){
        return false;
    }
    return true;
}
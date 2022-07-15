<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Google_Client;

class Auth extends BaseController
{
    public function login()
    {
        if ($this->request->getVar('url')){
            $redirect = [
                'url'  => $this->request->getVar('url'),
            ];
            session()->set($redirect);
        }
        helper('gauth');
        $client = client();
        $client->setRedirectUri(base_url('auth/cek'));
        $url = $client->createAuthUrl();
        return redirect()->to($url);
    }
    public function cek()
    {
        $code = $this->request->getVar('code');
        helper('gauth');
        $client = client();
        $client->setRedirectUri(base_url('auth/cek'));
        $token = $client->fetchAccessTokenWithAuthCode($code);
        if (!isset($token['error'])) {
            $google_service = Oauth2($client);
            session()->set('gauth_token', $token['access_token']);
            $data = $google_service->userinfo->get();
            $user = new \App\Models\User();
            $getuser = $user->where('email', $data['email'])->first();
            if (!$getuser) {
                $user->save([
                    'gauthid' => $data['id'],
                    'email' => $data['email'],
                    'fullname' => $data['name'],
                    'user_image' => $data['picture'],
                    'status' => 1,
                ]);
                $iduser = $user->getInsertID();
                $this->role->save([
                    'iduser' => $iduser,
                    'rules' => 2,
                ]);
                $newdata = [
                    'id' => $iduser,
                    'logged_in' => true,
                ];

                session()->set($newdata);
            } else {
                $user->update($getuser['id'],[
                    'gauthid' => $data['id'],
                    'fullname' => $data['name'],
                    'user_image' => $data['picture']
                ]);
                $newdata = [
                    'id' => $getuser['id'],
                    'logged_in' => true,
                ];

                session()->set($newdata);
            }
            if (session('url')){
                $redirect = session('url');
                session()->remove('url');
                return redirect()->to($redirect);
            } else {
                return redirect()->to(base_url());
            }
        } else {
            $url = $client->createAuthUrl();
            return redirect()->to($url);
        }
    }
    public function logout(){
        session()->destroy();
        return redirect()->to(base_url());
    }
}

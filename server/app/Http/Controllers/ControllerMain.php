<?php

namespace App\Http\Controllers;
use App\Vk;
use App\ApiVk;

class ControllerMain extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $api;

    public function __construct()
    {
        $this->api = new ApiVk();
        $this->vk = new Vk;
    }

    public function main() {
        if(isset($_COOKIE['key'])) {
            $vkRes = $this->vk->where('key', $_COOKIE['key'])->first();
            if(isset($vkRes)){
                $user = $this->api->getUser($vkRes);
                $friends = $this->api->getFriends($vkRes);
                if(!$user['error'] && !$friends['error']){
                    return view('index', [
                            'user' => $user['data']['response'][0], 
                            'friends' => $friends['data']['response']['items']
                        ]);
                }
            }        
        }
        $url = $this->api->getUrlAuthorize();
        return view('aut', ['url' => $url]);
    }

    public function authenticate() {
        if(isset($_GET['code'])) {
            $token = $this->api->getToken($_GET['code']);
            if(!$token['error']) {
                $tokenData = $token['data'];
                $this->vk->where('user_id', $tokenData['user_id'])->first();
                $key = md5(uniqid(rand(),1));
                $this->vk->user_id = $tokenData['user_id'];
                $this->vk->access_token = $tokenData['access_token'];
                $this->vk->key = $key;
                $this->vk->save();
                setcookie("key", $key, time()+60*60*24*30*12);
                return redirect('/');
            }
        }
        setcookie("key", '', -1);
        return redirect('/');
    }
}

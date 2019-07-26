<?php

namespace App;

class ApiVk
{
    private $client_id, $client_secret, $redirect_uri;
    private $urlAuthorize, $urlToken, $urlUsersGet, $urlFriendsGet;

    public function __construct()
    {
        $this->client_id = '7070399';
        $this->client_secret = 'jFwvX55LOrzGdRaXHn0z';
        $this->redirect_uri = 'http://open.zhna.ru/aut';
        $this->urlAuthorize = 'https://oauth.vk.com/authorize?';
        $this->urlToken = 'https://oauth.vk.com/access_token?';
        $this->urlUsersGet = 'https://api.vk.com/method/users.get?';
        $this->urlFriendsGet = 'https://api.vk.com/method/friends.get?';
    }

    private function url_get_contents ($Url) {
        if (!function_exists('curl_init')){ 
            die('CURL is not installed!');
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    private function isError($res) {
        if(isset($res['error'])) {
            return [
                'error' => true,
                'data' => $res
            ];
        }else{
            return [
                'error' => false,
                'data' => $res
            ];
        }
    }

    private function get($params, $url) {
        $res = $this->url_get_contents($url);
        $res = json_decode($res, true);
        return $this->isError($res);
    }

    public function getToken($code) {
        $params = [
        'client_id' => $this->client_id,
        'client_secret' => $this->client_secret,
        'redirect_uri' => $this->redirect_uri,
        'code' => $code
        ];
        $url = $this->urlToken.http_build_query($params);
        return $this->get($params, $url);
    }

    public function getUser($vkData) {
        $params = array(
            'uids' => $vkData['user_id'],
            'fields' => 'first_name,last_name,photo_big',
            'access_token' => $vkData['access_token'],
            'v' => '5.101'
        );
        $url = $this->urlUsersGet.http_build_query($params);
        return $this->get($params, $url);
    }

    public function getFriends($vkData) {
        $params = array(
            'user_id' => $vkData['user_id'],
            'order' => 'random',
            'count' => '5',
            'fields' => 'nickname,domain,photo_200_orig',
            'access_token' => $vkData['access_token'],
            'v' => '5.101'
        );
        $url = $this->urlFriendsGet.http_build_query($params);
        return $this->get($params, $url);
    }

    public function getUrlAuthorize() {
        $params = [
            'client_id' => $this->client_id,
            'display' => 'page',
            'redirect_uri' => $this->redirect_uri,
            'scope' => 'friends,offline',
            'response_type' => 'code',
            'v' => '5.101',
        ];
        $url = $this->urlAuthorize.http_build_query($params);
        return $url;
    }
}
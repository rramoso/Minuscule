<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('setOauthSession')) {

    /**
     * Sets an oAuth array in the user's session (encrypted)
     * @param $provider
     * @param $array
     */
    function setOauthSession($provider, $array)
    {
        $CI =& get_instance();
        $CI->input->set_cookie([
            'name' => $provider,
            'value' => $CI->encrypt->encode(json_encode($array)),
            'expire' => '259200'
        ]);
        return $CI->input->cookie($provider);
    }
}

if (!function_exists('getOauthSession')) {
    /**
     * Gets an oAuth array from the user's session (decrypt)
     * @param $provider
     * @return mixed
     */
    function getOauthSession($provider = 'tumblr')
    {
        $CI =& get_instance();
        $json = json_decode($CI->encrypt->decode($CI->input->cookie($provider)));
        return $json && $json->token && $json->secret ? $json : false;
    }
}

if (!function_exists('createInstanceTumblr')) {
    function createInstanceTumblr($keyPair = false)
    {
        $CI =& get_instance();
        if (!$keyPair) {
            return false;
        }
        $CI->load->config('api_keys', true);
        $auth = $CI->config->item('api_keys')['tumblr'];
        return new Tumblr\API\Client($auth['key'], $auth['secret'], $keyPair->token, $keyPair->secret);
    }
}


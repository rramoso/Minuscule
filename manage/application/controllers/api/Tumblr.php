<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Tumblr
 *
 * Handles interations between tumblr and its API. By default, sends user to Tumblr to renew a token.
 *
 * @author: Joseph Schultz - schultzjosephj@gmail.com
 * @version: 1.0.0
 * @modified: 10/28/2015
 */
class Tumblr extends MY_Controller
{
    public function __construct()
    {
        parent::__construct(false);
        if (!$this->tumblr) {
            $this->provider = "tumblr";
            $this->load->config('api_keys', true);
            $this->auth = $this->config->item('api_keys')[$this->provider];
            $this->client = new Tumblr\API\Client($this->auth['key'], $this->auth['secret']);
        }
    }

    /**
     * Default Page for Tumblr API
     *
     * Sets up API Object, sends uses Tumblr App Key and Secret to generate
     * a request token, uses request token to forward user on to Tumblr for a
     * Client Key and Secret (calls $this->callback())
     */
    public function index()
    {
        if (!$this->session->userdata('is_invited')) {
            redirect('login');
        }
        if (getOauthSession($this->provider) || $this->tumblr) {
            redirect('dashboard');
        }
        $requestHandler = $this->client->getRequestHandler();
        $requestHandler->setBaseUrl('https://www.tumblr.com/');
        // start the old gal up
        $resp = $requestHandler->request('POST', 'oauth/request_token', array());

        // get the oauth_token
        $out = $result = $resp->body;
        $data = array();
        parse_str($out, $data);

        // tell the user where to go
        $this->session->set_userdata('request_oauth_token', $data['oauth_token']);
        $this->session->set_userdata('request_oauth_token_secret', $data['oauth_token_secret']);
        redirect('https://www.tumblr.com/oauth/authorize?oauth_token=' . $data['oauth_token']);
    }

    /**
     * This function is called by redirecting from Tumblr. Creates a cookie for us
     * to create the API Object.
     *
     * @throws Exception
     */
    public function callback()
    {
        $this->load->model('user_model');
        $this->client = new Tumblr\API\Client($this->auth['key'], $this->auth['secret'], $this->session->userdata('request_oauth_token'), $this->session->userdata('request_oauth_token_secret'));

        $this->session->unset_userdata('request_oauth_token');
        $this->session->unset_userdata('request_oath_token_secret');

        $requestHandler = $this->client->getRequestHandler();
        $requestHandler->setBaseUrl('https://www.tumblr.com/');
        $data = $this->input->get();
        $verifier = $data['oauth_verifier'];

        // exchange the verifier for the keys
        $resp = $requestHandler->request('POST', 'oauth/access_token', array('oauth_verifier' => $verifier));
        $out = $result = $resp->body;
        $data = array();
        parse_str($out, $data);

        $token = $data['oauth_token'];
        $secret = $data['oauth_token_secret'];

        $client = new Tumblr\API\Client($this->auth['key'], $this->auth['secret'], $token, $secret);

        if ($name = $client->getUserInfo()->user->name) {
            $user = $this->user_model->get(array('username' => $name));
            if ($user) {
                $this->user_model->update($user->id, array(
                    'token' => $token,
                    'secret' => $secret,
                    'modified' => time()
                ));
            } else {
                $this->user_model->insert(array(
                    'username' => $name,
                    'token' => $token,
                    'secret' => $secret,
                    'modified' => time(),
                    'created' => time()
                ));
            }
        } else {
            throw new Exception("Cannot create Tumblr Object");
        }

        setOauthSession($this->provider, array('token' => $token, 'secret' => $secret));
        redirect('dashboard');
    }

    public
    function post($blog = false)
    {
        $this->tumblr->createPost($blog, [
            'type' => 'text',
            'state' => 'published',
            'tags' => 'tags',
            'title' => 'This is a test sent from Minuscule',
            'data' => [],
            'body' => '<img src=' . site_url('api/minuscule/beacon/schultzie') . '/>',
        ]);
    }

}
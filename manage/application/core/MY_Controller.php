<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class MY_Controller
 *
 * Extension of CI_Controller, this controller should be used as an extension
 * if the child controller is expected to use external API calls.
 *
 * @property Advertisement_model advertisement_model
 * @property Api_model api_model
 * @property Blog_model blog_model
 * @property Category_model category_model
 * @property Cron_model cron_model
 * @property File_model file_model
 * @property Login_model login_model
 * @property Site_model site_model
 * @property Stat_model stat_model
 * @property User_model user_model
 * @property Message message
 * @property CI_Output output
 * @property CI_Input input
 * @property CI_Loader load
 * @property CI_Email email
 *
 * @author: Joseph Schultz
 * @version: 1.0.1
 * @modifier: 12/16/2015
 */
class MY_Controller extends CI_Controller
{

    protected $auth;
    protected $paths;

    /**
     * THIS FUNCTION MUST BE CALLED BY THE CHILD.
     *
     * Loads in API Keys and creates API Objects that can be called based on their
     * provider names ($this->tumblr). Note that the $this->$provider variable will
     * be created REGARDLESS of having an object or not. Object will default to FALSE.
     * (which will be useful for redirects later).
     */
    public function __construct($check_session = true)
    {
        parent::__construct();
        $this->load->config('api_keys', true);
        $this->load->model('user_model');
        $this->auth = $this->config->item('api_keys')['tumblr'];
        $providers = $this->config->item('api_keys')['providers'];
        foreach ($providers as $provider) {
            $keyPair = getOauthSession($provider);
            if ($keyPair) {
                $this->$provider = call_user_func("createInstance" . ucfirst($provider), $keyPair);
            }
        }
        if ($this->tumblr) {
            $this->user = $this->user_model->get(array('username' => $this->tumblr->getUserInfo()->user->name));
        }
        $base = explode('system', BASEPATH)[0];
        $this->paths = json_decode(json_encode([
            'images' => $base . "assets/images/",
            'uploads' => $base . "assets/uploads/"
        ]));

        if ($check_session && !$this->tumblr) {
            redirect('login');
        }
    }

    /**
     * @param String|bool $to
     * @param String|bool $subject
     * @param String|bool $message
     * @param String[]|bool $attachments
     * @return bool
     */
    public function send_email($to = false, $subject = false, $message = false, $attachments = false)
    {
        $this->load->library('email');
        $this->email->from('no-reply@minuscule.io', 'Minuscule Networks');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->mailtype = "html";
        $this->email->message($message);

        return $this->email->send();
    }
}
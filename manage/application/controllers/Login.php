<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Login
 * @property CI_Output output
 */
class Login extends MY_Controller
{

    public function __construct()
    {
        parent::__construct(false);
        $this->load->model('site_model');
        $this->load->model('category_model');
        $this->load->model('login_model');
    }

    /**
     * Handles logging in, registration, and first-login views.
     *
     * @modified 12/14/2015
     * @return views
     */
    public function index()
    {
        if ($this->input->post()) {
            if ($this->login_model->login()) {
                $this->message->send('Welcome back!', 'success');
            } else {
                $this->message->send('Wrong Username or Password, please try again.', 'error');
            }
        } else {
            $hdata['hide_menu'] = true;

            $data['first_login'] = $this->load->view('login/partials/first_login', false, true);
            $data['login'] = $this->load->view('login/partials/login', false, true);
            $data['register'] = $this->load->view('login/partials/register', false, true);

            $this->load->view('common/header', $hdata);
            $this->load->view('login/index', $data);
            $this->load->view('common/footer');
        }
    }

    /**
     * Handles the invitation code generator.
     * @return CI_Output
     */
    public function invitation()
    {
        $out = [];
        if ($this->input->post('code') == "xqy2wod") {
            $this->session->set_userdata('is_invited', true);
            $out = ['status' => 'success', 'message' => site_url('api/tumblr')];
        } else {
            $out = ['status' => 'error', 'message' => 'Invalid Invitation Code'];
        }
        return $this->output->set_content_type('application/json')
            ->set_output(json_encode($out));
    }

    /**
     * Reset function called from form
     */
    public function reset()
    {
        if ($this->user_model->reset()) {
            $this->message->send('Successfully reset password, please try logging in again', 'success', 'login');
        } else {
            $this->message->send('Error resetting password, please try again', 'error', 'login/forgot/' . $this->input->post('token'));
        }
    }

    /**
     * Both an AJAX and normal function generates token via ajax, takes you to form with token.
     * @param bool $token
     * @return CI_Output|void
     */
    public function forgot($token = false)
    {
        if ($token) {
            return $this->forgot_token($token);
        } else {
            return $this->forgot_ajax();
        }
    }

    /**
     * Shows forgotten password / reset page
     * @param $token
     */
    private function forgot_token($token)
    {
        $user = $this->user_model->get_by_reset_token($token);

        if (!$user) {
            $this->message->send('Token is either non-existent or invalid, please retry your reset request.', 'error', 'login');
        }
        $this->load->view('common/header');
        $this->load->view('login/reset', ['user' => $user, 'token' => $token]);
        $this->load->view('common/footer');
    }

    /**
     * Generates token for return
     * @return CI_Output
     */
    private function forgot_ajax()
    {
        $out = [];
        if (($email = $this->input->post('email'))) {
            $user = $this->user_model->get_user_by_email($email);
            if ($user) {
                $token = $this->login_model->forgot($user->id);
                $this->send_email($email, "Forgot Password", $this->load->view('email/forgot_password', ['token' => $token], true));
                $out = ['status' => 'success', 'message' => 'Email will be sent to you to reset your password'];
            } else {
                $out = ['status' => 'error', 'message' => 'Unable to find a user matching that email'];
            }
        } else {
            $out = ['status' => 'error', 'message' => 'No email supplied.'];
        }
        return $this->output->set_content_type('application/json')
            ->set_output(json_encode($out));
    }

    /**
     * Registers a new user
     */
    function register()
    {
        if (!$this->input->post() || !$this->input->post('first_name') || !$this->input->post('last_name')) {
            echo false;
        }

        $user = $this->user_model->update($this->user->id, array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
            'modified' => time(),
        ));

        if ($user) {
            $this->message->send('Thanks for registering!', 'success');
        } else {
            $this->message->send('There was an error processing your registration, please try again later', 'error');
        }

    }

    /**
     * Destroys user's session and login cookie.
     */
    function logout()
    {
        $this->load->helper('cookie');
        delete_cookie("tumblr");
        $this->session->sess_destroy();
        redirect();
    }

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Login_model
 */
class Login_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Logs a User In.
     * @return bool
     */
    function login()
    {
        $this->db->select('user.*')->from('user');
        $this->db->like('email', $this->input->post('user'));
        $this->db->or_like('username', $this->input->post('user'));
        $exists = $this->db->get();
        if ($exists && $exists->num_rows() == 1) {
            $exists = $exists->row();
            $get_user = $this->db->get_where('user', array('id' => $exists->id, 'password' => md5($this->input->post('password'))));
            if ($get_user && $get_user->num_rows() == 1) {
                $user = $get_user->row();
                setOauthSession('tumblr', array('token' => $user->token, 'secret' => $user->secret));
                $this->message->send('Welcome back!', 'success', '');
                return true;
            } else {
                $this->message->send('Wrong Username/Password combination, try again', 'error');
                return false;
            }
        } else {
            $this->message->send('Username/Email does not exist in the system.', 'error');
            return false;
        }
    }

    /**
     * Sets a forgot password token for a user
     * @param bool $user_id
     * @return mixed
     */
    function forgot($user_id = false)
    {
        $this->db->delete('user_reset', ['user_id' => $user_id]);
        $token = $this->generate_token(32);
        $this->db->insert('user_reset', [
            'user_id' => $user_id,
            'token' => $token,
            'expire' => strtotime("+3 days"),
        ]);
        return $token;
    }

    private function generate_token($length)
    {
        return substr(sha1(str_shuffle("abcdefghijklmnopqrstuvwzyz0123456789-=!@#$%^&*()") . microtime()), 0, $length);
    }
}
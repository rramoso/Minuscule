<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class User_model
 *
 * Handles interations with the User Database
 * @author: Joseph Schultz - schultzjosephj@gmail.com
 * @version: 1.0.0
 * @modified: 11/6/2015
 */
class User_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Gets a user by their email address
     * @param $email
     * @return bool
     */
    public function get_user_by_email($email)
    {
        return ($r = $this->db->get_where('user', ['email' => $email])) && $r->num_rows() ? $r->row() : false;
    }

    /**
     * Gets a user by their reset token.
     * @param $token
     * @return bool
     */
    public function get_by_reset_token($token)
    {
        $r = $this->db->select('user.*')->from('user')
            ->join('user_reset', 'user_reset.user_id = user.id', 'left')
            ->where('user_reset.token', $token)
            ->where('user_reset.expire >=', time())
            ->get();

        return $r && $r->num_rows() ? $r->row() : false;
    }

    /**
     * Resets a User's password
     * @return bool|object
     */
    public function reset()
    {
        $token = $this->input->post('token');
        $password = $this->input->post('password');
        $user = $this->get_by_reset_token($token);
        if ($user) {
            $this->db->delete('user_reset', ['token' => $token]);
            return $this->db->update('user', ['password' => md5($password)], ['user.id' => $user->id]);
        }
        return false;
    }

    /**
     * Flips the first_login flag
     * @param bool $user_id
     * @return bool
     */
    function visited($user_id = false)
    {
        if (!$user_id) {
            return false;
        }
        return $this->db->update('user', ['first_login' => 0], ['id' => $user_id]);
    }
}
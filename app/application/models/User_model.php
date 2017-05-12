<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class User_model extends CI_Model
{

    public function __construct(){
        $this->load->database();
    }

    public function createUser($avatar_id){
        //avatar, username, password, email,first_name,last_name,phonenumber,websitelink
        
        
            $data = array(
            'avatar' => $avatar_id,
            'username' => $this->input->post('newuser'),
            'password' => md5($this->input->post('password1')),
            'email' => $this->input->post('email'),
            'first_name' => $this->input->post('firstname'),
            'last_name' => $this->input->post('lastname'),
            'phonenumber' => $this->input->post('phonenumber'),
            'websitelink' => $this->input->post('website')
            );

        $this->db->insert('user', $data);
        $newdata = array(
                   'user_id'  => $this->db->insert_id(),
                   'logged_in' => TRUE
               );

        $this->session->set_userdata($newdata);
    }

    public function isUser($email,$username){
        
        $user = $this->db->get_where('user', array('username' => $username));
        $mail = $this->db->get_where('user', array('email' => $email));
        if(sizeof($user->result()) > 0 || sizeof($mail->result()) > 0){
            return 1;
        }
        else{
            return 0;
        }
        
    }
    public function getUserByEmail($email){
        $user = $this->db->get_where('user', array('email' => $email));
        if(sizeof($user->result()) > 0){
            return $user->result()[0];
        }
        return NULL;
    }
    public function getUserById($id){
        $user = $this->db->get_where('user', array('id' => $id));
        if(sizeof($user->result()) > 0){
            return $user->result()[0];
        }
        return NULL;
    }
}

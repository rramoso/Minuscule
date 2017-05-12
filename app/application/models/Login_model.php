<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Login_model
 */
class Login_model extends CI_Model {

        public function __construct()
        {
            $this->load->database();
            $this->load->model('artist_model');

            $this->load->model('curator_model');
        }

        public function isUser($username,$pass){
        
		if(strpos($username,"@") !== false){
        		$user = $this->db->get_where('user', array('email' => $username));
        	} else{
        		$user = $this->db->get_where('user', array('username' => $username));
        	}
        	foreach ($user->result() as $row)
			{
			    if($row->password === md5($pass)){
			    	return $row->id;
			    }
			    return 0;
			}
        }
        
        public function emailExist($email){

            $user = $this->db->get_where('user', array('email' => $email));
            if(sizeof($user->result()) > 0){
                return true;
            }
            return false;
        }
         public function resetPassword($email,$newpassword){
            
            $this->db->query("UPDATE `user` SET `password` = '".(string)md5($newpassword)."' WHERE `email` = '".$email."'");
            
        }

        public function hasToken($username){

            if(strpos($username,"@") !== false){
        		$user = $this->db->get_where('user', array('email' => $username));
        	} else{
        		$user = $this->db->get_where('user', array('username' => $username));
        	}
            foreach ($user->result() as $row)
            {   
            	if($this->artist_model->isArtist($row->id) || $this->curator_model->isCurator($row->id)){
            		return False;
            	}
                if($row->token != ''){
                	    return True;
                	}
                return False;
            }
        }
        
}
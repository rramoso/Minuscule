<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Category_model extends CI_Model
{

    public function __construct(){
        $this->load->database();
    }

    public function getCategories(){
        return $this->db->get("category")->result();
    }

    public function getCategoryByInitials($initials){

		$cat = $this->db->get_where("category",array('initials'=>$initials))->result();
		if(sizeof($cat)){
			return $cat[0]->name;
		} 	
		return $cat;
    }
}


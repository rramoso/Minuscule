<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Curator_model extends CI_Model
{

    public function __construct(){
        $this->load->database();
        $this->load->model('artist_model');
    }

    public function createCurator($user_id){
        
            echo $user_id;
            $original_content = 0;
            $adheres_tumblr = 0;
            if(!is_null($this->input->post('original_content')))
                $original_content = 1;
            if(!is_null(($this->input->post('adheres_tumblr'))))
                $adheres_tumblr = 1;
            $data = array(
            'websitename' => $this->input->post('curator_website'),
            'originalContent' => $original_content,
            'adheresTumblr' => $adheres_tumblr,
            'user' => $user_id
            );

        $this->db->insert('curator', $data);
    }

    public function getCuratorByUserId($username){

        
        $curator = $this->db->get_where('curator',array('user'=> $username));
        
        if(sizeof($curator->result()) > 0)
        {
        	return $curator->result()[0]->id;
        }
        else{
        	return 0;
        }
    }


    public function addFavoriteArtist($curator,$artist){
        $this->db->insert('curator_artist',array('curator'=>$curator,'artist'=> $artist));
    }

    public function isFollowing($curator,$artist){

        $relation = $this->db->get_where('curator_artist',array("curator"=> $curator,'artist' => $artist));
        if(sizeof($relation->result()) > 0){
            return True;
        }
        return False;
    }


    public function getArtists($limit,$start)
    {   
        $this->db->limit($limit, $start);
        $artists = $this->db->get('artist');
        $result = array();
        foreach ($artists->result() as $a) {
            $aux = array('artist' => $a);
            $user = $this->db->get_where('user',array('id'=>$a->user));
            $aux['user'] = $user->result()[0];

            $this->db->select('category');
            $query = $this->db->get_where('artist_category',array('artist'=>$aux['artist']->id));
            $categories = $query->result();
            
            $aux['categories'] = array();
            foreach ($categories as $cat) {
                $category_initial = $this->db->get_where('category',array('id'=>$cat->category))->result()[0]->initials;
                array_push($aux['categories'], $category_initial);

            }
            array_push($result, $aux);
        }
        return $result;
    }

    public function artistsByCategory($category){
        $result = array();
        if(!is_null($category)){
            
            $cat = $this->db->get_where('category',array('initials'=> strtoupper($category)))->result();
            if(sizeof($cat)>0){
                
                $artists_id = $this->db->get_where('artist_category',array('category'=>$cat[0]->id))->result();
                
                $artists = array();
                foreach ($artists_id as $id) {
                    $artist = $this->artist_model->getArtistByArtistID($id->artist);
                    
                    array_push($result, $artist);
                }
            }
        }
        return  $result;
    }
	public function isCurator($user_id){
	        $resp = $this->db->get_where('curator',array('user'=>$user_id));
	        if (sizeof($resp->result())>0){
	            return True;
	        }
	        return False;
	    }

    public function getFavorites($curator_id){

        $result = array();
        $artists_id = $this->db->get_where('curator_artist',array('curator'=>$curator_id))->result();
            
        $artists = array();
        foreach ($artists_id as $id) {
            $artist = $this->artist_model->getArtistByArtistID($id->artist);
            array_push($result, $artist);
        }
        return $result;
    }
}

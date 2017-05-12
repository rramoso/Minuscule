<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Artist_model extends CI_Model
{

    public function __construct(){
        $this->load->database();
    }

    public function createArtist($user_id){
        //`nickname`, `manifesto`, `user`
        $data = array(
        'nickname' => $this->input->post('artist_nickname'),
        'manifesto' => $this->input->post('artist_manifesto'),
        'user' => $user_id,
        );

        $sql = $this->db->set($data)->get_compiled_insert('artist');
        $this->db->query($sql);
        $artist_id = $this->db->insert_id();
        
        
        if(!empty($_POST['check_list'])) {
            foreach($_POST['check_list'] as $check)
            {
                $this->db->insert('artist_category',array('artist'=> $artist_id,'category'=>$check));
            }
        }
    }

    public function artistArtwork($user_id,$work_id){
        $data = array(
            'artist' => $user_id,
            'artwork' => $work_id
            );

        $this->db->insert('artist_artwork', $data);
    }

    public function getArtistArtwork($user_id, $limit){
        
        $this->db->limit($limit,0);
        $works = $this->db->get_where('artist_artwork', array('artist' => $user_id));
        $result = array();
        foreach ($works->result() as $work) {
            array_push($result, $this->db->get_where('file', array('id' => $work->artwork),1,0)->result()[0]);
        }
        return $result;
    }

    public function isArtist($user_id){
        $resp = $this->db->get_where('artist',array('user'=>$user_id));
        if (sizeof($resp->result())>0){
            return True;
        }
        return False;
    }

    public function totalCount(){
        return $this->db->count_all("artist");
    }

    public function getArtistByUserID($user_id){
        $artist = $this->db->get_where('artist', array('user' => $user_id));
        $user = $this->db->get_where('user', array('id' => $user_id));
        $resp = array();
        foreach ($artist->result() as $row) {
            $resp['id'] = $row->id;
            $resp['nickname'] = $row->nickname;
            $resp['manifesto'] = $row->manifesto;
        }
        foreach ($user->result() as $row) {
            $resp['name'] = $row->first_name ." ".$row->last_name;
            $resp['avatar_id'] = $row->avatar;
        }

        if(!is_null($resp['avatar_id'])){
            $file = $this->db->get_where('file', array('id' =>$resp['avatar_id']));
            foreach ($file->result() as $row) {
            $resp['avatar'] = $row->name;
            }
            $query = $this->db->query('SELECT * FROM file WHERE id = '.$resp['avatar_id']);
            $resp['avatar'] = $query->result_array()[0]['name'];
        }
        else {
            $resp['avatar'] = '';
        } 
        return $resp;
    }

    public function getArtistByArtistID($artist_id){
        $artist = $this->db->get_where('artist', array('id' => $artist_id));
        $user = $this->db->get_where('user', array('id' => $artist->result()[0]->user));
        
        $resp = array();
        foreach ($artist->result() as $row) {
            $resp['id'] = $row->id;
            $resp['nickname'] = $row->nickname;
            $resp['manifesto'] = $row->manifesto;
        }
        foreach ($user->result() as $row) {
            $resp['name'] = $row->first_name ." ".$row->last_name;
            $resp['avatar_id'] = $row->avatar;
        }

        if(!is_null($resp['avatar_id'])){
            $file = $this->db->get_where('file', array('id' =>$resp['avatar_id']));
            foreach ($file->result() as $row) {
            $resp['avatar'] = $row->name;
            }
            $query = $this->db->query('SELECT * FROM file WHERE id = '.$resp['avatar_id']);
            $resp['avatar'] = $query->result_array()[0]['name'];
        }
        else {
            $resp['avatar'] = '';
        } 
        return $resp;
    }
}


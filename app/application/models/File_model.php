<?php
class File_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
        }

        public function insertFile($avatar,$description){
            $data = array(
                'name' => $avatar,
                'description' => $description
            );

            $sql = $this->db->set($data)->get_compiled_insert('file');
            $this->db->query($sql);
            return $this->db->insert_id();
        }

        public function getFileById($file_id){
            
            $data = array(
                'id'=> $file_id
            );

            $file = $this->db->get_where('file',$data);
            foreach ($file->result() as $row) {
                return $row;
            }
            
        }
}
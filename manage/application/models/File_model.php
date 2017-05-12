<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class File_model
 * @author: Joseph Schultz - schultzjosephj@gmail.com
 * @version: 1.0.0
 * @modified: 1/9/2016
 */
class File_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Saves a file to the database
     * @param bool $data
     */
    public function save($data = false)
    {
        if (!$data || !is_array($data)) {
            return false;
        }
        return $this->db->insert('file', $data) ? $this->db->insert_id() : false;
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Api_model
 *
 * Handles interations with the API Database
 * @author: Joseph Schultz - schultzjosephj@gmail.com
 * @version: 1.0.0
 * @modified: 10/28/2015
 */
class Api_model extends MY_Model
{

    public function log($data = false)
    {
        return $this->db->insert('log', $data);
    }

    public function link($data = false)
    {
        return $this->db->insert('link', $data);
    }
}
<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class MY_Model
 *
 * This is a general database interaction model extraction. Allows for basic use of a database
 * for the children of this model. Provides a basic interface for all members of child classes,
 * and uses the name of the class to determine the table name.
 *      i.e., User_model will use the 'user' table.
 * Models can also call subtable() to add on an associative tag to database calls
 *      i.e., subtable('permissions') will make calls go to the 'user_permissions' table.
 *
 * Note that most of these methods will take a parameter $param as an array or id, in which you can
 * either specify an array as where or just use an id.
 *
 * @property Advertisement_model advertisement_model
 * @property Api_model api_model
 * @property Blog_model blog_model
 * @property Category_model category_model
 * @property Cron_model cron_model
 * @property File_model file_model
 * @property Login_model login_model
 * @property Site_model site_model
 * @property Stat_model stat_model
 * @property User_model user_model
 * @property Message message
 * @property CI_Output output
 * @property CI_Input input
 * @property CI_Loader load
 * @property CI_Email email
 * @property CI_DB_query_builder $db
 * 
 * @author: Joseph Schultz (schultzjosephj@gmail.com)
 * @version: 1.0.3
 * @modified: 1/9/2016
 */
class MY_Model extends CI_Model
{

    private $subtable, $base_table, $table;
    protected $paths;
    protected $auth, $user;

    function __construct($load_tumblr = false)
    {
        parent::__construct();
        $this->load->config('api_keys', true);
        $this->auth = $this->config->item('api_keys')['tumblr'];
        $this->load->model('user_model');
        $providers = $this->config->item('api_keys')['providers'];
        if ($load_tumblr) {
            foreach ($providers as $provider) {
                $keyPair = getOauthSession($provider);
                $this->$provider = call_user_func("createInstance" . ucfirst($provider), $keyPair);
            }
            if ($this->tumblr) {
                $this->user = $this->db->get_where('user', array('username' => $this->tumblr->getUserInfo()->user->name))->row();
            }
        }
        $this->subtable = null;
        $this->base_table = strtolower(explode('_', get_class($this))[0]);
        $this->table = $this->base_table;

        $base = explode('system', BASEPATH)[0];
        $this->paths = json_decode(json_encode([
            'images' => $base . "assets/images/",
            'uploads' => $base . "assets/uploads/"
        ]));
    }

    /**
     * Sets a subtable for this class (table_subtable in the database)
     * @param bool|false $name
     * @return array|bool|string
     */
    function subtable($name = false)
    {
        if (!$name) {
            return false;
        }
        $this->subtable = $name;
        $this->table = $this->table . "_" . $this->subtable;
        return $this->table;
    }

    /**
     * Sets to the original base table name
     * @return array
     */
    function clear_subtable()
    {
        $this->table = $this->base_table;
        return $this->table;
    }

    /**
     * Get a single element returns a row.
     * @param bool|false $param
     * @return bool
     */
    function get($param = false)
    {
        if (!$param) {
            return false;
        }
        if (is_array($param)) {
            $this->db->where($param);
        } else {
            $this->db->where('id', $param);
        }
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $r = $this->db->get($this->table);

        return $r->num_rows() == 1 ? $r->row() : false;
    }

    /**
     * Gets a resultset of elements, takes a modifier array (where) and a limit.
     * @param bool|false $m
     * @param bool|false $limit
     */
    function get_all($where = false, $limit = false)
    {
        if ($where && is_array($where)) {
            $this->db->where($where);
        }
        if ($limit) {
            $this->db->limit($limit);
        }
        $this->db->order_by('id', 'desc');
        $r = $this->db->get($this->table);
        return $r->num_rows() > 0 ? $r : false;
    }

    /**
     * Updates a specific id with an associative array.
     * @param bool|false $param
     * @return bool
     */
    function update($id = false, $update = false)
    {
        if (!$update || !is_array($update)) {
            return false;
        }
        $this->db->where('id', $id);
        return $this->db->update($this->table, $update);
    }


    /**
     * Removes a specifc entry (via id) or a group (via associative where)
     * @param bool|false $param
     */
    function remove($param = false)
    {
        if (!$param) {
            return false;
        }
        if (is_array($param)) {
            $this->db->where($param);
        } else {
            $this->db->where('id', $param);
        }
        return $this->db->delete($this->table);
    }

    /**
     * Inserts a new item and returns the new item ID.
     * @param bool|false $insert
     */
    function insert($insert = false)
    {
        if (!$insert || !is_array($insert)) {
            return false;
        }
        return $this->db->insert($this->table, $insert) ? $this->db->insert_id() : false;
    }

    /**
     * Activates a given item.
     * @param $id
     */
    function activate($id = false)
    {
        if (!$id) {
            return false;
        }
        $this->db->where('id', $id);
        $this->db->set('active', 1);
        $this->db->update($this->table);
    }

    /**
     * Deactivates a given item.
     * @param $id
     */
    function deactivate($id = false)
    {
        if (!$id) {
            return false;
        }
        $this->db->where('id', $id);
        $this->db->set('active', 0);
        $this->db->update($this->table);
    }

}
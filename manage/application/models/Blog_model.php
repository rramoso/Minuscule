<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Blog Model
 *
 * Handles interations with the Blog Database
 * @author: Joseph Schultz - schultzjosephj@gmail.com
 * @version: 1.0.0
 * @modified: 12/14/2015
 */
class Blog_model extends MY_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_all($where = false, $limit = false)
    {
        $this->db->select('blog.*')->from('blog');
        if (is_array($where)) {
            $this->db->where($where);
        } else if ($where) {
            $this->db->where('id', $where);
        }
        if ($limit) {
            $this->db->limit($limit);
        }
        $this->db->order_by('name', 'asc');
        $r = $this->db->get();
        return $r->num_rows() ? $r : false;
    }

    /**
     * Saves a blog to the database and associates it with a user.
     * @param int|bool|false $user_id
     * @param array|bool|false $data
     * @return bool
     */
    function save($user_id = false, $data = false)
    {
        $this->load->model('user_model');
        $this->user_model->visited($user_id);

        if (!$user_id || !$data) {
            return false;
        }

        $check = $this->get(['name' => $data['name']]);
        $array = [
            'category_id' => $data['category'],
            'followers' => $data['followers'],
            'updated' => time(),
            'enable_ads' => $data['enable'] == 'on' ? 1 : 0,
            'frequency' => $data['frequency']
        ];
        if ($check) {
            return $this->db->update('blog', $array, ['id' => $check->id]);
        } else {
            $array['user_id'] = $user_id;
            $array['uid'] = guid();
            $array['name'] = $data['name'];
            $array['created'] = time();
            return $this->db->insert('blog', $array);
        }
    }

    /**
     * Returns the blog information for the source blog where all posts will be initially posted to.
     * @return bool
     */
    function source()
    {
        //Get Source Blog
        $this->db->select('blog.*, user.token, user.secret')->from('blog');
        $this->db->join('setting', 'setting.value = blog.id', 'left');
        $this->db->join('user', 'user.id = blog.user_id', 'left');
        $this->db->where('setting.key', 'source');

        $r = $this->db->get();

        return $r && $r->num_rows() > 0 ? $r->row() : false;
    }

    /**
     * Gets all blogs within a category
     * @param bool $category_id
     * @return bool
     */
    public function get_by_category($category_id = false)
    {
        if (!$category_id) {
            return false;
        }

        $blogs = $this->db->get_where('blog', ['category_id' => $category_id]);
        return $blogs->num_rows() > 0 ? $blogs : false;
    }

    /**
     * Reblogs a specific post to a specific blog
     * @param $blog_id
     * @param $advertisement_id
     * @return bool
     */
    public function reblog($blog_id, $advertisement_id)
    {
        $this->load->model('advertisement_model');
        $blog = $this->get($blog_id);
        if ($blog) {
            $ad = $this->advertisement_model->get($advertisement_id);
            $ad_info = $this->db->get_where('advertisement_publish', ['advertisement_id' => $advertisement_id])->row();
            $user = $this->blog_model->get_blog_user($blog->id);
            $tumblr = new Tumblr\API\Client($this->auth['key'], $this->auth['secret'], $user->token, $user->secret);

            try {
                $post = $tumblr->reblogPost($blog->name, $ad_info->tumblr_id, $ad_info->reblog_key, [
                    'comment' => '<img height="1" width="1" style="position:absolute !important; left:-10000px !important;" src="' . site_url('api/minuscule/beacon/' . $blog->uid . '/' . $ad->id) . '"/>',
                ]);
                return $this->db->insert('advertisement_reblog', [
                    'advertisement_id' => $advertisement_id,
                    'blog_id' => $blog->id,
                    'tumblr_id' => $post->id,
                    'updated' => time(),
                    'created' => time()
                ]);
            } catch (Exception $e) {
                var_dump($e);
            }
        }
        return false;
    }

    /**
     * Unreblogs a specific post from a specific blog
     * @param $blog_id
     * @param $advertisement_id
     * @return bool
     */
    public function unreblog($blog_id, $advertisement_id)
    {
        $this->load->model('advertisement_model');
        $blog = $this->get($blog_id);
        if ($blog) {
            $ad_publish = $this->db->get_where('advertisement_publish', ['advertisement_id' => $advertisement_id])->row();
            $user = $this->blog_model->get_blog_user($blog->id);
            $ad_info = $this->db->get_where('advertisement_reblog', ['advertisement_id' => $advertisement_id, 'blog_id' => $blog->id, 'active' => 1]);
            if ($ad_info && $ad_info->num_rows() > 0) {
                $ad_info = $ad_info->row();
                $tumblr = new Tumblr\API\Client($this->auth['key'], $this->auth['secret'], $user->token, $user->secret);
                try {
                    $tumblr->deletePost($blog->name, $ad_info->tumblr_id, $ad_publish->reblog_key);
                    $this->db->update('advertisement_reblog', ['active' => 0, 'updated' => time()], ['id' => $ad_info->id]);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
        }
        return false;
    }

    public function unreblog_all($blog_id, $advertisement_id)
    {
        $this->load->model('advertisement_model');
        $blog = $this->get($blog_id);
        if ($blog) {
            $ad_publish = $this->db->get_where('advertisement_publish', ['advertisement_id' => $advertisement_id])->row();
            $user = $this->blog_model->get_blog_user($blog->id);
            $ad_info = $this->db->get_where('advertisement_reblog', ['advertisement_id' => $advertisement_id, 'blog_id' => $blog->id, 'active' => 1]);
            if ($ad_info && $ad_info->num_rows() > 0) {
                foreach ($ad_info->result() as $row) {
                    $tumblr = new Tumblr\API\Client($this->auth['key'], $this->auth['secret'], $user->token, $user->secret);
                    try {
                        $tumblr->deletePost($blog->name, $row->tumblr_id, $ad_publish->reblog_key);
                        echo $this->db->update('advertisement_reblog', ['active' => 0, 'updated' => time()], ['id' => $row->id]);
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                }
            }
        }
        return false;
    }

    /**
     * Gets a blog's user
     * @param bool $id
     * @return bool
     */
    public function get_blog_user($id = false)
    {
        if (!$id) {
            return false;
        }

        $this->db->select('user.*')->from('user');
        $this->db->join('blog', 'blog.user_id = user.id', 'left');
        $this->db->where('blog.id', $id);
        $r = $this->db->get();

        return $r->num_rows() > 0 ? $r->row() : false;
    }

    /**
     * @param bool $id
     * @return bool|object
     */
    public function get_reblogs($id = false)
    {
        if (!$id) {
            return false;
        }
        $this->db->select('advertisement_reblog.*')->from('advertisement_reblog');
        $this->db->join('advertisement', 'advertisement.id = advertisement_reblog.advertisement_id', 'left');
        $this->db->where('advertisement_reblog.blog_id', $id);
        $this->db->where('advertisement_reblog.active', 1);
        $this->db->order_by('advertisement_reblog.created', 'desc');
        $r = $this->db->get();
        return $r->num_rows() ? $r : false;
    }

    public function advertisement_views($blog_id, $advertisement_id)
    {
        if (!$blog_id || !$advertisement_id) {
            return false;
        }
        $r = $this->db->select('COUNT(*) as count')->from('log')
            ->where('log.advertisement_id', $advertisement_id)
            ->where('log.blog_id', $blog_id)
            ->get();
        return $r->num_rows() ? $r->row()->count : false;
    }

    public function advertisement_reblogs($blog_id, $advertisement_id, $today_only = true)
    {
        if (!$blog_id) {
            return false;
        }
        $this->db->select('*')->from('advertisement_reblog')
            ->where('blog_id', $blog_id);

        if ($advertisement_id) {
            $this->db->where('advertisement_id', $advertisement_id);
        }
        $this->db->where('active', 1);
        if ($today_only) {
            $this->db->where('created >=', strtotime('today'));
        }
        $r = $this->db->get();

        return $r->num_rows() ? $r : false;
    }

    public function update_followers($blog_id, $follower_count)
    {
        return $this->db->insert('blog_followers', [
            'blog_id' => $blog_id,
            'followers' => $follower_count,
            'updated_at' => time()
        ]) ? true : false;
    }
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Advertisement_model
 *
 * Handles interations with the Advertisement Database
 * @property Tumblr\API\Client $tumblr
 * @property Blog_model $blog_model
 * @author: Joseph Schultz - schultzjosephj@gmail.com
 * @version: 1.0.1
 * @modified: 1/9/2016
 */
class Advertisement_model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Creates a new advertisement in the database.
     *
     * @return int insert_id | bool
     */
    public function create()
    {
        $slug = toAscii($this->input->post('title'));
        //Make sure the slug doesn't currently exist. IF so, we need to create a unique one.
        $check = $this->get(['slug LIKE' => '%' . $slug . '%']);
        if ($check) {
            $number = substr($check->slug, strlen($check->slug) - 1, 1);
            $slug .= is_numeric((int)$number) ? "-" . ((int)++$number) : "-1";
        }

        $publish = strtotime(date('m/d/Y', strtotime($this->input->post('publish'))) . " " . date('h:i:s A', strtotime($this->input->post('publish_time'))));

        $insert_id = $this->insert([
            'slug' => $slug,
            'name' => $this->input->post('title'),
            'description' => strip_tags($this->input->post('description')),
            'content' => $this->input->post('content'),
            'publish' => $publish,
            'duration' => $this->input->post('duration'),
            'modified' => time(),
            'created' => time(),
            'active' => 1
        ]);

        //Associate
        if (is_array($this->input->post('categories'))) {
            foreach ($this->input->post('categories') as $category) {
                $this->db->insert('advertisement_category', ['advertisement_id' => $insert_id, 'category_id' => $category]);
            }
        }

        if ($this->input->post('file_ids')) {
            foreach ($this->input->post('file_ids') as $file_id) {
                $this->db->insert('advertisement_file', ['advertisement_id' => $insert_id, 'file_id' => $file_id]);
            }
        }
        return $insert_id;
    }

    /**
     * Publishes an ad to the central blog, saves the information to the database.
     * @param bool $id
     * @return bool
     */
    public function publish($id = false)
    {
        $this->load->model('blog_model');
        $ad = $this->get($id);
        $source = $this->blog_model->source();
        if ($ad && $source) {
            $tumblr = new Tumblr\API\Client($this->auth['key'], $this->auth['secret'], $source->token, $source->secret);
            $files = $this->files($ad->id);
            $content = $this->_replace_links($ad->content, $ad->id);
            try {
                if ($files) {
                    $data = [];
                    foreach ($files->result() as $file) {
                        $data[] = $this->paths->uploads . $file->name;
                    }
                    $caption = preg_replace("/<img[^>]+\>/i", "", $content);
                    $insert = $tumblr->createPost($source->name,
                        [
                            'type' => 'photo',
                            'data' => $data,
                            'caption' => $caption
                        ]);

                } else {
                    $insert = $tumblr->createPost($source->name,
                        [
                            'type' => 'text',
                            'state' => 'published',
                            'tags' => '',
                            'title' => $ad->name,
                            'data' => [],
                            'body' => $content,
                        ]);
                }
                $post = $tumblr->getBlogPosts($source->name)->posts[0];
                $reblog_key = $post->reblog_key;
                $this->db->delete('advertisement_publish', ['advertisement_id' => $ad->id]);
                $this->db->insert('advertisement_publish', [
                    'advertisement_id' => $ad->id,
                    'tumblr_id' => $post->id,
                    'reblog_key' => $reblog_key,
                    'updated' => time(),
                    'created' => time()
                ]);
            } catch (Exception $e) {
                Rollbar::report_exception($e);
                return false;
            }
            return $this->db->update('advertisement', ['published' => time()], ['id' => $id]);
        }
        return false;
    }

    private function _replace_links($html, $advertisement_id = false)
    {
        $dom = new DomDocument();
        $dom->loadHTML($html);
        $anchors = $dom->getElementsByTagName('a');
        foreach ($anchors as $a) {
            if ($a->hasAttribute('href')) {
                $href = $a->getAttribute('href');
                $a->setAttribute('href', site_url('/redirect/' . $advertisement_id . '?url=' . urlencode($href)));
            }
        }
        $str = $dom->saveHTML();
        return $str;
    }

    /**
     * Publishes an ad to the central blog, saves the information to the database.
     * @param bool $id
     * @return bool
     */
    public function unpublish($id = false)
    {
        $this->load->model('blog_model');
        $ad = $this->get($id);
        $source = $this->blog_model->source();

        $this->db->select('advertisement_publish.*')->from('advertisement_publish');
        $this->db->where('advertisement_publish.advertisement_id', $ad->id);
        $publish = $this->db->get();
        if ($ad && $source && $publish->num_rows() > 0) {
            $publish = $publish->row();
            $tumblr = new Tumblr\API\Client($this->auth['key'], $this->auth['secret'], $source->token, $source->secret);
            return $tumblr->deletePost($source->name, $publish->tumblr_id, $publish->reblog_key);
        }
        return false;
    }

    /**
     * Retrieves files associated with an ad.
     * @param $id
     * @return bool
     */
    function files($id)
    {
        $this->db->select('file.*')->from('file');
        $this->db->join('advertisement_file', 'advertisement_file.file_id = file.id', 'left');
        $this->db->where('advertisement_file.advertisement_id', $id);
        $r = $this->db->get();

        return $r->num_rows() > 0 ? $r : false;
    }

    /**
     * Reblogs with unique image to all children in category
     * @param bool $id
     */
    public function reblog($id = false)
    {
        $this->load->model('blog_model');
        $categories = $this->db->get_where('advertisement_category', ['advertisement_id' => $id]);
        if ($categories) {
            foreach ($categories->result() as $category) {
                $blogs = $this->blog_model->get_by_category($category->category_id);
                if ($blogs) {
                    foreach ($blogs->result() as $blog) {
                        $this->blog_model->reblog($blog->id, $id);
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Removes a reblogged post from the tumblr stream
     * @param bool $id
     * @return bool
     */
    public function unreblog($id = false)
    {
        $this->load->model('blog_model');
        $categories = $this->db->get_where('advertisement_category', ['advertisement_id' => $id]);
        if ($categories) {
            foreach ($categories->result() as $category) {
                $blogs = $this->blog_model->get_by_category($category->category_id);
                if ($blogs) {
                    foreach ($blogs->result() as $blog) {
                        $this->blog_model->unreblog($blog->id, $id);
                    }
                }
            }
            return true;
        }
        return false;
    }

    function get_upcoming()
    {
        $this->db->select('advertisement.*')->from('advertisement');
        $this->db->where('advertisement.publish >= ', strtotime("-1 day"));
        $this->db->where('advertisement.publish <= ', strtotime("midnight"));
        $r = $this->db->get();
        return $r->num_rows() > 0 ? $r : false;
    }

    function get_running()
    {
        $this->load->model('blog_model');
        $out = array();
        $source = $this->blog_model->source();
        if ($source) {
            try {
                $search = $this->tumblr->getBlogPosts($source->name);
                if ($search) {
                    $posts = $search->posts;
                    foreach ($posts as $post) {
                        $this->db->select('advertisement_publish.*')->from('advertisement_publish');
                        $this->db->where('tumblr_id', $post->id);
                        $r = $this->db->get();
                        if ($r->num_rows() > 0) {
                            $out[] = $post;
                        }
                    }
                    return $out;
                }
            } catch (Exception $e) {
                return false;
            }
        }
        return false;
    }

    function get_active()
    {
        $active = [];
        $this->db->select('advertisement.*, advertisement_publish.reblog_key')->from('advertisement_publish');
        $this->db->join('advertisement', 'advertisement_publish.advertisement_id=advertisement.id', 'left');
        $this->db->where(['advertisement.publish <=' => time()]);
        $ads = $this->db->get();
        $ads = $ads->num_rows() ? $ads : false;
        if ($ads) {
            foreach ($ads->result() as $ad) {
                $duration = strtotime("+ " . $ad->duration . " hours", $ad->publish);
                if (time() <= $duration) {
                    $active[] = $ad;
                }
            }
        }
        return $active;
    }

    /**
     * Removes an advertisement
     * @param $id
     * @return mixed
     */
    function remove($id)
    {
        return $this->db->delete('advertisement', ['id' => $id]);
    }

}
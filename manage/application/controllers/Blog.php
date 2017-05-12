<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('site_model');
        $this->load->model('category_model');
        $this->load->model('blog_model');
    }

    /**
     *
     * Saves a blog settings to the database, accepts posted arguments, however we need to verify that the
     * blog name that is sent is indeed associated with the user's account (to prevent someone hacking
     * the settings of another person's blog.
     *
     * @modified 12/14/2015
     * @return bool
     */
    function index()
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            if (empty($data)) {
                return false;
            }
            $is_valid = false;
            if ($name = $data['name']) {
                foreach ($this->tumblr->getUserInfo()->user->blogs as $blog) {
                    if ($name == $blog->name) {
                        $is_valid = true;
                        $data['followers'] = $blog->followers;
                        break;
                    }
                }
            }
            if (!$is_valid) {
                return $this->message->send('Nice try... work on your own account.', 'error');
            }
            $user_id = $this->user->id;
            if ($this->blog_model->save($user_id, $data)) {
                return $this->message->send('Successfully saved blog settings for ' . $data['name'], 'success');
            } else {
                return $this->message->send('Failed updating blog settings for ' . $data['name'] . ' try again later.', 'error');
            }
        } else {
            redirect('dashboard');
        }
    }

    /**
     * Shows a table of all available blogs.
     *
     * @created 11/3/2016
     */
    function all()
    {
        if ($this->user->role >= 3) {
            $categories = $this->category_model->get_all();
            $data['categories'] = [];
            foreach ($categories->result() as $category) {
                $data['categories'][$category->id] = $category->name;
            }
            $data['blogs'] = $this->blog_model->get_all();
            $this->load->view('common/header');
            $this->load->view('blog/all', $data);
            $this->load->view('common/footer');
        } else {
            $this->message->send('You do not have permission to be here.', 'error', '/');
        }
    }

    /**
     * Edit a specific blog
     *
     * @created 11/3/2016
     */
    function edit($blog_id)
    {
        $this->load->model('stat_model');
        $data = [];
        $data['blog'] = $this->blog_model->get($blog_id);
        $data['followers'] = $this->stat_model->get_follower_count($blog_id);
        $data['categories'] = $this->category_model->get_all();
        $this->load->view('common/header');
        $this->load->view('blog/edit', $data);
        $this->load->view('common/footer');
    }

    /**
     * Updates a blog from the edit page.
     *
     * @created 11/3/2016
     */
    function update()
    {
        if ($this->user->role >= 3) {
            $id = $this->input->post('id');
            $update = $this->blog_model->update($id, [
                'category_id' => $this->input->post('category'),
                'enable_ads' => $this->input->post('enable') == 'on' ? 1 : 0,
                'frequency' => $this->input->post('frequency'),
                'updated' => time()
            ]);
            if ($update) {
                $this->message->send('Successfully updated blog.', 'success', 'blog/all');
            } else {
                $this->message->send('Failed to update blog. Please try again later.', 'error');
            }
        } else {
            $this->message->send('You do not have permission to be here.', 'error', '/');
        }
    }

    /**
     * Blog setup page, shows user's available blogs along with editable settings.
     *
     * @modified 12/14/2015
     * @return view
     */
    public function setup()
    {
        $blogs = $this->blog_model->get_all(["user_id" => $this->user->id]);
        if (!$blogs) {
            foreach ($this->tumblr->getUserInfo()->user->blogs as $blog) {
                if ($blog->primary) {
                    $this->blog_model->save($this->user->id, [
                        'name' => $blog->name,
                        'created' => time(),
                        'followers' => $blog->followers,
                        'updated' => time(),
                        'enable' => 'on',
                        'frequency' => 6
                    ]);
                }
            }
        }
        $hdata['hide_menu'] = true;
        $data['categories'] = $this->category_model->get_all();
        $this->load->view('common/header');
        $this->load->view('blog/setup', $data);
        $this->load->view('common/footer');
    }

    /**
     * Loads configured and unconfigured blogs.
     * @return array|void
     */
    public function load($type = 'configured')
    {
        $data = [];
        $names = [];
        $categories = $this->category_model->get_all();
        $blogs = $this->blog_model->get_all(['user_id' => $this->user->id]);
        //Existing Blogs
        if ($blogs) {
            foreach ($blogs->result() as $saved) {
                if ($type == 'configured') {
                    $blog = $this->tumblr->getBlogInfo($saved->name)->blog;
                    if ($blog->admin) {
                        $data[] = $this->load->view('blog/partials/blog_card', ['blog' => $blog, 'categories' => $categories, 'saved' => $saved], true);
                    }
                }
                array_push($names, $saved->name);
            }
        }
        if ($type == 'unconfigured') {
            //Unconfigured
            foreach ($this->tumblr->getUserInfo()->user->blogs as $blog) {
                if (!in_array($blog->name, $names) && $blog->admin) {
                    $data[] = $this->load->view('blog/partials/blog_card', ['blog' => $blog, 'categories' => $categories], true);
                }
            }
        }

        //Return data correctly
        if ($this->router->method === __FUNCTION__) {
            header('Content-Type: application/json');
            echo json_encode($data);
            return;
        } else {
            return $data;
        }

    }

    function delete($blog_id)
    {
        if ($this->user->role >= 3) {
            return $this->blog_model->remove($blog_id);
        } else {
            return false;
        }
    }
}
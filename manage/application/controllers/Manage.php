<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->user->role < 3) {
            redirect('dashboard');
        }
        $this->load->model('site_model');
        $this->load->model('category_model');
        $this->load->model('blog_model');
        $this->load->model('advertisement_model');
    }

    /**
     * Main Site Index (Default route landing)
     * Handles logging in, registration, and first-login views.
     *
     * @modified 12/14/2015
     * @return views
     */
    public function index()
    {
        $data['advertisements'] = $this->advertisement_model->get_all();
        $data['upcoming'] = $this->advertisement_model->get_upcoming();
        $data['running'] = $this->advertisement_model->get_running();
        $this->load->view('common/header');
        $this->load->view('manage/index', $data);
        $this->load->view('common/footer');
    }

    public function advertisement($id)
    {
        $data['advertisement'] = $this->advertisement_model->get($id);
        $data['blogs'] = $this->blog_model->get_all();
        $this->load->view('common/header');
        $this->load->view('manage/advertisement', $data);
        $this->load->view('common/footer');
    }

    /**
     * Publishes an ad to all subscribed blog categories.
     * @param bool $id
     */
    function publish($id = false)
    {
        if (!$id || !$this->advertisement_model->get($id)) {
            $this->message->send('Invalid Advertisement selected', 'error');
            return false;
        }
        if ($this->advertisement_model->publish($id)) {
            $this->message->send('Successfully published advertisement', 'success');
        } else {
            $this->message->send('Error publishing advertisement, please try again later', 'error');
        }
    }

    function unpublish($id = false)
    {
        if (!$id || !$this->advertisement_model->get($id)) {
            $this->message->send('Invalid Advertisement selected', 'error');
            return false;
        }
        if ($this->advertisement_model->unpublish($id)) {
            $this->message->send('Successfully unpublished advertisement', 'success');
        } else {
            $this->message->send('Error unpublishing advertisement, please try again later', 'error');
        }
    }

    function reblog($id = false)
    {
        if (!$id || !$this->advertisement_model->get($id)) {
            $this->message->send('Invalid Advertisement selected', 'error');
            return false;
        }
        if ($this->advertisement_model->reblog($id)) {
            $this->message->send('Successfully reblogged advertisement', 'success');
        } else {
            $this->message->send('Error reblogging advertisement, please try again later', 'error');
        }
    }

    function unreblog($ad_id = false, $blog_id = false)
    {
        $this->blog_model->unreblog_all($ad_id, $blog_id);
        redirect('manage/advertisement/' . $ad_id);
    }

    function create()
    {
        if ($this->input->post()) {
            if ($this->advertisement_model->create()) {
                $this->message->send('Successfully created advertisement', 'success');
            } else {
                $this->message->send('Error creating ad, please try again later', 'error');
            }
        } else {
            $data['categories'] = $this->category_model->get_all();
            $data['uploader'] = $this->load->view('file/uploader', false, true);
            $this->load->view('common/header');
            $this->load->view('manage/create', $data);
            $this->load->view('plugins/ckeditor');
            $this->load->view('common/footer');
        }
    }

    /**
     * Reblogs an advertisement to a blog manually.
     * @param bool $key
     * @param $ad_id
     * @param $blog_name
     * @return bool
     */
    function reblog_single($ad_id, $blog_id)
    {
        $this->load->model('advertisement_model');
        $this->load->model('blog_model');
        $ad = $this->advertisement_model->get($ad_id);
        $blog = $this->blog_model->get($blog_id);
        $reblogs = $this->blog_model->get_reblogs($blog->id);
        if ($ad) {
            if ($reblogs) {
                foreach ($reblogs->result() as $reblog) {
                    $this->blog_model->unreblog_all($blog->id, $reblog->advertisement_id);
                }
                $this->blog_model->reblog($blog->id, $ad_id);
            } else {
                $this->blog_model->reblog($blog->id, $ad_id);
            }
        }
        redirect('manage/advertisement/' . $ad_id);
    }

    /**
     * Removes an advertisement
     * @param $id
     */
    function remove($id)
    {
        try {
            $this->unreblog($id);
            $this->unpublish($id);
        } catch (Exception $e) {
            $this->message->send('Error removing ad from tumblr, please try again later', 'error');
            return;
        }
        if ($this->advertisement_model->delete($id)) {
            $this->message->send('Successfully deleted advertisement', 'success');
        } else {
            $this->message->send('Error removing ad, please try again later.', 'error');
        }

    }

}


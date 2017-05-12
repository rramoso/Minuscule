<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advertisement extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        if ($this->user->role < 3) {
            redirect('dashboard');
        }
        $this->load->model('site_model');
        $this->load->model('category_model');
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
        $this->load->view('advertisement/index', $data);
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

    function unreblog($id = false)
    {
        if (!$id || !$this->advertisement_model->get($id)) {
            $this->message->send('Invalid Advertisement selected', 'error');
            return false;
        }
        if ($this->advertisement_model->unreblog($id)) {
            $this->message->send('Successfully unreblogged advertisement', 'success');
        } else {
            $this->message->send('Error unreblogging advertisement, please try again later', 'error');
        }
    }

    function create()
    {
        if ($this->input->post()) {
            if ($this->advertisement_model->create()) {
                $this->message->send('Successfully created advertisement', 'success', 'advertisement');
            } else {
                $this->message->send('Error creating ad, please try again later', 'error');
            }
        } else {
            $data['categories'] = $this->category_model->get_all();
            $data['uploader'] = $this->load->view('file/uploader', false, true);
            $this->load->view('common/header');
            $this->load->view('advertisement/create', $data);
            $this->load->view('plugins/ckeditor');
            $this->load->view('common/footer');
        }
    }

    function cron()
    {
        return $this->advertisement_model->cron();
    }
}


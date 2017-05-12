<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }


    public function all()
    {
        if ($this->user->role >= 3) {
            $data['users'] = $this->user_model->get_all();
            $this->load->view('common/header');
            $this->load->view('user/all', $data);
            $this->load->view('common/footer');
        } else {
            $this->message->send('You do not have permission to be here.', 'error', '/');
        }
    }

}

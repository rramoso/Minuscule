<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Errors extends MY_Controller
{

    public function __construct()
    {
        parent::__construct(false);
    }

    function page_missing()
    {
        $this->load->view('common/header');
        $this->load->view('errors/custom/404');
        $this->load->view('common/footer');
    }
}

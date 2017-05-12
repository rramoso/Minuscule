<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('site_model');
        $this->load->model('category_model');
        $this->load->model('stat_model');
        if ($this->user->first_login || !$this->user->email) {
            redirect('login');
        }
    }

    /**
     * Shows the main dashboard page
     */
    public function index()
    {

        $this->load->view('common/header');
        $this->load->view('dashboard/index', $data);
        $this->load->view('common/footer');
    }

    /**
     * Shows network stats for a user's configured blogs.
     */
    function network_stats()
    {
        $data['followers'] = $this->stat_model->get_follower_counts();
        $data['day'] = $this->stat_model->get_json($this->user->id, 7);
        $data['hour'] = $this->stat_model->get_json($this->user->id, 1);
        $this->load->view('common/header');
        $this->load->view('dashboard/network-stats', $data);
        $this->load->view('common/footer');
    }

    /**
     * Export Followers
     * @created 11/8/2016
     */
    function export_followers()
    {
        $followers = $this->stat_model->get_follower_counts(false);
        $headers = [
            "id",
            "name",
        ];
        $rows = [];
        if ($followers) {
            foreach ($followers[0]['followers'] as $instance) {
                $headers[] = date('m/d/y', $instance->updated_at);
            }
            foreach ($followers as $follower) {
                $row = [
                    $follower['blog']->id,
                    $follower['blog']->name,
                ];
                foreach ($follower['followers'] as $instance) {
                    $row[] = $instance->followers;
                }
                if (count($follower['followers']) < count($headers)) {
                    for ($i = count($follower['followers']); $i < count($headers); $i++) {
                        $row[] = "n/a";
                    }
                }
                $rows[] = $row;
            }
        }

        $fh = fopen('php://output', 'w');
        ob_start();
        fputcsv($fh, $headers);
        foreach ($rows as $row) {
            fputcsv($fh, $row);
        }
        $string = ob_get_clean();

        $filename = 'followers_' . date('Ymd') . '_' . date('His');

        // Output CSV-specific headers
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename={$filename}.csv;");
        header("Content-Transfer-Encoding: binary");
        exit($string);
    }

    /**
     * Shows currently running and past campaigns on the account.
     */
    function campaigns()
    {
        $this->load->view('common/header');
        $this->load->view('dashboard', $data);
        $this->load->view('common/footer');
    }

    /**
     * Administer an account.
     */
    function administration()
    {
        $this->load->view('common/header');
        $this->load->view('dashboard', $data);
        $this->load->view('common/footer');
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('file_model');
    }

    public function create()
    {
        if ($_FILES) {
            $this->do_upload();
        } else {
            $this->load->view('common/header');
            $this->load->view('file/uploader');
            $this->load->view('common/footer');
        }
    }

    public function do_upload()
    {
        if ($_FILES) {
            $out = [];
            foreach ($_FILES as $file) {
                $name = $file['name'];
                $size = $file['size'];
                $tmp = $file['tmp_name'];
                $type = $file['type'];
                $ext = strtolower(end(explode('.', $name)));
                $allowed = array("jpeg", "jpg", "png", 'gif', 'tif');
                $new_name = randString(24);
                $is_image = false;

                if (!in_array($ext, $allowed)) {
                    $this->message->send('Invalid File Type', 'error');
                    return;
                }

                move_uploaded_file($tmp, $this->paths->uploads . "/$new_name.$ext");

                if (@is_array(getimagesize($this->paths->uploads . "/$new_name.$ext"))) {
                    $is_image = true;
                }

                $data = ['name' => "$new_name.$ext", 'description' => $name, 'extension' => $ext, 'image' => $is_image, 'size' => $size, 'modified' => time(), 'created' => time()];

                $file_id = $this->file_model->save($data);
                $out[$file_id] = "$new_name.$ext";
            }
            header('Content-Type: application/json');
            echo json_encode($out);
            return;
        } else {
            Rollbar::report_message('Attempt to upload image without data');
        }
    }
}
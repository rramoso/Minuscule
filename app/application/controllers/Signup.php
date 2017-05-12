<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Login
 * @property CI_Output output
 */
class Signup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('file_model');
        $this->load->model('artist_model');
        $this->load->model('curator_model');  
        $this->load->model('category_model');      
        $this->load->helper('url');  
        $this->load->library('session');    
        $this->load->library('upload');   
    }

    public function view()
    {
        if ($this->input->post()) {

            $avatar = NULL;
            if(!empty($_FILES['avatar']['name'])){
                
                $config['upload_path'] = explode('system', BASEPATH)[0].'assets/uploads/avatars/';
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                $config['file_name'] = $_FILES['avatar']['name'];
                
                $picture = $config['file_name'];
                $this->load->library('upload', $config);
                $this->upload->initialize($config);


                if (!$this->upload->do_upload('avatar')){
                    echo $this->upload->display_errors();
                }
                else{
                    $avatar = $this->file_model->insertFile($picture,"");
                }
                
            }

           if(!$this->user_model->isUser($this->input->post('email'),$this->input->post('newuser')))
            {   
                $this->user_model->createUser($avatar);
                header("Location:".'typeuser',TRUE,301);
            } else{
                $data = array(
                    'error_message'=> "It looks like you are have registered before."
                    );

                $this->load->view('templates/header');
                $this->load->view('templates/error_message',$data);
            }

        } else {
            $gend = 'male';
            if(rand(0,10)>5){
                $gend = 'female';
            }
            $data = array(
                'gender'=> $gend
                );
            $this->load->view('templates/header');
            $this->load->view('signup/signup',$data);
            // //$this->load->view('templates/footer');
        }
    }

    public function typeuser(){

        if ($this->input->post()) {

            $user_id = $this->session->userdata('user_id');
            $typeuser = $this->input->post('usertype');
            if($typeuser === 'artist'){
                
                $this->artist_model->createArtist($user_id);
            }
            else{
                $this->curator_model->createCurator($user_id);
            }

            $newdata = array(
                   'typeuser'  => $typeuser,
               );

            $this->session->set_userdata($newdata);
            header("Location:".'../dashboard/'.$typeuser,TRUE,301);

        } else {

            $data = array(
                'categories'=> $this->category_model->getCategories()
                );
            $this->load->view('templates/header');
            $this->load->view('signup/typeuser',$data);
            //$this->load->view('templates/footer');
        }
    }
}

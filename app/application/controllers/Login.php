<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Login
 * @property CI_Output output
 */
class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('login_model'); 
        $this->load->model('artist_model'); 
        $this->load->model('curator_model'); 
        $this->load->model('category_model');
        $this->load->library('session');
        $this->load->database();  
        $this->load->helper('url');
    }
    
    public function redirecting(){
        header("Location:".'index.php/login/view',TRUE,301);
    }
    
    public function view($page = 'login')
    {
        if ( ! file_exists(APPPATH.'views/login/'.$page.'.php')){
            show_404();
        }
        if ($this->input->post()) {
		
            $resp = $this->login_model->isUser($this->input->post('user'),$this->input->post('password'));
            if($resp>0 && $this->login_model->hasToken($this->input->post('user'))){

                $newdata = array(
                   'user_id'  => $resp,
                   'logged_in' => TRUE
               );
		
                $this->session->set_userdata($newdata);
                $url = $_SERVER['REQUEST_URI'];
                if(strpos($url,'index.php')!== false)
                {
                
                	header("Location:".'welcomeback/',TRUE,301);
                } else{
                	header("Location:".'index.php/login/welcomeback/',TRUE,301);
                }
                
            } elseif($resp>0){
            	
                $typeuser = 'curator';
                if($this->artist_model->isArtist($resp)){
                    $typeuser = 'artist';
                }

                $newdata = array(
                   'user_id'  => $resp,
                   'typeuser'  => $typeuser,
                   'logged_in' => True
               );

                $this->session->set_userdata($newdata);
                header("Location:".'../dashboard/'.$typeuser,TRUE,301);
            }else{
                $data = array(
                    'error_message'=> "It looks like you are have an incorrent Username/Email or Password."
                    );

                $this->load->view('templates/header');
                $this->load->view('templates/error_message',$data);
            }

        } else {
            $data['title'] = ucfirst($page); // Capitalize the first letter
            
            $this->load->view('templates/header');
            $this->load->view('login/'.$page, $data);
            // $this->load->view('templates/footer', $data);
        }
    }
    
      public function sendResetPasswordEmail($email,$username){

        $this->load->library('email');
        $email_code = md5("ciguapa".$username);

        $from = "rrosar95@gmail.com";
        $to = $email;
        $subject = "Reset Password";


        $message = "We want you to help you reset your password. Please click here to reset your password: ". base_url(). "index.php/login/reset_password_form/".$email."/".$email_code;
    
        if(mail($to, $subject, $message)){
            $data = array(
                    'body_message'=> "Your mail has been sent successfully.",
                    'title_message'=> "Thanks!"
                    );

                $this->load->view('templates/header');
                $this->load->view('templates/info_message',$data);
        } else{
            $data = array(
                    'body_message'=> "There was a error, try again later.",
                    'title_message'=> "Oops!"
                    );

                $this->load->view('templates/header');
                $this->load->view('templates/info_message',$data);
        }
        
    }
    
     public function reset_password_form($email,$email_code){


        if($this->login_model->emailExist($email)){
            $user = $this->user_model->getUserByEmail($email);
            if(md5("ciguapa".$user->username) === $email_code){

                 if ($this->input->post()) {
                    $newpassword = $this->input->post('password1');
                    
                    $this->login_model->resetPassword($email,$newpassword);

                    header("Location:".'../../view',TRUE,301);
                 }else{
                    $this->load->view('templates/header');
                    $this->load->view('login/resetpasswordform');
                 }
            }
        }
        else{
            show_404();
        }
    }
    
    public function forgotpassword(){

         if ($this->input->post()) {

            $email = $_POST['email'];
            print_r($this->login_model->emailExist($email));
            if($this->login_model->emailExist($email)){

                $user = $this->user_model->getUserByEmail($email);
                $this->sendResetPasswordEmail($email,$user->username);

                 
                // $this->load->view('templates/header');
                // $this->load->view('login/forgotpassword');
                // $this->load->view('templates/footer', $data);

            }else {
                
                $this->load->view('templates/header');
                $this->load->view('login/forgotpassword');
                // $this->load->view('templates/footer', $data);
            }

        } else {
            
             
                $this->load->view('templates/header');
                $this->load->view('login/forgotpassword');
                // $this->load->view('templates/footer', $data);
        }
    }


    public function welcomeback(){

         if ($this->input->post()) {

            $user_id = $this->session->userdata('user_id');
            print_r($user_id);
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
            header("Location:".'../../dashboard/'.$typeuser,TRUE,301);
            

        } else {
            
            $categories =  $this->category_model->getCategories();
            $data =  array(
            'categories'=> $categories
            );

            $this->load->view('templates/header');
            $this->load->view('login/welcomeback', $data);
            // $this->load->view('templates/footer', $data);
        }
    }
   
}

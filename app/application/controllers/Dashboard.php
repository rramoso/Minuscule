<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Login
 * @property CI_Output output
 */
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('artist_model');
        $this->load->model('login_model');
        $this->load->model('curator_model');
        $this->load->model('file_model');
        $this->load->model('category_model');
        $this->load->helper('html');
        $this->load->library('session');
        $this->load->library('pagination');

    }
    
    public function logout()
    { 
        $this->session->sess_destroy();
        header("Location:".'../login/view',TRUE,301);
    }

   

    public function artist()
    {       
        /** There must be a validation that the logged user is in fact a artist
            the artist must  have a profile, upload art link.
            when an artist upload a image it can uploaded by an url or the image itself. 
        */ 
            $typeuser = $this->session->userdata('typeuser');
            if($typeuser == 'artist'){

                $user_id = $this->session->userdata('user_id');
                $artist = $this->artist_model->getArtistByUserID($user_id);
                
                $data = array(
                    'avatar'=>$artist['avatar'],
                    'nickname'=> $artist['nickname'],
                    'user_name'=> $artist['name'],
                    'manifesto'=> $artist['manifesto'],
                    'gallery' => $this->artist_model->getArtistArtwork($artist['id'],100)
                );
		          $gend = 'male';
                if(rand(0,10)>5){
                    $gend = 'female';
                }
                $data['gender'] = $gend;



                $this->load->view('templates/header');
                $this->load->view('dashboard/dashboard',$data);
                $this->load->view('dashboard/new_artist',$data);
                // //$this->load->view('templates/footer');
            } else{

                $data = array(
                    'error_message'=> "It looks like you are not a registered Artist."
                    );

                $this->load->view('templates/error_message',$data);
                // //$this->load->view('templates/footer');
            }
            
    }
    public function uploadArtWork(){

        $typeuser = $this->session->userdata('typeuser');
        if($typeuser == 'artist'){
            $user_id = $this->session->userdata('user_id');
            $artist = $this->artist_model->getArtistByUserID($user_id);
            if ($this->input->post()) {

                if(!empty($_FILES['work']['name'])){
                    
                    $config['upload_path'] = explode('system', BASEPATH)[0].'assets/uploads/';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config['file_name'] = $_FILES['work']['name'];
                    
                    $picture = $config['file_name'];
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('work')){
                        echo $this->upload->display_errors();
                    }
                    else{
                        $description = $this->input->post('work_description');
                        $work_id = $this->file_model->insertFile($picture,$description);
                        
                        $this->artist_model->artistArtwork($artist['id'],$work_id);
                    }
                }
            }
            $gend = 'male';
                if(rand(0,10)>5){
                    $gend = 'female';
                }
                
            $data = array(
                'categories'=> $this->category_model->getCategories(),
                'avatar'=>$artist['avatar'],
                'nickname'=> $artist['nickname'],
                'user_name'=> $artist['name'],
            );
            $data['gender'] = $gend;
            $this->load->view('templates/header');
            $this->load->view('dashboard/dashboard',$data);
            $this->load->view('dashboard/new_upload_art_piece',$data);
            // //$this->load->view('templates/footer');
        } else{

                $data = array(
                    'error_message'=> "It looks like you are not a registered Artist."
                    );

                $this->load->view('templates/header');
                $this->load->view('dashboard/dashboard');
                $this->load->view('templates/error_message',$data);
                // //$this->load->view('templates/footer');
            }
    }
    public function ajaxArtWork($piece_id){

        $data = $this->file_model->getFileById($piece_id);
        echo json_encode($data);
    }

     public function setCategory(){

        $categoryInitials = $_POST['categoryInitials'];
        $newdata = array(
           'category'  => $categoryInitials
       );

        $this->session->set_userdata($newdata);
    }
    public function setProfile(){

        $profile = $_POST['profile'];
        $newdata = array(
           'profile'  => $profile
       );

        $this->session->set_userdata($newdata);
    }
     public function usernameCheck($name){


        $query = $user = $this->db->get_where('user', array('username' => $name));
        if (sizeof($query->result()) > 0) {
            $output = 1;
        } else {
            $output = 0;
        }
        print_r( json_encode($output));
    }
    public function emailCheck($email, $company,$domain){

        $query = $user = $this->db->get_where('user', array('email' => $email.'@'.$company.'.'.$domain));
        if (sizeof($query->result()) > 0) {
            $output = 1;
        } else {
            $output = 0;
        }
        print_r( json_encode($output));
    }
    public function artistMyWork(){

        session_start();
        $_SESSION['username'];
        $this->load->view('templates/header');
        $this->load->view('dashboard/artist_my_work');
        // //$this->load->view('templates/footer');
    }

    public function curator()
    {       
        /** There must be a validation that the logged user is in fact a curator
            the toolbar as the documentation explained by Chaz
            the dashboard will have diferents artist that the curator dont follow 
        */
            
            if ($this->input->post()) {
                $curator = $_POST['curator'];
                $artist = $_POST['artist'];

                $this->curator_model->addFavoriteArtist($curator,$artist);

            }

            $typeuser = $this->session->userdata('typeuser');
            if($typeuser == 'curator'){

                $config = array();
                $config['base_url'] = base_url().'index.php/dashboard/curator/';
                $config['total_rows'] = $this->artist_model->totalCount();
                $config['per_page'] = 20;
                $config['uri_segment'] = 3;
                $this->pagination->initialize($config);

                $user_id = $this->session->userdata('user_id');
                $curator_id = $this->curator_model->getCuratorByUserId($user_id);

                $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
               
                $user_id = $this->session->userdata('user_id');
                $user = $this->user_model->getUserById($user_id);
                $avatar = '';
                if(!is_null($user->avatar)){
                    $file = $this->db->get_where('file', array('id' =>$user->avatar));
                    foreach ($file->result() as $row) {
                    $$avatar = $row->name;
                    }
                    $query = $this->db->query('SELECT * FROM file WHERE id = '.$user->avatar);
                    $avatar = $query->result_array()[0]['name'];
                }
                $data = array(
                    'avatar'=>$avatar,
                    'user_name'=> $user->first_name." ".$user->last_name,
                    'curator_id' => $curator_id,
                    'artists' => $this->curator_model->getArtists($config["per_page"],$page),
                    'links' => $this->pagination->create_links()
                );
                $gend = 'male';
                if(rand(0,10)>5){
                    $gend = 'female';
                }
                $data['gender'] = $gend;



                $this->load->view('templates/header');
                $this->load->view('dashboard/dashboard',$data);
                $this->load->view('dashboard/curator',$data);
                // //$this->load->view('templates/footer');
            } else{

                $data = array(
                    'error_message'=> "It looks like you are not a registered Curator."
                    );

                $this->load->view('templates/header');
                $this->load->view('templates/error_message',$data);
                // //$this->load->view('templates/footer');
            }
    }

    public function profile(){
        
        $typeuser = $this->session->userdata('typeuser');
        if($typeuser == 'curator'){
            $artist_id = $this->session->userdata('profile');
            $user_id = $this->session->userdata('user_id');
            $user = $this->user_model->getUserById($user_id);
                $avatar = '';
                if(!is_null($user->avatar)){
                    $file = $this->db->get_where('file', array('id' =>$user->avatar));
                    foreach ($file->result() as $row) {
                    $$avatar = $row->name;
                    }
                    $query = $this->db->query('SELECT * FROM file WHERE id = '.$user->avatar);
                    $avatar = $query->result_array()[0]['name'];
                }
            $curator_id = $this->curator_model->getCuratorByUserId($user_id);

            $artist = $this->artist_model->getArtistByArtistID($artist_id);
            
            $data = array(
                'avatar'=>$avatar,
                'artist_avatar'=> $artist['avatar'],
                'nickname'=> $artist['nickname'],
                'user_name'=> $user->first_name." ".$user->last_name,
                'manifesto'=> $artist['manifesto'],
                'curator_id'=> $curator_id,
                'artist_id' => $artist_id,
                'gallery' => $this->artist_model->getArtistArtwork($artist['id'],100)
            );
            $gend = 'male';
            if(rand(0,10)>5){
                $gend = 'female';
            }
            $data['gender'] = $gend;

            $this->load->view('templates/header');
            $this->load->view('dashboard/dashboard',$data);
            $this->load->view('dashboard/artist_profile',$data);
            
            // //$this->load->view('templates/footer');
        } else{

                $data = array(
                    'error_message'=> "It looks like you are not a registered Curator."
                    );

                $this->load->view('templates/header');
                $this->load->view('templates/error_message',$data);
                // //$this->load->view('templates/footer');
            }
    }

    public function category(){

        $resp = array();
        $initials = $this->session->userdata('category');

        $artists = $this->curator_model->artistsByCategory($initials);
        $category = $this->category_model->getCategoryByInitials($initials);
        print_r($this->session->userdata('category'));
        foreach($artists as $artist){
            $aux = array();
            $aux['artist'] = $artist;

            $gallery = $this->artist_model->getArtistArtwork($artist['id'],8);
            $aux['gallery'] = $gallery;
            array_push($resp, $aux);
        }

        $user_id = $this->session->userdata('user_id');
        $user = $this->user_model->getUserById($user_id);
        $avatar = '';
                if(!is_null($user->avatar)){
                    $file = $this->db->get_where('file', array('id' =>$user->avatar));
                    foreach ($file->result() as $row) {
                    $$avatar = $row->name;
                    }
                    $query = $this->db->query('SELECT * FROM file WHERE id = '.$user->avatar);
                    $avatar = $query->result_array()[0]['name'];
                }
        $data =  array(
            'artists'=> $resp,
            'avatar'=>$avatar,
            'user_name'=> $user->first_name ." ". $user->last_name,   
            'initial' => $initials,
            'category' => $category);
        $gend = 'male';
                if(rand(0,10)>5){
                    $gend = 'female';
                }
                $data['gender'] = $gend;
         $this->load->view('templates/header');
         $this->load->view('dashboard/dashboard',$data);
         $this->load->view('dashboard/category',$data);
        
    }


    public function favorites(){

        $typeuser = $this->session->userdata('typeuser');
        if($typeuser == 'curator'){

            $resp = array();
            $user_id = $this->session->userdata('user_id');
            $curator_id = $this->curator_model->getCuratorByUserId($user_id);
            $artists = $this->curator_model->getFavorites($curator_id);
            foreach($artists as $artist){
                $aux = array();
                $aux['artist'] = $artist;

                $gallery = $this->artist_model->getArtistArtwork($artist['id'],8);
                $aux['gallery'] = $gallery;
                array_push($resp, $aux);
            }
            $user = $this->user_model->getUserById($user_id);
             $avatar = '';
                if(!is_null($user->avatar)){
                    $file = $this->db->get_where('file', array('id' =>$user->avatar));
                    foreach ($file->result() as $row) {
                    $$avatar = $row->name;
                    }
                    $query = $this->db->query('SELECT * FROM file WHERE id = '.$user->avatar);
                    $avatar = $query->result_array()[0]['name'];
                }
            $data = array(
                'avatar'=>$avatar,
                'user_name'=> $user->first_name ." ". $user->last_name,
                'artists'=> $resp
            );
              $gend = 'male';
            if(rand(0,10)>5){
                $gend = 'female';
            }
            $data['gender'] = $gend;


            $this->load->view('templates/header');
            $this->load->view('dashboard/dashboard',$data);
            $this->load->view('dashboard/curators_favorites',$data);
            // //$this->load->view('templates/footer');
        } else{

                $data = array(
                    'error_message'=> "It looks like you are not a registered Curator."
                    );

                $this->load->view('templates/header');
                $this->load->view('templates/error_message',$data);
                // //$this->load->view('templates/footer');
            }
  }

  public function categories(){

    $categories =  $this->category_model->getCategories();
    $user_id = $this->session->userdata('user_id');
    $artist = $this->artist_model->getArtistByUserID($user_id);

    $user = $this->user_model->getUserById($user_id);
                            
    $data = array(
        'avatar'=>$artist['avatar'],
        'user_name'=> $user->first_name ." ". $user->last_name,
        'categories'=> $categories
    );
    
    $gend = 'male';
    if(rand(0,10)>5){
        $gend = 'female';
    }
    $data['gender'] = $gend;

    $this->load->view('templates/header');
    $this->load->view('dashboard/dashboard',$data);
    $this->load->view('dashboard/categories',$data);
    // //$this->load->view('templates/footer');
  }
   
}

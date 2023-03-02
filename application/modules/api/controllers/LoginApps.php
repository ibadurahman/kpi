<?php
// import library dari REST_Controller
//use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/MR_Controller.php';

// extends class dari REST_Controller
class LoginApps extends MR_Controller{
    
    // constructor
    public function __construct(){
        parent::__construct();
        $this->load->library('authapps');
        $this->load->model('login_api_model'); 
        $this->load->model('apps_model'); 
        $this->lang->load('auth');
    }
    
    // login post
    public function login_post()
    {
        $Header = $this->input->request_headers('Authorization');
        
        $StatCek = $this->_cek_key_token($Header,FALSE);
        if($StatCek['status_key']==1)
        {
            $username=$this->post('username');
            $password=$this->post('password');
            //validasi parameter
            if(!empty($username) and !empty($password))
            {
                
                $dataset = $this->mion_auth->login_app($username, $password, FALSE);
                if($dataset!=FALSE)
                {
                    $user_id=$dataset['user_id'];
                     $key=$Header['KS-API-KEY'];
                     $UserAuth=$this->authapps->generate_user_auth($user_id,$password,$key);
                     $DataToken=$dataset;
                     $DataToken['user_auth']=$UserAuth;
                     $DataToken['status_token']=TRUE;
                     $Token = $this->token->generate_token_jwt($DataToken,$key);
                     $dataset['user_token']=$Token;
                     $update_auth = array(
                         'user_auth'=>$UserAuth
                     );
                     $this->apps_model->update('users','id',$user_id,$update_auth);
                    //set response sukses
                     $this->response([
                          'status' => TRUE,
                          'message' => 'Login success.',
                          'data'      => $dataset
                      ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }
                else
                {
                    //set response
                 $this->response([
                                 'status' => FALSE,
                                 'message' => 'failed to login!'
                             ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
                }
            }
            else
            {
                //set response
                 $this->response([
                                 'status' => FALSE,
                                 'message' => 'Request Failed, Parameter Empty'
                             ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }
        }
        else
        {
            //set response pesan error
            $this->response([
                    'status' => FALSE,
                    'message' => 'Please set API Key!'
                ], REST_Controller::HTTP_FORBIDDEN); // FORBIDDEN (403) being the HTTP response code
        }
    }
    
    // change password post
    public function change_password_post()
    {
        $Header = $this->input->request_headers('Authorization');
        $StatCek = $this->_cek_key_token($Header,TRUE);
        if($StatCek['status_key']==1)
        {
            $Password=$this->post('Password');
            $NewPassword=$this->post('NewPassword');
            //validasi parameter
            if(!empty($Password) and !empty($NewPassword))
            {
                $DataToken = $this->token->decode_token_jwt($Header['USER-TOKEN'],$Header['KS-API-KEY']);
//                echo $DataToken->identity;
//                die();
                $change = $this->mion_auth->change_password($DataToken->identity, $Password, $NewPassword);
                
                if($change)  {      
                    //$this->apps_model->update_Password($NewPassword,'user','Username',$DataToken->username);

                    //CHANGE PASS SUCESS
                    $this->response([
                          'status' => TRUE,
                          'message' => 'Password has been changed'
                      ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                }
                else{
                    //GET LIST EMPTY
                    $this->response([
                                 'status' => FALSE,
                                 'message' => 'wrong password!'
                             ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
                }
            }
            else
            {
                //set response
                 $this->response([
                                 'status' => FALSE,
                                 'message' => 'Request Failed, Parameter Empty'
                             ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }
        }
        else
        {
            //set response pesan error
            $this->response([
                    'status' => FALSE,
                    'message' => 'Please set API Key!'
                ], REST_Controller::HTTP_FORBIDDEN); // FORBIDDEN (403) being the HTTP response code
        }
    }
    // forgot password post

    // recovery change password post
    
    //restrict access
    public function restrict_get()
    {
        $Header = $this->input->request_headers('Authorization');
        $this->get_library_model($Header);
        $StatCek = $this->_cek_key_token($Header);
        if($StatCek['status_key']==1 and $StatCek['status_token']==1)
        {
            //set response sukses
                     $this->response([
                          'status' => TRUE,
                          'message' => 'Request Success'
                      ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }
        else
        {
            //set response pesan error
            $this->response([
                    'status' => FALSE,
                    'message' => 'Please set API Key or token!'
                ], REST_Controller::HTTP_FORBIDDEN); // FORBIDDEN (403) being the HTTP response code
        }
       
    }
    
    //user role
    public function user_role_get()
    {
        $Header = $this->input->request_headers('Authorization');
        $StatCek = $this->_cek_key_token($Header);
        if($StatCek['status_key']==1 and $StatCek['status_token']==1)
        {
            $Result=$this->apps_model->user_role_api();
            //$data=array();
            if($Result->num_rows() > 0)
            {
            //set response sukses
                     $this->response([
                          'status' => TRUE,
                          'message' => 'Request Success',
                          'data'      => $Result->result_array()
                      ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            }else{
                //set response empty
                    
                     $this->response([
                          'status' => FALSE,
                          'message' => 'no data were found'
                      ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
            }
        }
        else
        {
            //set response pesan error
            $this->response([
                    'status' => FALSE,
                    'message' => 'Please set API Key or token!'
                ], REST_Controller::HTTP_FORBIDDEN); // FORBIDDEN (403) being the HTTP response code
        }
       
    }
}
?>
 
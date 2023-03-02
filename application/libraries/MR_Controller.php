<?php

/* 
 * MR_Controller (MY Rest controller)
 * class untuk tambahan dari class rest controller
 * 
 * @Author Zidhni Ilman
 */


require APPPATH . 'libraries/REST_Controller.php';

class MR_Controller extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
        
    }
    protected function _cek_key_token($Header,$StatusCekToken=TRUE)
    {
        $this->load->library('authapps');
        if(isset($Header['KS-API-KEY']))
        {
            //verify API KEY
            if($this->authapps->verify_api_key($Header['KS-API-KEY']))
            {
                //cek key
                $StatusKey=TRUE;
            }
            else
            {
                //cek key
                $StatusKey=FALSE;
                $this->response([
                                'status' => FALSE,
                                'message' => 'Invalid set API Key!'
                            ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
            }
        }
       else
       {
           //set response pesan error
            $StatusKey=FALSE;
            $this->response([
                    'status' => FALSE,
                    'message' => 'Please set API Key!'
                ], REST_Controller::HTTP_FORBIDDEN); // FORBIDDEN (403) being the HTTP response code
       }
       
       $StatusToken=2;
       if($StatusCekToken==TRUE)
       {
            if(isset($Header['USER-TOKEN']))
             {
                 if($this->authapps->verify_user_auth($Header['USER-TOKEN'],$Header['KS-API-KEY']))
                 {
                     $StatusToken=1;
                 }
                 else
                 {
                     $StatusToken=2;
                     $this->response([
                                     'status' => FALSE,
                                     'message' => 'Invalid USER TOKEN!'
                                 ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
                 }
             }
            else
            {
                //set response pesan error
                 $StatusToken=2;
                 $this->response([
                         'status' => FALSE,
                         'message' => 'Please set USER TOKEN!'
                     ], REST_Controller::HTTP_FORBIDDEN); // FORBIDDEN (403) being the HTTP response code
            }
       }
       $DataRespon= ['status_key'=>$StatusKey,'status_token'=>$StatusToken];
       return $DataRespon;
    }
    protected function get_header_db_name($Header)
    {
        if(isset($Header['DB-NAME']))
        {
            return $Header['DB-NAME'];
        }
        else
        {
            return "";
        }
    }
    protected function get_data_login($Header)
    {
        $this->load->library('authapps');
        $DataLogin=$this->authapps->get_user_login($Header['USER-TOKEN'],$Header['KS-API-KEY']);
        if(isset($DataLogin->status_token))
        {
            return $DataLogin;
        }
        else
        {
            return "";
        }
    }
}
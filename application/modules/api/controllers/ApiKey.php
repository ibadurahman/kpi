<?php
// import library dari REST_Controller
//use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/MR_Controller.php';

// extends class dari REST_Controller
class ApiKey extends MR_Controller{
    
    // constructor
    public function __construct(){
        parent::__construct();
    }
    protected function get_library_model($Header){
        
        
        $this->load->library('authapps');
        $this->load->model('api_key_model'); 
    }
    // get
    public function index_get()
    {
       $Header = $this->input->request_headers('Authorization');
       $this->get_library_model($Header);
       if(isset($Header['KS-API-KEY']))
       {
           //verify API KEY
           if($this->authapps->verify_api_key($Header['KS-API-KEY']))
           {
               //proses pencarian data key
               $id = $this->get('id');
               $search = $this->get('search');
               
               if($id!=="" and $id!==NULL)
               {
                   // mencari data key dengan menggunakan id
                   $ResultKey=$this->api_key_model->get_api_key_Id($id);
                   if($ResultKey->num_rows() > 0)
                   {
                       //set response sukses
                        $this->response([
                             'status' => TRUE,
                             'message' => 'Request Success',
                             'data'      => $ResultKey->result_array()
                         ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
                   else
                   {
                       //set response empty
                       
                        $this->response([
                             'status' => FALSE,
                             'message' => 'no data were found'
                         ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                   }
               }
               else if($search!=="" and $search!==NULL)
               {
                   // mencari data key dengan menggunakan search/ like pada nama, key atau id
                   $ResultKey=$this->api_key_model->get_Search_api_key($search);
                   if($ResultKey->num_rows() > 0)
                   {
                       //set response sukses
                        $this->response([
                             'status' => TRUE,
                             'message' => 'Request Success',
                             'data'      => $ResultKey->result_array()
                         ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
                   else
                   {
                       //set response empty
                       
                        $this->response([
                             'status' => FALSE,
                             'message' => 'no data were found'
                         ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                   }
               }
               else
               {
                   //memunculkan semua data
                   $ResultKey=$this->api_key_model->get_Search_api_key();
                   if($ResultKey->num_rows() > 0)
                   {
                       //set response sukses
                        $this->response([
                             'status' => TRUE,
                             'message' => 'Request Success',
                             'data'      => $ResultKey->result_array()
                         ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
                   else
                   {
                       //set response empty
                       
                        $this->response([
                             'status' => FALSE,
                             'message' => 'no data were found'
                         ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                   }
               }
           }
           else
           {
               //set response pesan error
            $this->response([
                    'status' => FALSE,
                    'message' => 'Invalid API Key!'
                ], REST_Controller::HTTP_FORBIDDEN); // FORBIDDEN (403) being the HTTP response code
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
    
    // post
    public function index_post()
    {
        $Header = $this->input->request_headers('Authorization');
        $this->get_library_model($Header);

        if(isset($Header['KS-API-KEY']))
        {
           //verify API KEY
           if($this->authapps->verify_api_key($Header['KS-API-KEY']))
           {
               $key=$this->post('key');
               $pengguna=$this->post('pengguna');
               //validasi parameter
               if(!empty($key) and !empty($pengguna))
               {
                   //input data
                   $JmlData=$this->api_key_model->set_key($key)
                                ->set_pengguna($pengguna)
                                ->set_tgl_input('')
                                ->insert_api_key();
                   if($JmlData>0)
                   {
                       //set response sukses
                        $this->response([
                             'status' => TRUE,
                             'message' => 'New Key has been created.'
                         ], REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
                   }
                   else
                   {
                       //set response
                    $this->response([
                                    'status' => FALSE,
                                    'message' => 'failed to create new data!'
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
                    'message' => 'Invalid API Key!'
                ], REST_Controller::HTTP_FORBIDDEN); // FORBIDDEN (403) being the HTTP response code
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
    // put
    public function index_put($id="")
    {
        $Header = $this->input->request_headers('Authorization');
        $this->get_library_model($Header);
       
        if(isset($Header['KS-API-KEY']))
        {
           //verify API KEY
           if($this->authapps->verify_api_key($Header['KS-API-KEY']))
           {
               $key=$this->put('key');
               $pengguna=$this->put('pengguna');
               
               //validasi parameter
               if(!empty($key) and !empty($pengguna) and !empty($id))
               {
                   //input data
                   $JmlData=$this->api_key_model->set_key($key)
                                ->set_pengguna($pengguna)
                                ->update_api_key('id',$id);
                   if($JmlData>0)
                   {
                       //set response sukses
                        $this->response([
                             'status' => TRUE,
                             'message' => 'Key has been updated.'
                         ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
                   else
                   {
                       //set response
                    $this->response([
                                    'status' => FALSE,
                                    'message' => 'failed to update data!'
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
                    'message' => 'Invalid API Key!'
                ], REST_Controller::HTTP_FORBIDDEN); // FORBIDDEN (403) being the HTTP response code
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
    
    // delete
    
    public function index_delete($id="")
    {
        $Header = $this->input->request_headers('Authorization');
        $this->get_library_model($Header);
       
       if(isset($Header['KS-API-KEY']))
       {
           //verify API KEY
           if($this->authapps->verify_api_key($Header['KS-API-KEY']))
           {
               //$id=$this->delete('id');
               
               //validasi parameter
               if( !empty($id))
               {
                   //input data
                   $JmlData=$this->api_key_model->delete_api_key('id',$id);
                   if($JmlData>0)
                   {
                       //set response sukses
                        $this->response([
                             'status' => TRUE,
                             'message' => 'Key has been deleted.'
                         ], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                   }
                   else
                   {
                       //set response
                    $this->response([
                                    'status' => FALSE,
                                    'message' => 'id not found!'
                                ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
                   }
               }
               else
               {
                   //set response
                    $this->response([
                                    'status' => FALSE,
                                    'message' => 'provide an id!'
                                ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
               }
               
           }
           else
           {
               //set response pesan error
            $this->response([
                    'status' => FALSE,
                    'message' => 'Invalid API Key!'
                ], REST_Controller::HTTP_FORBIDDEN); // FORBIDDEN (403) being the HTTP response code
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


}
?>
 
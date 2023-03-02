<?php
// import library dari REST_Controller
//use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/MR_Controller.php';

// extends class dari REST_Controller
class BdApi extends MR_Controller{
    
    // constructor
    public function __construct(){
        parent::__construct();
        $this->load->library('authapps');
        $this->load->model('business_Driver_api_model'); 
        $this->lang->load('auth');
    }
    // get list score perspective
    public function list_business_driver_get()
    {
        $Header = $this->input->request_headers('Authorization');
        $StatCek = $this->_cek_key_token($Header);
        if($StatCek['status_key']==1 and $StatCek['status_token']==1)
        {
            //proses pencarian data pegawai
            $kd_perspective = $this->get('kd_perspective');
            $bulan = $this->get('bulan');
            $tahun = $this->get('tahun');
            
            if($kd_perspective!=="" and $kd_perspective!==NULL)
            {
                if($bulan=="")$bulan=date('m');
                if($tahun=="")$tahun=date('Y');
                // mencari data profil pegawai
                $Result=$this->business_Driver_api_model->get_list_business_driver($kd_perspective,$tahun,$bulan);
                if($Result->num_rows() > 0)
                {
                    //var_dump($Result->result_array());
                    //set response sukses
                     $this->response([
                          'status' => TRUE,
                          'message' => 'Request Success',
                          'data'      => $Result->result_array()
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
                $this->response([
                                 'status' => FALSE,
                                 'message' => 'provide a kd_perusahaan!'
                             ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
               
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
    // get detail score perspective
    public function detail_score_business_driver_get()
    {
        $Header = $this->input->request_headers('Authorization');
        $StatCek = $this->_cek_key_token($Header);
        if($StatCek['status_key']==1 and $StatCek['status_token']==1)
        {
            //proses pencarian data pegawai
            $kd_bd = $this->get('kd_bd');
            $tahun = $this->get('tahun');
            
            if($kd_bd!=="" and $kd_bd!==NULL)
            {
                if($tahun=="")$tahun=date('Y');
                // mencari data profil pegawai
                $Result=$this->business_Driver_api_model->get_point_business_driver_detail($kd_bd,$tahun);
                if($Result->num_rows() > 0)
                {
                    $kd_temp="";
                    $data_result=array();
                    $no=-1;
                    $no_detail=0;
                    foreach($Result->result() as $row){
                        if($row->kd_bd!="$kd_temp"){
                            $no++;
                            $no_detail=0;
                            $kd_temp=$row->kd_bd;
                            $data_result[$no]["kd_bd"]=$row->kd_bd;
                            $data_result[$no]["kd_bds"]=$row->kd_bds;
                            $data_result[$no]["nm_bd"]=$row->nm_bd;
                        }
                        $data_result[$no]['list_data'][$no_detail]['bulan']=$row->bulan;
                        $data_result[$no]['list_data'][$no_detail]['tahun']=$row->tahun;
                        $data_result[$no]['list_data'][$no_detail]['gross_point_kpi']=$row->gross_point_bulan;
                        $data_result[$no]['list_data'][$no_detail]['weightage']=$row->weightage;
                        $data_result[$no]['list_data'][$no_detail]['point_kpi']=$row->point_bulan;
                        $no_detail++;
                    }
                    //set response sukses
                     $this->response([
                          'status' => TRUE,
                          'message' => 'Request Success',
                          'data'      => $data_result
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
                $this->response([
                                 'status' => FALSE,
                                 'message' => 'provide a nip!'
                             ], REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
               
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
 
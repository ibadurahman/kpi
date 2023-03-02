<?php
// import library dari REST_Controller
//use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/MR_Controller.php';

// extends class dari REST_Controller
class KpiApi extends MR_Controller{
    
    // constructor
    public function __construct(){
        parent::__construct();
        $this->load->library('authapps');
        $this->load->model('appraisal_api_model'); 
        $this->load->model('ps_api_model'); 
        $this->lang->load('auth');
    }
    // get score perusahaan
    public function score_perusahaan_get()
    {
        $Header = $this->input->request_headers('Authorization');
        $StatCek = $this->_cek_key_token($Header);
        if($StatCek['status_key']==1 and $StatCek['status_token']==1)
        {
            //proses pencarian data pegawai
            $kd_perusahaan = $this->get('kd_perusahaan');
            $bulan = $this->get('bulan');
            $tahun = $this->get('tahun');
            if($kd_perusahaan!=="" and $kd_perusahaan!==NULL)
            {
                if($bulan=="")$bulan=date('m');
                if($tahun=="")$tahun=date('Y');
                // mencari data profil pegawai
                //$Result=$this->appraisal_api_model->get_point_perusahaan($kd_perusahaan,$tahun,$bulan);
                $Result=$this->ps_api_model->get_perusahaan_kpi($kd_perusahaan,$tahun,$bulan);
                $data=array();
                if($Result->num_rows() > 0)
                {
                    $data=$Result->result_array();
                    $Result_chart=$this->ps_api_model->get_perusahaan_kpi_chart_periode($kd_perusahaan,$tahun,$bulan);
                    if($Result_chart->num_rows() > 0)
                    {
                        $data[0]['detail_chart']=$Result_chart->result_array();
                    }
                    $Result_detail=$this->ps_api_model->dashboard_perspective_bulanan($kd_perusahaan,$tahun,$bulan);
                    if($Result_detail->num_rows() > 0)
                    {
                        $data[0]['detail_kpi']=$Result_detail->result_array();
                    }
                    $chart_ps=$this->ps_api_model->get_perspective_bar_chart_bulan($kd_perusahaan,$tahun,$bulan);
                    if(count($chart_ps) > 0)
                    {
                        $data[0]['chart_perspective']=$chart_ps;
                    }
                    //set response sukses
                     $this->response([
                          'status' => TRUE,
                          'message' => 'Request Success',
                          'data'      => $data
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
    // get list score perspective
    public function list_perspective_get()
    {
        $Header = $this->input->request_headers('Authorization');
        $StatCek = $this->_cek_key_token($Header);
        if($StatCek['status_key']==1 and $StatCek['status_token']==1)
        {
            //proses pencarian data pegawai
            $kd_perusahaan = $this->get('kd_perusahaan');
            $bulan = $this->get('bulan');
            $tahun = $this->get('tahun');
            
            if($kd_perusahaan!=="" and $kd_perusahaan!==NULL)
            {
                if($bulan=="")$bulan=date('m');
                if($tahun=="")$tahun=date('Y');
                // mencari data profil pegawai
                $Result=$this->appraisal_api_model->get_perspective($kd_perusahaan,$tahun,$bulan);
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
    public function detail_score_perspective_get()
    {
        $Header = $this->input->request_headers('Authorization');
        $StatCek = $this->_cek_key_token($Header);
        if($StatCek['status_key']==1 and $StatCek['status_token']==1)
        {
            //proses pencarian data pegawai
            $kd_perspective = $this->get('kd_perspective');
            $tahun = $this->get('tahun');
            
            if($kd_perspective!=="" and $kd_perspective!==NULL)
            {
                if($tahun=="")$tahun=date('Y');
                // mencari data profil pegawai
                $Result=$this->appraisal_api_model->get_point_perspective_detail($kd_perspective,$tahun);
                if($Result->num_rows() > 0)
                {
                    $kd_temp="";
                    $data_result=array();
                    $no=-1;
                    $no_detail=0;
                    foreach($Result->result() as $row){
                        if($row->kd_perspective!="$kd_temp"){
                            $no++;
                            $no_detail=0;
                            $kd_temp=$row->kd_perspective;
                            $data_result[$no]["kd_perspective"]=$row->kd_perspective;
                            $data_result[$no]["kd_ps"]=$row->kd_ps;
                            $data_result[$no]["nm_perspective"]=$row->nm_perspective;
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
    
    // get list bawahan
    public function score_perusahaan_detail_get()
    {
        $Header = $this->input->request_headers('Authorization');
        $StatCek = $this->_cek_key_token($Header);
        if($StatCek['status_key']==1 and $StatCek['status_token']==1)
        {
            //proses pencarian data pegawai
            $kd_perusahaan = $this->get('kd_perusahaan');
            $tahun = $this->get('tahun');
            
            if($kd_perusahaan!=="" and $kd_perusahaan!==NULL)
            {
                if($tahun=="")$tahun=date('Y');
                // mencari data profil pegawai
                $Result=$this->appraisal_api_model->get_point_perusahaan_detail($kd_perusahaan,$tahun);
                if($Result->num_rows() > 0)
                {
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
    // get score perspective
    public function data_perspective_get()
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
                //$Result=$this->appraisal_api_model->get_point_perusahaan($kd_perusahaan,$tahun,$bulan);
                $Result=$this->ps_api_model->get_perspective_by_kd_perspective($kd_perspective,$tahun,$bulan);
                $data=array();
                if($Result->num_rows() > 0)
                {
                    $data=$Result->result_array();
                    $Result_chart=$this->ps_api_model->get_perspective_bar_chart_bulan_kd_perspective($kd_perspective,$tahun,$bulan);
                    if(count($Result_chart) > 0)
                    {
                        $data[0]['detail_chart']=$Result_chart;
                    }
                    $Result_detail=$this->ps_api_model->perspective_bd_bulanan($kd_perspective,$tahun,$bulan);
                    if($Result_detail->num_rows() > 0)
                    {
                        $data[0]['detail_business_driver']=$Result_detail->result_array();
                    }
                    
                    //set response sukses
                     $this->response([
                          'status' => TRUE,
                          'message' => 'Request Success',
                          'data'      => $data
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
    // get score business driver
    public function data_bd_get()
    { 
        $this->load->model('bd_api_model'); 
        $Header = $this->input->request_headers('Authorization');
        $StatCek = $this->_cek_key_token($Header);
        if($StatCek['status_key']==1 and $StatCek['status_token']==1)
        {
            //proses pencarian data pegawai
            $kd_bd = $this->get('kd_bd');
            $bulan = $this->get('bulan');
            $tahun = $this->get('tahun');
            if($kd_bd!=="" and $kd_bd!==NULL)
            {
                if($bulan=="")$bulan=date('m');
                if($tahun=="")$tahun=date('Y');
                // mencari data profil pegawai
                //$Result=$this->appraisal_api_model->get_point_perusahaan($kd_perusahaan,$tahun,$bulan);
                $Result=$this->bd_api_model->get_bd_by_code_bulanan_api($kd_bd,$tahun,$bulan);
                $data=array();
                if($Result->num_rows() > 0)
                {
                    $data=$Result->result_array();
                    $Result_chart=$this->bd_api_model->get_list_score_bd_rekap_setahun_chart_api($kd_bd,$tahun,$bulan);
                    if(count($Result_chart) > 0)
                    {
                        $data[0]['detail_chart']=$Result_chart;
                    }
                    $Result_detail=$this->bd_api_model->get_ms_bd_bulanan_api($kd_bd,$tahun,$bulan);
                    if(count($Result_detail) > 0)
                    {
                        $data[0]['detail_measurement']=$Result_detail;
                    }
                    
                    //set response sukses
                     $this->response([
                          'status' => TRUE,
                          'message' => 'Request Success',
                          'data'      => $data
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
    // get score measurement
    public function data_ms_get()
    { 
        $this->load->model('ms_api_model'); 
        $Header = $this->input->request_headers('Authorization');
        $StatCek = $this->_cek_key_token($Header);
        if($StatCek['status_key']==1 and $StatCek['status_token']==1)
        {
            //proses pencarian data pegawai
            $kd_measurement = $this->get('kd_measurement');
            $bulan = $this->get('bulan');
            $tahun = $this->get('tahun');
            if($kd_measurement!=="" and $kd_measurement!==NULL)
            {
                if($bulan=="")$bulan=date('m');
                if($tahun=="")$tahun=date('Y');
                // mencari data profil pegawai
                //$Result=$this->appraisal_api_model->get_point_perusahaan($kd_perusahaan,$tahun,$bulan);
                $Result=$this->ms_api_model->get_ms_by_code_bulanan_api($kd_measurement,$tahun,$bulan);
                $data=array();
                if($Result->num_rows() > 0)
                {
                    $data=$Result->result_array();
                    $Result_chart=$this->ms_api_model->get_list_score_ms_rekap_setahun_chart_api($kd_measurement,$tahun,$bulan);
                    if(count($Result_chart) > 0)
                    {
                        $data[0]['detail_chart']=$Result_chart;
                    }
                    $Result_detail=$this->ms_api_model->get_dept_ms_bulanan_api($kd_measurement,$tahun,$bulan);
                    if(count($Result_detail) > 0)
                    {
                        $data[0]['list_departemen']=$Result_detail;
                    }
                    
                    //set response sukses
                     $this->response([
                          'status' => TRUE,
                          'message' => 'Request Success',
                          'data'      => $data
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
    // get score departemen
    public function data_dept_get()
    { 
        $this->load->model('dept_api_model'); 
        $Header = $this->input->request_headers('Authorization');
        $StatCek = $this->_cek_key_token($Header);
        if($StatCek['status_key']==1 and $StatCek['status_token']==1)
        {
            
            $kd_departemen = $this->get('kd_departemen');
            $bulan = $this->get('bulan');
            $tahun = $this->get('tahun');
            if($kd_departemen!=="" and $kd_departemen!==NULL)
            {
                if($bulan=="")$bulan=date('m');
                if($tahun=="")$tahun=date('Y');
                // mencari data profil pegawai
                //$Result=$this->appraisal_api_model->get_point_perusahaan($kd_perusahaan,$tahun,$bulan);
                $Result=$this->dept_api_model->get_dept_by_code_bulanan_api($kd_departemen,$tahun,$bulan);
                $data=array();
                if($Result->num_rows() > 0)
                {
                    $data=$Result->result_array();
                    $Result_chart=$this->dept_api_model->get_list_score_dept_rekap_setahun_chart_api($kd_departemen,$tahun,$bulan);
                    if(count($Result_chart) > 0)
                    {
                        $data[0]['detail_chart']=$Result_chart;
                    }
                    $Result_detail=$this->dept_api_model->get_dept_detail_ms_bulanan_api($kd_departemen,$tahun,$bulan);
                    if(count($Result_detail) > 0)
                    {
                        $data[0]['list_measurement']=$Result_detail;
                    }
                    
                    //set response sukses
                     $this->response([
                          'status' => TRUE,
                          'message' => 'Request Success',
                          'data'      => $data
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
}
?>
 
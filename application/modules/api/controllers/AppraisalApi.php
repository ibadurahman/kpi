<?php
// import library dari REST_Controller
//use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/MR_Controller.php';

// extends class dari REST_Controller
class AppraisalApi extends MR_Controller{
    
    // constructor
    public function __construct(){
        parent::__construct();
        $this->load->library('authapps');
        $this->load->model('appraisal_api_model'); 
        $this->lang->load('auth');
    }
    // get profil
    public function profile_get()
    {
        $Header = $this->input->request_headers('Authorization');
        $StatCek = $this->_cek_key_token($Header);
        if($StatCek['status_key']==1 and $StatCek['status_token']==1)
        {
            //proses pencarian data pegawai
            $nip = $this->get('nip');
            $bulan = $this->get('bulan');
            $tahun = $this->get('tahun');
            
            if($nip!=="" and $nip!==NULL)
            {
                if($bulan=="")$bulan=date('m');
                if($tahun=="")$tahun=date('Y');
                
                // mencari data profil pegawai
                $Result=$this->appraisal_api_model->get_profil_pegawai($nip,$tahun,$bulan);
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
    // get list bawahan
    public function list_bawahan_pegawai_get()
    {
        $Header = $this->input->request_headers('Authorization');
        $StatCek = $this->_cek_key_token($Header);
        if($StatCek['status_key']==1 and $StatCek['status_token']==1)
        {
            //proses pencarian data pegawai
            $nip = $this->get('nip');
            $bulan = $this->get('bulan');
            $tahun = $this->get('tahun');
            
            if($nip!=="" and $nip!==NULL)
            {
                if($bulan=="")$bulan=date('m');
                if($tahun=="")$tahun=date('Y');
                // mencari data profil pegawai
                $Result=$this->appraisal_api_model->get_list_pegawai_report_to($nip,$tahun,$bulan);
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
    // get detail kpi pegawai
    public function detail_kpi_pegawai_get()
    {
        $Header = $this->input->request_headers('Authorization');
        $StatCek = $this->_cek_key_token($Header);
        if($StatCek['status_key']==1 and $StatCek['status_token']==1)
        {
            //proses pencarian data pegawai
            $nip = $this->get('nip');
            $bulan = $this->get('bulan');
            $tahun = $this->get('tahun');
            
            if($nip!=="" and $nip!==NULL)
            {
                if($bulan=="")$bulan=date('m');
                if($tahun=="")$tahun=date('Y');
                // mencari data profil pegawai
                // $Result=$this->appraisal_api_model->get_detail_kpi_pegawai($nip,$tahun,$bulan);
                $Result=$this->appraisal_api_model->get_profil_pegawai_api($nip,$tahun,$bulan);
                $ResultDetailKPI=$this->appraisal_api_model->get_peg_kpi_perbulan_api($nip,$tahun,$bulan);
                // $ResultChart=$this->appraisal_api_model->get_peg_kpi_rekap_setahun_api($nip,$tahun,$bulan);
                $ResultChart=$this->appraisal_api_model->get_peg_kpi_rekap_setahun_api2($nip,$tahun,$bulan);
                if($Result->num_rows() > 0)
                {
                    $kd_ap_temp="";
                    $data_result=array();
                    $no=-1;
                    $no_detail=0;
                    foreach($Result->result() as $row){
                        // if($row->kd_appraisal!="$kd_ap_temp"){
                            $no++;
                            $no_detail=0;
                            // $kd_ap_temp=$row->kd_appraisal;
                            // $data_result[$no]["kd_appraisal"]=$row->kd_appraisal;
                            $data_result[$no]["nip"]=$row->nip;
                            $data_result[$no]["nama"]=$row->nama;
                            // $data_result[$no]["bulan"]=$row->bulan;
                            $data_result[$no]["bulan"]=$bulan;
                            // $data_result[$no]["tahun"]=$row->tahun;
                            $data_result[$no]["tahun"]=$tahun;
                            $data_result[$no]["kd_departemen"]=$row->kd_departemen;
                            $data_result[$no]["nm_departemen"]=$row->nm_departemen;
                            $data_result[$no]["kd_jabatan"]=$row->kd_jabatan;
                            $data_result[$no]["nm_jabatan"]=$row->nm_jabatan;
                            $data_result[$no]["score_bln"]=$row->score_bulan;
                            $data_result[$no]["score_thn"]=$row->score_tahun;
                        // }
                        // $data_result[$no]['list_measurement'][$no_detail]['kd_measurement']=$row->kd_measurement;
                        // $data_result[$no]['list_measurement'][$no_detail]['nm_measurement']=$row->nm_measurement;
                        // $data_result[$no]['list_measurement'][$no_detail]['point_kpi']=$row->point_kpi;
                        // $no_detail++;
                    }
                    foreach($ResultDetailKPI->result() as $row){
                        $data_result[$no]["kd_appraisal"]=$row->kd_appraisal;
                        $detail[$no_detail]['kd_measurement']=$row->kd_measurement;
                        $detail[$no_detail]['nm_measurement']=$row->nm_measurement;
                        $detail[$no_detail]['gross_point_kpi']=$row->point_result;
                        $detail[$no_detail]['weightage']=$row->weightage_kpi;
                        $detail[$no_detail]['point_kpi']=$row->score_kpi;
                        $no_detail++;
                    }
                    $no_detail=0;
                    foreach($ResultChart->result() as $row){
                        $detailChart[$no_detail]['periode']=getNamaBulanMin($row->bulan)." ".substr($row->tahun,2);
                        $detailChart[$no_detail]['score']=$row->score_point;
                        $no_detail++;
                    }
                    $data_result[$no]['list_measurement']=$detail;
                    $data_result[$no]['detail_chart']=$detailChart;
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
    public function kpi_pegawai_setahun_get()
    {
        $Header = $this->input->request_headers('Authorization');
        $StatCek = $this->_cek_key_token($Header);
        if($StatCek['status_key']==1 and $StatCek['status_token']==1)
        {
            //proses pencarian data pegawai
            $nip = $this->get('nip');
            $tahun = $this->get('tahun');
            
            if($nip!=="" and $nip!==NULL)
            {
                if($tahun=="")$tahun=date('Y');
                // mencari data profil pegawai
                $Result=$this->appraisal_api_model->get_kpi_pegawai_setahun($nip,$tahun);
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
    // post insert foto
    public function upload_foto_post()
    {
        $Upload_Path = realpath(APPPATH."../assets/upload/foto");
        $Upload_Path_user = realpath(APPPATH."../assets/upload/foto_user");
        
        $Header = $this->input->request_headers('Authorization');
        $StatCek = $this->_cek_key_token($Header);
        if($StatCek['status_key']==1 and $StatCek['status_token']==1)
        {
            $DataLogin = $this->get_data_login($Header);
//            var_dump($DataLogin);
//            die();
            if (!empty($_FILES['image']['name']) and $DataLogin!="") {
    //            if($this->input->post('KodeReward')){
    //                $KodeReward=$this->input->post('KodeReward');
    //            }
                if($DataLogin->login_nip!=""){
                    $Path=$Upload_Path;
                    $FileName='foto'.$DataLogin->login_nip.date("ymd").rand(10, 99);
                }else{
                    $Path=$Upload_Path_user;
                    $FileName='foto'.$DataLogin->user_id.date("ymd").rand(10, 99);
                }
                $config=array(
                            'allowed_types'   => 'jpg|jpeg|gif|png',
                            'upload_path'   => $Path,
                            'file_name'     => $FileName,
                                'overwrite' => TRUE,
                            'max_size'      => 2000 // 2mb
                        );
                $this->load->library('upload',$config);
                if ( ! $this->upload->do_upload('image')){
                    $Data['error'] = $this->upload->display_errors('','');
                    $error['image']=$Data['error'];
                    //set response
                    $this->response([
                                 'status' => FALSE,
                                 'message' => 'error validation',
                                 'data'     => $error
                             ], REST_Controller::HTTP_BAD_REQUEST);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $Foto=$upload_data['file_name'];
                    //$Input['foto']=$Foto;
                    $FotoLama="";
                    if($DataLogin->login_nip!=""){
                        $DataPegawai=$this->appraisal_api_model->get_pegawai_api($DataLogin->login_nip);
                        if($DataPegawai->num_rows()>0){
                            $FotoLama=$DataPegawai->row()->foto;
                        }
                        $Input = array(
                                'foto' => $Foto,
                                );
                        $this->appraisal_api_model->update_pegawai_api($DataLogin->login_nip,$Input);
                    }else{
                        $DataUser=$this->appraisal_api_model->get_users_api($DataLogin->user_id);
                        if($DataUser->num_rows()>0){
                            $FotoLama=$DataUser->row()->image;
                        }
                        $Input = array(
                                'image' => $Foto,
                                );
                        $this->appraisal_api_model->update_users_api($DataLogin->user_id,$Input);
                    }
                    if($FotoLama!=""){
                        $Path=$Path.'/'.$FotoLama;
                        unlink($Path);
                    }
                    //set response sukses
                         $this->response([
                              'status' => TRUE,
                              'message' => 'image has been updated.'
                          ], REST_Controller::HTTP_CREATED);
                }
            }else{
                $this->response([
                                 'status' => FALSE,
                                 'message' => 'provide a image!'
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
 
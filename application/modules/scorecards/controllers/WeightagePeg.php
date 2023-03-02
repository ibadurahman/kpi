<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class WeightagePeg extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('scorecards/WeightagePeg',$siteLang);
            $this->load->model('weightage_peg_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/scorecards/WeightagePeg');
            $this->kd_perusahaan = $this->session->userdata('ses_perusahaan');
            $this->ses_nip = $this->session->userdata('ses_nip');
    }
    
    //list appraisal
    public function index()
    {
        $Data["title_web"]=$this->lang->line('title_web');
        $Data["subheader"]=$this->lang->line('subheader');
        $Data["list_header"]=$this->lang->line('list_header');
        $Data["input_header"]=$this->lang->line('input_header');
        $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
        $Data['AlertInput']=$this->session->flashdata('AlertInput');
        $Data['data_uri']= "scorecards/WeightagePeg/index";
     
        
        //insert user activity
        $this->useractivity->run_acitivity('index '.$this->lang->line('subheader'));
            
        $this->template->temp_default();
        $this->template->add_section('viewjs', 'scorecards/WeightagePeg_vf/v_WeightagePeg_js',$Data);
        $this->load->view('WeightagePeg_vf/v_WeightagePeg',$Data);
        //die();
    }
    //get list appraisal json
    public function get_list()
    {
                    $addsql = array();

                    $request = '';
                    $custom_whare="";
                    if($this->mion_auth->is_admin()){
                        $table = " 
                                (SELECT pk.kd_pk,
                                            pk.nip as nip,
                                                pg.nama,
                                                pk.bulan,
                                                pk.tahun,
                                                group_concat(concat(ms.nm_measurement,' (',ifnull(ROUND(((pd.weightage_kpi/tb.TotalBobot)*100),0),0),'%)')) AS nm_ms
                                    FROM pegawai_kpi pk
                                    INNER JOIN pegawai_kpi_d pd ON pk.kd_pk = pd.kd_pk
                                    INNER JOIN pegawai pg ON pk.nip = pg.nip 
                                    INNER JOIN measurement ms ON pd.kd_measurement = ms.kd_measurement
                                    INNER JOIN (
                                        SELECT pd.kd_pk, SUM(pd.weightage_kpi) TotalBobot
                                        FROM pegawai_kpi_d pd
                                        GROUP BY pd.kd_pk
                                    )tb ON tb.kd_pk = pk.kd_pk 
                                    WHERE pg.kd_perusahaan = '".$this->kd_perusahaan."'
                                    GROUP BY pk.kd_pk,
                                                pk.nip,
                                                pg.nama,
                                                pk.bulan,
                                                pk.tahun
                               )as tbl_pegawai
                        ";
                    }else{
                        $table = " 
                                (SELECT pk.kd_pk,
                                            pk.nip as nip,
                                            pg.nama,
                                            pk.bulan,
                                            pk.tahun,
                                            group_concat(concat(ms.nm_measurement,' (',ifnull(ROUND(((pd.weightage_kpi/tb.TotalBobot)*100),0),0),'%)')) AS nm_ms
                                FROM pegawai_kpi pk
                                INNER JOIN pegawai_kpi_d pd ON pk.kd_pk = pd.kd_pk
                                INNER JOIN pegawai pg ON pk.nip = pg.nip 
                                INNER JOIN measurement ms ON pd.kd_measurement = ms.kd_measurement
                                INNER JOIN (
                                    SELECT pd.kd_pk, SUM(pd.weightage_kpi) TotalBobot
                                    FROM pegawai_kpi_d pd
                                    GROUP BY pd.kd_pk
                                )tb ON tb.kd_pk = pk.kd_pk 
                                WHERE pg.report_to = '".$this->session->userdata('login_nip')."'
                                GROUP BY pk.kd_pk,
                                            pk.nip,
                                            pg.nama,
                                            pk.bulan,
                                            pk.tahun
                                )as tbl_pegawai

                        ";
                    }
                    $primaryKey = 'tbl_pegawai.nip';
                    $columns = array(
                            array( 
                                    'NO', 
                                    'dt' => 0 ,
                                    'searchable' => FALSE
                            ),
                            array(
                                    'db' => 'tbl_pegawai.nip',
                                    'dt' => 1,
                            ),
                            array(
                                    'db' => 'tbl_pegawai.nama',
                                    'dt' => 2,
                            ),
                            array( 
                                    'db' => 'tbl_pegawai.bulan', 
                                    'dt' => 3,
                                    'default_value' => '',
                                    'formatter' => function( $d, $row ) {
                                                return getNamaBulan($d);
                                            }
                            ),
                            array(
                                    'db' => 'tbl_pegawai.tahun',
                                    'dt' => 4,
                            ),
                            array(
                                    'db' => 'tbl_pegawai.nm_ms',
                                    'dt' => 5,
                                    'default_value' => '',
                                    'formatter' => function( $d, $row ) {
                                                $data=explode(',',$d);
                                                $ms="";
                                                $no=1;
                                                foreach($data as $val){
                                                    $ms .=$no.". ".$val."<br/>";
                                                    $no++;
                                                }
                                                return $ms;
                                            }
                            ),
                            array(
                                    'db' => 'tbl_pegawai.kd_pk',
                                    'dt' => 6,
                            )

                    );

                    $a_condition = array();
                    $a_condition_type = array(); 
                    $a_link = array();
                    $a_src = array();
                    $a_src_change = array();
                    
                    $a_link['View'] = '<a href="'. site_url('scorecards/WeightagePeg/view_form/').'#action_lock_2#" class="#link_class#" title="#link_title#"><i class="la la-file-text"></i></a>';
                    $a_src['View'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupView';
                    
                             
                    // if($this->mion_auth->is_allowed('edit_weightage_company')) {
                    //         $a_link['edit'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-edit"></i></a>';
                    //         $a_src['edit'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupEdit';
                    // }
                    if($this->mion_auth->is_allowed('delete_weightage_peg')) { 
                            $a_link['Delete'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock_2#"><i class="la la-trash"></i></a>';
                            $a_src['Delete'] = 'm-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-data';
                    }
                    //add to ajax columns
                    $columns[] = array(
                                    'action',
                                    'searchable' => FALSE,
                                    'dt'=>7,
                                    'condition'=>$a_condition,
                                    'condition_type'=>$a_condition_type,
                                    'action_link'=>$a_link,
                                    'action_src'=>$a_src,
                                    'action_src_change'=>$a_src_change,
                                    'action_lock'=>'nip',
                                    'action_lock_2'=>'kd_pk'
                            );

                    // manual ordering at the first page load (server side)
                    if( $_GET['order'][0]['column'] == 0)
                    {
                            $_GET['order'][0]['column'] = '4';
                            $_GET['order'][0]['dir'] = 'desc';
                            $_GET['order'][1]['column'] = '3';
                            $_GET['order'][1]['dir'] = 'desc';
                    }

                    //
                    echo json_encode(
                            SSP::simple( $_GET, $table, $primaryKey, $columns,$custom_whare)
                    );
    }
    public function insert_form()
    {   
        if($this->mion_auth->is_allowed('add_weightage_peg')){
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader');
            $Data["input_header"]=$this->lang->line('input_header');
            $this->breadcrumbs->push($this->lang->line('input_header'), '/scorecards/WeightagePeg/insert_form');
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['AlertInput']=$this->session->flashdata('AlertInput');

            $DataPeg=$this->weightage_peg_model->get_pegawai_order_dept($this->kd_perusahaan,$this->session->userdata('login_nip'),$this->mion_auth->is_admin());
            $Data['DataPeg']=  $DataPeg;
            $LTahun=ListTahunBerjalan($this->config->item('year_apps'));
            krsort($LTahun);
            $Data['ListTahun']= $LTahun;
            $Data['ListBulan']= ListBulan();

            $this->template->temp_default();
            $this->template->add_section('viewjs', 'scorecards/WeightagePeg_vf/v_WeightagePeg_js');
            $this->load->view('WeightagePeg_vf/v_WeightagePeg_input_SelectPeg',$Data);
        }
        else
        {
            $Data['text_error']=$this->lang->line('not_access');
            $this->template->temp_default();
            $this->template->add_section('t_alert', 'alert_error',$Data);
        }
    }
    public function save_select_peg()
    {
        $Data=["success"=>false,"messages"=>array(),'link'=>'insert_form_ms'];
        
        $this->form_validation->set_rules('tahun', $this->lang->line('tahun_efektif'), 'trim|required');
        $this->form_validation->set_rules('bulan', $this->lang->line('bulan_efektif'), 'trim|required');
        $this->form_validation->set_rules('deskripsi', $this->lang->line('deskripsi'), 'trim|required');
        //$this->form_validation->set_rules('weightage_bd[]', $this->lang->line('weightage_bd'), 'trim|required');
        $this->form_validation->set_rules('nip[]', $this->lang->line('nama'), 'required');
       $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        $errorKode=true;
        $errorNIP=FALSE;
        $ListNIP=$this->input->post('nip');
        if(count($ListNIP)>0){
            $errorNIP=TRUE;
            foreach($ListNIP as $nip){
                // echo $nip."<br/>";
                $errorKode=$this->_CekKodePegawaiKPI($nip,$this->input->post('bulan'),$this->input->post('tahun'));
            }
        }
        if ($this->form_validation->run() == FALSE or $errorKode==FALSE or $errorNIP==FALSE ){
//                echo form_error('weightage[]');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
                
            }
            if($errorNIP==FALSE){
                $Data['messages']['nip']= '<div class="form-control-feedback text-error">'.$this->lang->line('error_select_peg').'</div>';
            }
            if($errorKode==FALSE){
                $Data['messages']['nip']= $this->lang->line('error_bulan_tahun_exist');
            }
        }else{
            //die;
            $DataInput=[
                'BlnEfektif'=>$this->input->post('bulan'),
                'ThnEfektif'=>$this->input->post('tahun'),
                'Deskripsi'=>$this->input->post('deskripsi'),
                'ListNIP'=>$ListNIP
            ];
            $dataJson=json_encode($DataInput);
            $this->session->set_flashdata('DataSelectPeg', $dataJson);
            // $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
            $Data["success"]=true;

        }
        
        echo json_encode($Data);
    }
    //cek exist bulan tahun Pegawai KPI
    public function _CekKodePegawaiKPI($nip,$bulan,$tahun){
        $this->load->model('organisasi/pegawai_model');
        $Data=$this->pegawai_model->get_pegawai_kpi_header_by_bulan_tahun($nip,$bulan,$tahun)->num_rows();
            if($Data>0){
                $this->form_validation->set_message('_CekKode', $this->lang->line('error_kode'));
                return FALSE;
            }else{
                return TRUE;
            }
        
    }
    public function insert_form_ms()
    {   
        if($this->mion_auth->is_allowed('add_weightage_peg')){
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader');
            $Data["input_header"]=$this->lang->line('input_header');
            $this->breadcrumbs->push($this->lang->line('input_header'), '/scorecards/WeightagePeg/insert_form');
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['AlertInput']=$this->session->flashdata('AlertInput');
            $DataSelectPeg=$this->session->flashdata('DataSelectPeg');

            if($DataSelectPeg==""){
                redirect('scorecards/WeightagePeg/insert_form');
            }
            $this->session->set_flashdata('DataSelectPeg',$DataSelectPeg);
            $DataSelectPegDecode=json_decode($DataSelectPeg);
            $Data['DataMs']=$this->weightage_peg_model->get_departemen_kpi_pegawai($DataSelectPegDecode->ListNIP,$DataSelectPegDecode->ThnEfektif);
            $Data['DataPeg']=$this->weightage_peg_model->get_pegawai_list_nip($DataSelectPegDecode->ListNIP);
            $Data['Info']=$DataSelectPegDecode;
            $Data['DataPage1']=$DataSelectPeg;
            // $DataPeg=$this->weightage_peg_model->get_pegawai_order_dept($this->kd_perusahaan,$this->session->userdata('login_nip'),$this->mion_auth->is_admin());
            // $Data['DataPeg']=  $DataPeg;
            // $Data['ListTahun']= ListTahunBerjalan($this->config->item('year_apps'));
            // $Data['ListBulan']= ListBulan();

            $this->template->temp_default();
            $this->template->add_section('viewjs', 'scorecards/WeightagePeg_vf/v_WeightagePeg_js');
            $this->load->view('WeightagePeg_vf/v_WeightagePeg_input_SelectMs',$Data);
        }
        else
        {
            $Data['text_error']=$this->lang->line('not_access');
            $this->template->temp_default();
            $this->template->add_section('t_alert', 'alert_error',$Data);
        }
    }
    public function save_select_ms()
    {
        $Data=["success"=>false,"messages"=>array(),'link'=>'insert_form_bobot'];
        
        // $this->form_validation->set_rules('tahun', $this->lang->line('tahun_efektif'), 'trim|required');
        // $this->form_validation->set_rules('bulan', $this->lang->line('bulan_efektif'), 'trim|required');
        // $this->form_validation->set_rules('deskripsi', $this->lang->line('deskripsi'), 'trim|required');
        //$this->form_validation->set_rules('weightage_bd[]', $this->lang->line('weightage_bd'), 'trim|required');
        $this->form_validation->set_rules('kd_ms[]', $this->lang->line('nama'), 'required');
       $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        $errorKode=true;
        $errorNIP=TRUE;
        $ListMS=$this->input->post('kd_ms');
        $DataPage1=$this->input->post('DataPage1');
        // echo $DataPage1;
        // var_dump($ListMS);
        // if(count($ListNIP)>0){
        //     $errorNIP=TRUE;
        //     foreach($ListNIP as $nip){
        //         // echo $nip."<br/>";
        //         $errorKode=$this->_CekKodePegawaiKPI($nip,$this->input->post('bulan'),$this->input->post('tahun'));
        //     }
        // }
        if ($this->form_validation->run() == FALSE or $errorKode==FALSE or $errorNIP==FALSE ){
               echo form_error();
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
                
            }
            if($errorNIP==FALSE){
                $Data['messages']['ms']= '<div class="form-control-feedback text-error">'.$this->lang->line('error_select_peg').'</div>';
            }
            if($errorKode==FALSE){
                $Data['messages']['ms']= $this->lang->line('error_bulan_tahun_exist');
            }
        }else{
            //die;
            $DataSelectPegDecode=json_decode($DataPage1);
            $DataInput=[
                'BlnEfektif'=>$DataSelectPegDecode->BlnEfektif,
                'ThnEfektif'=>$DataSelectPegDecode->ThnEfektif,
                'Deskripsi'=>$DataSelectPegDecode->Deskripsi,
                'ListNIP'=>$DataSelectPegDecode->ListNIP,
                'ListMS'=>$ListMS,
            ];
            $dataJson=json_encode($DataInput);
            $this->session->set_flashdata('DataSelectPeg', $DataPage1);
            $this->session->set_flashdata('DataSelectMs', $dataJson);
            // $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
            $Data["success"]=true;

        }
        
        echo json_encode($Data);
    }
    
    public function insert_form_bobot()
    {   
        if($this->mion_auth->is_allowed('add_weightage_peg')){
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader');
            $Data["input_header"]=$this->lang->line('input_header');
            $this->breadcrumbs->push($this->lang->line('input_header'), '/scorecards/WeightagePeg/insert_form');
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['AlertInput']=$this->session->flashdata('AlertInput');
            $DataSelectPeg=$this->session->flashdata('DataSelectPeg');
            $DataSelectMs=$this->session->flashdata('DataSelectMs');

            if($DataSelectPeg==""){
                redirect('scorecards/WeightagePeg/insert_form');
            }
            $this->session->set_flashdata('DataSelectPeg',$DataSelectPeg);
            $DataSelectPegDecode=json_decode($DataSelectPeg);
            $DataSelectMsDecode=json_decode($DataSelectMs);
            // var_dump($DataSelectPegDecode);
            // die;
            // $Data['DataMs']=$this->weightage_peg_model->get_departemen_kpi_pegawai($DataSelectPegDecode->ListNIP,$DataSelectPegDecode->ThnEfektif);
            $Data['DataPeg']=$this->weightage_peg_model->get_pegawai_list_nip($DataSelectPegDecode->ListNIP);
            $Data['DataMs']=$this->weightage_peg_model->get_departemen_kpi_pegawai_list_ms($DataSelectMsDecode->ListMS,$DataSelectPegDecode->ThnEfektif);
            $Data['Info']=$DataSelectPegDecode;
            $Data['DataPage1']=$DataSelectPeg;
            $Data['DataPage2']=$DataSelectMs;
            $Data['ListType']= ListType();
            $Data['ListUnit']= ListUnit();
            $Data['ListUnitSimbol']= ListUnitSimbol();
            $Data['ListPeriodAll']= ListPeriodAll();
            $Data['ListAggregation']= ListAggregation();
            // $DataPeg=$this->weightage_peg_model->get_pegawai_order_dept($this->kd_perusahaan,$this->session->userdata('login_nip'),$this->mion_auth->is_admin());
            // $Data['DataPeg']=  $DataPeg;
            // $Data['ListTahun']= ListTahunBerjalan($this->config->item('year_apps'));
            // $Data['ListBulan']= ListBulan();

            $this->template->temp_default();
            $this->template->add_section('viewjs', 'scorecards/WeightagePeg_vf/v_WeightagePeg_js');
            $this->load->view('WeightagePeg_vf/v_WeightagePeg_input_target',$Data);
        }
        else
        {
            $Data['text_error']=$this->lang->line('not_access');
            $this->template->temp_default();
            $this->template->add_section('t_alert', 'alert_error',$Data);
        }
    }
    public function save_input_bobot()
    {
        $Data=["success"=>false,"messages"=>array(),'link'=>'insert_form_tg'];
        
        // $this->form_validation->set_rules('tahun', $this->lang->line('tahun_efektif'), 'trim|required');
        // $this->form_validation->set_rules('bulan', $this->lang->line('bulan_efektif'), 'trim|required');
        // $this->form_validation->set_rules('deskripsi', $this->lang->line('deskripsi'), 'trim|required');
        //$this->form_validation->set_rules('weightage_bd[]', $this->lang->line('weightage_bd'), 'trim|required');
        $this->form_validation->set_rules('kd_ms[]', $this->lang->line('nama'), 'required');
       $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        $errorKode=true;
        $errorNIP=TRUE;
        $ListMS=$this->input->post('kd_ms');
        $DataPage1=$this->input->post('DataPage1');
        // echo $DataPage1;
        // var_dump($ListMS);
        // if(count($ListNIP)>0){
        //     $errorNIP=TRUE;
        //     foreach($ListNIP as $nip){
        //         // echo $nip."<br/>";
        //         $errorKode=$this->_CekKodePegawaiKPI($nip,$this->input->post('bulan'),$this->input->post('tahun'));
        //     }
        // }
        if ($this->form_validation->run() == FALSE or $errorKode==FALSE or $errorNIP==FALSE ){
               echo form_error();
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
                
            }
            if($errorNIP==FALSE){
                $Data['messages']['ms']= '<div class="form-control-feedback text-error">'.$this->lang->line('error_select_peg').'</div>';
            }
            if($errorKode==FALSE){
                $Data['messages']['ms']= $this->lang->line('error_bulan_tahun_exist');
            }
        }else{
            //die;
            $DataSelectPegDecode=json_decode($DataPage1);
            $DataInput=[
                'BlnEfektif'=>$DataSelectPegDecode->BlnEfektif,
                'ThnEfektif'=>$DataSelectPegDecode->ThnEfektif,
                'Deskripsi'=>$DataSelectPegDecode->Deskripsi,
                'ListNIP'=>$DataSelectPegDecode->ListNIP,
                'ListMS'=>$ListMS,
            ];
            $dataJson=json_encode($DataInput);
            $this->session->set_flashdata('DataSelectPeg', $DataPage1);
            $this->session->set_flashdata('DataSelectMs', $dataJson);
            // $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
            $Data["success"]=true;

        }
        
        echo json_encode($Data);
    }
    public function insert_form_tg()
    {   
        if($this->mion_auth->is_allowed('add_weightage_peg')){
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader');
            $Data["input_header"]=$this->lang->line('input_header');
            $this->breadcrumbs->push($this->lang->line('input_header'), '/scorecards/WeightagePeg/insert_form');
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['AlertInput']=$this->session->flashdata('AlertInput');
            $DataSelectPeg=$this->session->flashdata('DataSelectPeg');
            $DataSelectMs=$this->session->flashdata('DataSelectMs');

            if($DataSelectPeg==""){
                redirect('scorecards/WeightagePeg/insert_form');
            }
            $this->session->set_flashdata('DataSelectPeg',$DataSelectPeg);
            $DataSelectPegDecode=json_decode($DataSelectPeg);
            $DataSelectMsDecode=json_decode($DataSelectMs);
            // var_dump($DataSelectPegDecode);
            // die;
            // $Data['DataMs']=$this->weightage_peg_model->get_departemen_kpi_pegawai($DataSelectPegDecode->ListNIP,$DataSelectPegDecode->ThnEfektif);
            $Data['DataPeg']=$this->weightage_peg_model->get_pegawai_list_nip($DataSelectPegDecode->ListNIP);
            $Data['DataMs']=$this->weightage_peg_model->getDataMeasurementListMs($DataSelectPegDecode->ListNIP,$DataSelectMsDecode->ListMS,$DataSelectPegDecode->ThnEfektif,$DataSelectPegDecode->BlnEfektif);
            $Data['Info']=$DataSelectPegDecode;
            $Data['DataPage1']=$DataSelectPeg;
            $Data['DataPage2']=$DataSelectMs;
            $Data['ListType']= ListType();
            $Data['ListUnit']= ListUnit();
            $Data['ListUnitSimbol']= ListUnitSimbol();
            $Data['ListPeriodAll']= ListPeriodAll();
            $Data['ListAggregation']= ListAggregation();
            // $DataPeg=$this->weightage_peg_model->get_pegawai_order_dept($this->kd_perusahaan,$this->session->userdata('login_nip'),$this->mion_auth->is_admin());
            // $Data['DataPeg']=  $DataPeg;
            // $Data['ListTahun']= ListTahunBerjalan($this->config->item('year_apps'));
            // $Data['ListBulan']= ListBulan();

            $this->template->temp_default();
            $this->template->add_section('viewjs', 'scorecards/WeightagePeg_vf/v_WeightagePeg_js');
            $this->load->view('WeightagePeg_vf/v_WeightagePeg_input_target',$Data);
        }
        else
        {
            $Data['text_error']=$this->lang->line('not_access');
            $this->template->temp_default();
            $this->template->add_section('t_alert', 'alert_error',$Data);
        }
    }
    public function save_input_tg()
    {
        $Data=["success"=>false,"messages"=>array(),'link'=>''];
        
        // $this->form_validation->set_rules('tahun', $this->lang->line('tahun_efektif'), 'trim|required');
        // $this->form_validation->set_rules('bulan', $this->lang->line('bulan_efektif'), 'trim|required');
        // $this->form_validation->set_rules('deskripsi', $this->lang->line('deskripsi'), 'trim|required');
        //$this->form_validation->set_rules('weightage_bd[]', $this->lang->line('weightage_bd'), 'trim|required');
        $this->form_validation->set_rules('kd_ms[]', $this->lang->line('nama'), 'required');
       $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        $errorKode=true;
        $errorNIP=TRUE;
        $ListMS=$this->input->post('kd_ms');
        $ListTarget=$this->input->post('target');
        $DataPage1=$this->input->post('DataPage1');
        $DataPage2=$this->input->post('DataPage2');
        // echo $DataPage1;
        // var_dump($ListMS);
        // if(count($ListNIP)>0){
        //     $errorNIP=TRUE;
        //     foreach($ListNIP as $nip){
        //         // echo $nip."<br/>";
        //         $errorKode=$this->_CekKodePegawaiKPI($nip,$this->input->post('bulan'),$this->input->post('tahun'));
        //     }
        // }
        if ($this->form_validation->run() == FALSE or $errorKode==FALSE or $errorNIP==FALSE ){
               echo form_error();
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
                
            }
            if($errorNIP==FALSE){
                $Data['messages']['ms']= '<div class="form-control-feedback text-error">'.$this->lang->line('error_select_peg').'</div>';
            }
            if($errorKode==FALSE){
                $Data['messages']['ms']= $this->lang->line('error_bulan_tahun_exist');
            }
        }else{
            //die;
            // $DataSelectPegDecode=json_decode($DataPage1);
            $DataMsDecode=json_decode($DataPage2);
            $Input=array();
            $InputTarget=array();
            $TargetDetail=array();
            $no=0;
            if(count($DataMsDecode->ListNIP)>0){
                $errorNIP=TRUE;
                $DataPeg=$this->weightage_peg_model->get_pegawai_list_nip_dataPeg($DataMsDecode->ListNIP);
                $DataMs=$this->weightage_peg_model->getDataMeasurementListMs($DataMsDecode->ListNIP,$DataMsDecode->ListMS,$DataMsDecode->ThnEfektif,$DataMsDecode->BlnEfektif);
                foreach($DataMsDecode->ListNIP as $key=>$nip){
                    // echo $nip."<br/>";
                    $KodePK=$DataMsDecode->ThnEfektif.$DataMsDecode->BlnEfektif.$nip.$DataPeg[$nip]['kd_departemen'];
                    $Input[$no]=['kd_pk'=>$KodePK,
                        'nip'=>$nip,
                        'kd_departemen'=>$DataPeg[$nip]['kd_departemen'],
                        'deskripsi'=>$DataMsDecode->Deskripsi,
                        'bulan'=>$DataMsDecode->BlnEfektif,
                        'tahun'=>$DataMsDecode->ThnEfektif,
                        'status'=>1,
                        'user_input'=>$this->session->userdata('identity'),
                        'tgl_input'=>date("Y-m-d H:i:s")
                        ];
                    if(count($ListMS)>0){
                        $no2=0;
                        foreach($ListMS as $key=>$kd_measurement){
                            $KodePT=uniqid(substr($DataMsDecode->ThnEfektif, 2).$DataMsDecode->BlnEfektif.$nip.$kd_measurement."_");
                            
                            //target sesuai dengan data period
                            $Target=$ListTarget[$key];
                            $aggregation=$DataMs['ms'][$DataPeg[$nip]['kd_departemen']][$kd_measurement]['aggregation'];
                            $period=$DataMs['ms'][$DataPeg[$nip]['kd_departemen']][$kd_measurement]['period'];
                            //target bulanan
                            if($period=="ytd" or $period=="y"){
                                $TargetBulanan=$Target/12;
                            }else if($period=="q"){
                                $TargetBulanan=$Target/3;
                            }else{
                                $TargetBulanan=$Target;
                            }
                            //target utk setahun
                            if($period=="m"){
                                $TargetSetahun=$Target*12;
                            }else if($period=="q"){
                                $TargetSetahun=$Target*4;
                            }else{
                                $TargetSetahun=$Target;
                            }
                            for($i=1;$i<=12;$i++)
                            {
                                if($period=="ytd"){
                                    $TargetBulanan=round(($TargetBulanan*$i),0);
                                }else if($period=="q"){
                                    if(fmod($i,3)!=0){
                                        $TargetBulanan=round(($TargetBulanan*(fmod($i,3))),0);
                                    }else{
                                        $TargetBulanan=round(($TargetBulanan*(3-fmod($i,3))),0);
                                    }
                                    
                                }
                                $TargetDetail[$i]['kd_ptd']=$KodePT."-".$i;
                                $TargetDetail[$i]['kd_pt']=$KodePT;
                                $TargetDetail[$i]['bulan']=$i;
                                $TargetDetail[$i]['target']=$TargetBulanan;
                            }
                            $InputTarget[$no2]=['kd_pt'=>$KodePT,
                                    'nip'=>$nip,
                                    'tahun'=>$DataMsDecode->ThnEfektif,
                                    'bulan'=>$DataMsDecode->BlnEfektif,
                                    'kd_pk'=>$KodePK,
                                    'kd_measurement'=>$kd_measurement,
                                    'kd_departemen'=>$DataPeg[$nip]['kd_departemen'],
                                    'target_setahun'=>$Target,
                                    'target_setahun_aktual'=>$TargetSetahun,
                                    'type'=>$DataMs['ms'][$DataPeg[$nip]['kd_departemen']][$kd_measurement]['type'],
                                    'unit'=>$DataMs['ms'][$DataPeg[$nip]['kd_departemen']][$kd_measurement]['unit'],
                                    'period'=>$period,
                                    'aggregation' => $aggregation,
                                    'status'=>1,
                                    'user_input'=>$this->session->userdata('identity'),
                                    'tgl_input'=>date("Y-m-d H:i:s")
                            ];
                            $no2++;
                        }
                    }
                    
                    $no++;
                }
                $this->weightage_peg_model->insert_pegawai_target_batch($InputTarget);
                $this->weightage_peg_model->insert_pegawai_target_d_batch($TargetDetail);
            }
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
            $Data["success"]=true;

        }
        
        echo json_encode($Data);
    }
    // view perspective view
    public function view_form()
    {
        $Kode=$this->uri->segment(4);
        $DataPk = $this->weightage_peg_model->get_weightage_peg_by_kdPk($Kode);
        if($DataPk->num_rows() > 0)
        {
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('view_header');
            $Data["list_header"]=$this->lang->line('list_header');
            $Data["input_header"]=$this->lang->line('view_header');
            $Data["result_header"]=$this->lang->line('result');
            $this->breadcrumbs->push($this->lang->line('view_header'), '/scorecards/WeightagePeg/view_form/'.$Kode);
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['AlertInput']=$this->session->flashdata('AlertInput');
        
            $Data['DataPk']= $DataPk;
            $Data['DataTarget'] = $this->weightage_peg_model->get_target_peg_by_kdPk($Kode);
            
             //insert user activity
            $this->useractivity->run_acitivity('view '.$this->lang->line('subheader'),$Kode);
                    
            $this->template->temp_default();
            $this->template->add_section('viewjs', 'scorecards/WeightagePeg_vf/v_WeightagePeg_js',$Data);
            $this->load->view('WeightagePeg_vf/v_WeightagePeg_view',$Data);
        }
        else
        {
            $Data['text_error']=$this->lang->line('not_found');
            $this->template->temp_default();
            $this->template->add_section('t_alert', 'alert_error',$Data);
        }
    }
    // insert target measurement
    public function target_view_form()
    {   
        if($this->mion_auth->is_allowed('view_weightage_peg')){
            $kd_pk=$this->uri->segment(4);
            $kd_measurement=$this->uri->segment(5);
            $Data['DataTargetPegawai'] = $this->weightage_peg_model->get_pegawai_target_by_kd_pk_weightage_peg($kd_pk,$kd_measurement);
            if($Data['DataTargetPegawai']->num_rows()>0){

    //            echo "masuk";
    //            die();
                $Data['ListType']= ListType();
                $Data['ListUnit']= ListUnit();
                $Data['ListUnitSimbol']= ListUnitSimbol();
                $Data['ListPeriodAll']= ListPeriodAll();
                $this->load->view('WeightagePeg_vf/v_WeightagePeg_target_view',$Data);
            }
            else
            {
                echo getAlertError($this->lang->line('not_found'));
            }
        
        }
        else
        {
            echo getAlertError($this->lang->line('not_access'));
        }
    }
    // edit target
    public function target_edit_form()
    {   
        if($this->mion_auth->is_allowed('edit_pegawai_target')){
            $kd_pk=$this->uri->segment(4);
            $kd_measurement=$this->uri->segment(5);
            $Data['DataTargetPegawai'] = $this->weightage_peg_model->get_pegawai_target_by_kd_pk_weightage_peg($kd_pk,$kd_measurement);
            if($Data['DataTargetPegawai']->num_rows()>0){

    //            echo "masuk";
    //            die();
                $Data['ListType']= ListType();
                $Data['ListUnit']= ListUnit();
                $Data['ListUnitSimbol']= ListUnitSimbol();
                $Data['ListPeriodAll']= ListPeriodAll();
                $this->load->view('WeightagePeg_vf/v_WeightagePeg_target_edit',$Data);
            }
            else
            {
                echo getAlertError($this->lang->line('not_found'));
            }
        
        }
        else
        {
            echo getAlertError($this->lang->line('not_access'));
        }
    }
    // edit target pegawai
    public function target_edit()
    {
        $kd_pk=$this->uri->segment(4);
        $Data=["success"=>false,"messages"=>array(),"kode"=>$kd_pk];
        $this->form_validation->set_rules('kd_measurement', $this->lang->line('nm_measurement'), 'trim|required');
//        $this->form_validation->set_rules('bulan', $this->lang->line('bulan_efektif'), 'trim|required');
//        $this->form_validation->set_rules('tahun', $this->lang->line('tahun_efektif'), 'trim|required');
//        $this->form_validation->set_rules('deskripsi', $this->lang->line('deskripsi'), 'trim|required');
        
        for($i=1;$i<=12;$i++)
        {
            $this->form_validation->set_rules('bulan_'.$i, getNamaBulan($i), 'trim|required');
        }
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        
        if ($this->form_validation->run() == FALSE ){
//                echo form_error('jenis_kelamin');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
            }
            //var_dump($Data['messages']);
        }else{
            $tahun=$this->input->post('tahun');
            $bulan=$this->input->post('bulan');
            $kd_measurement=$this->input->post('kd_measurement');
            $kd_departemen=$this->input->post('kd_departemen');
            $kd_pk=$this->input->post('kd_pk');
            $type=$this->input->post('type');
            $unit=$this->input->post('unit');
            $period=$this->input->post('period');
            $nip=$this->input->post('nip');
            $DataMeasurement=$this->weightage_peg_model->getDataMeasurement($kd_measurement);
            $Aggregation = ($DataMeasurement)?$DataMeasurement->aggregation:'';
            $id=$this->weightage_peg_model->delete_pegawai_target_kd_pk_measurement($kd_pk,$kd_measurement);
            $TargetDetail=array();
            $KodePT=uniqid(substr($tahun, 2).$bulan.$nip.$kd_measurement."_");
            
            for($i=1;$i<=12;$i++)
            {
                $TargetDetail[$i]['kd_ptd']=$KodePT."-".$i;
                $TargetDetail[$i]['kd_pt']=$KodePT;
                $TargetDetail[$i]['bulan']=$i;
                $TargetDetail[$i]['target']=$this->input->post('bulan_'.$i);
            }

            $Input=['kd_pt'=>$KodePT,
                    'nip'=>$nip,
                    'tahun'=>$this->input->post('tahun'),
                    'bulan'=>$this->input->post('bulan'),
                    'kd_pk'=>$this->input->post('kd_pk'),
                    'kd_measurement'=>$kd_measurement,
                    'kd_departemen'=>$kd_departemen,
                    'target_setahun'=>0,
                    'target_setahun_aktual'=>0,
                    'type'=>$type,
                    'unit'=>$unit,
                    'period'=>$period,
                    'aggregation' =>$Aggregation,
                    'status'=>1,
                    'user_input'=>$this->session->userdata('identity'),
                    'tgl_input'=>date("Y-m-d H:i:s")
                    ];

            $id=$this->weightage_peg_model->insert_pegawai_target($Input);
            $this->weightage_peg_model->insert_pegawai_target_d_batch($TargetDetail);
            
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
            //insert user activity
            $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$this->input->post('nip'),$Input);
            $Data["success"]=true;
            
            
        }
        
        echo json_encode($Data);
    }
    public function weightage_peg_delete(){
        if($this->mion_auth->is_allowed('delete_weightage_peg')){
            $this->load->model('organisasi/pegawai_model');
            $DataDelete=$this->uri->segment(4);
            //get history data
            $DataPegawaiKpi = $this->pegawai_model->get_pegawai_kpi_by_kd_pk($DataDelete);
            $this->pegawai_model->delete_pegawai_kpi($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataPegawaiKpi->row_array());
        }

    }
}


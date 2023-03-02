<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Measurement extends CI_Controller {
    private $kd_measurement;
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('scorecards/Measurement',$siteLang);
            $this->load->model('measurement_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/scorecards/Measurement');
            $this->kd_perusahaan = $this->session->userdata('ses_perusahaan');
            
            //get kode data
            $Data=$this->measurement_model->get_measurement_all($this->kd_perusahaan);
            if($Data->num_rows() > 0){
                $this->kd_measurement=$Data->row()->kd_measurement;
            }
    }
    
    //list measurement
    public function index()
    {
        $Bln=$this->uri->segment(6);
        $Thn=$this->uri->segment(5);
        $Kode=$this->uri->segment(4);
        if($Thn=="" and $Bln==""){
            $Bln=date("m");
        }
//        echo $Kode."---";
//        die();
        if($Kode=="" or $Kode=="null" or $Kode==NULL){
            $Kode = $this->kd_measurement;
            
        }
        $Data['DataBulan'] = ($Bln=="")?$Bln= '':$Bln;
        $Data['DataTahun'] = ($Thn=="")?$Thn=date("Y"):$Thn;
        $Data['DataKdMeasurement'] =$Kode;
                
        $Data["title_web"]=$this->lang->line('title_web');
        $Data["subheader"]=$this->lang->line('subheader');
        $Data["list_header"]=$this->lang->line('list_header');
        $Data["input_header"]=$this->lang->line('view_header');
        $Data["result_header"]=$this->lang->line('result');
        $Data["list_header_bobot"]=$this->lang->line('list_header_bobot');
        $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
        $Data['AlertInput']=$this->session->flashdata('AlertInput');
        $Data['data_uri']= "scorecards/Measurement/index/".$Kode;
        
        //echo $Kode." ".$Thn;
        $Data['DataMeasurement'] = $this->measurement_model->get_measurement_by_code($Kode,$Thn);
        $Data['DataMT'] = $this->measurement_model->get_measurement_target_by_code($Kode,$Thn);
        if($Data['DataMeasurement']->num_rows()<=0 and $this->mion_auth->is_allowed('add_measurement')){
            redirect('scorecards/Measurement/insert_form');
        }
        $LTahun=ListTahunBerjalan($this->config->item('year_apps'));
        unset($LTahun['']);
        krsort($LTahun);
        $Data['ListTahun']= $LTahun;
        $LBulan=ListBulan();
        unset($LBulan['']);
        $Data['ListBulan']= $LBulan;
        $LPeriod= ListPeriod();
        unset($LPeriod['']);
        $Data['ListPeriod']= $LPeriod;
        $Data['ListUnit']= ListUnit();
        $Data['ListUnitSimbol']= ListUnitSimbol();
        $Data['ListPeriodAll']= ListPeriodAll();
        $Data['ListAggregation']= ListAggregation();
        
        $Data['ListMeasurement']=$this->measurement_model->get_measurement_all($this->kd_perusahaan,$Thn);
        
        if($Bln!="") {
            $DataResult=$this->measurement_model->get_measurement_result_kd_measurement_monthly($Kode,$Data['DataBulan'],$Data['DataTahun']);
            $Data['HistoryMesurement']=$this->measurement_model->get_measurement_result_history_kd_measurement($Kode,$Data['DataBulan'],$Data['DataTahun']);
            $Data['ChartMesurement']=$this->measurement_model->get_measurement_result_chart_monthly_kd_measurement($Kode,$Data['DataBulan'],$Data['DataTahun']);
        } else {
            $DataResult=$this->measurement_model->get_measurement_result_kd_measurement_yearly($Kode,$Data['DataTahun']);
            $Data['HistoryMesurement']=$this->measurement_model->get_measurement_result_history_kd_measurement_yearly($Kode,$Data['DataTahun']);
            $Data['ChartMesurement']=$this->measurement_model->get_measurement_result_chart_yearly_kd_measurement($Kode,$Data['DataTahun']);
        }
        $Data['GaugeMesurement']=0;
        if($DataResult->num_rows()>0){
            $Data['GaugeMesurement']=$DataResult->row()->point_result;
        }
        //insert user activity
        $this->useractivity->run_acitivity('index '.$this->lang->line('subheader'));
        $this->template->temp_default();
        $this->template->add_section('viewjs', 'scorecards/Measurement_vf/v_Measurement_js',$Data);
        $this->template->add_section('w_subheader', 'scorecards/Measurement_vf/v_Measurement_widget_subheader',$Data);
        $this->load->view('Measurement_vf/v_Measurement',$Data);
    }
    //get list measurement json
    public function get_list_target()
    {
                    $kode=$this->uri->segment(4);
                    $tahun=$this->uri->segment(5);
                    if($tahun==""){
                        $tahun=date("Y");
                    }
                    $addsql = array();
                    $request = '';
                    $table = "(select measurement_target.*,perspective.kd_perusahaan,concat(measurement_target.kd_measurement,measurement_target.tahun,measurement_target.bulan) as kd_tbl
                                from measurement_target
                                INNER JOIN measurement ON measurement_target.kd_measurement = measurement.kd_measurement
                                INNER JOIN business_driver ON business_driver.kd_bd = measurement.kd_bd
                                INNER JOIN perspective ON business_driver.kd_perspective = perspective.kd_perspective) as tbl_ms_target";
                    $custom_whare="tbl_ms_target.kd_perusahaan ='$this->kd_perusahaan' and tbl_ms_target.kd_measurement ='$kode'";
                    $primaryKey = 'tbl_ms_target.kd_measurement';
                    $columns = array(
                            array( 
                                    'NO', 
                                    'dt' => 0 ,
                                    'searchable' => FALSE
                            ),
                            array(
                                    'db' => 'tbl_ms_target.kd_mt',
                                    'dt' => 1,
                            ),
                            array( 
                                    'db' => 'tbl_ms_target.bulan', 
                                    'dt' => 2,
                                    'formatter' => function( $d, $row ) {
                                                return getNamaBulan($d);
                                            }
                            ),
                            array( 
                                    'db' => 'tbl_ms_target.tahun', 
                                    'dt' => 3,
                            ),
                            array( 
                                    'db' => 'tbl_ms_target.deskripsi', 
                                    'dt' => 4,
                            )

                    );

                    $a_condition = array();
                    $a_condition_type = array(); 
                    $a_link = array();
                    $a_src = array();
                    $a_src_change = array();

                    
                    $a_link['View'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-file-text"></i></a>';
                    $a_src['View'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupView';
                            
//                    if($this->mion_auth->is_allowed('edit_measurement_target')) {
//                            $a_link['Edit'] = '<a href="'. site_url('scorecards/Measurement/edit_form/').'#action_lock#" class="#link_class#" title="#link_title#"><i class="la la-edit"></i></a>';
//                            $a_src['Edit'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupEdit';
//                    }
                    if($this->mion_auth->is_allowed('delete_measurement_target')) { 
                            $a_link['Delete'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-trash"></i></a>';
                            $a_src['Delete'] = 'm-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-data';
                    }
                    //add to ajax columns
                    $columns[] = array(
                                    'action',
                                    'searchable' => FALSE,
                                    'dt'=>5,
                                    'condition'=>$a_condition,
                                    'condition_type'=>$a_condition_type,
                                    'action_link'=>$a_link,
                                    'action_src'=>$a_src,
                                    'action_src_change'=>$a_src_change,
                                    'action_lock'=>'kd_mt'
                            );

                    // manual ordering at the first page load (server side)
                    if( $_GET['order'][0]['column'] == 0)
                    {
                            $_GET['order'][0]['column'] = '1';
                            $_GET['order'][0]['dir'] = 'asc';
                    }

                    //
                    echo json_encode(
                            SSP::simple( $_GET, $table, $primaryKey, $columns , $custom_whare)
                    );
    }
    // insert measurement view
    public function insert_form()
    {   
        if($this->mion_auth->is_allowed('add_measurement')){
//            echo "tes";
//            die();
            $Thn=$this->uri->segment(4);
            $Data=array();
            $Data['DataTahun']=($Thn=="")?date("Y"):$Thn;
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader');
            $Data["input_header"]=$this->lang->line('input_header');
            $this->breadcrumbs->push($this->lang->line('input_header'), '/scorecards/Measurement/insert_form');
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['AlertInput']=$this->session->flashdata('AlertInput');
            
            $DataBusinessDriver=$this->measurement_model->get_business_driver_all_measurement($this->kd_perusahaan);
            $Data['ListBusinessDriver']=  get_value_array($DataBusinessDriver,'kd_bd',['kd_bds','nm_bd'],TRUE);
            
            $Data['ListType']= ListType();
            $Data['ListUnit']= ListUnit();
            $Data['ListPeriodAll']= ListPeriodAll();
            $Data['ListAggregation']= ListAggregation();
            $this->template->temp_default();
            $this->template->add_section('viewjs', 'scorecards/Measurement_vf/v_Measurement_js2');
            $this->load->view('Measurement_vf/v_Measurement_input',$Data);
        }
        else
        {
            $Data['text_error']=$this->lang->line('not_access');
            $this->template->temp_default();
            $this->template->add_section('t_alert', 'alert_error',$Data);
        }
    }
    // insert measurement
    public function save()
    {
        $Thn=$this->uri->segment(4);
        $Data=["success"=>false,"messages"=>array(),'kode'=>""];
        //$this->form_validation->set_rules('kd_measurement', $this->lang->line('kd_measurement'), 'trim|required|max_length[5]|alpha_dash|callback__CekKodeMeasurement[]');
        $this->form_validation->set_rules('nm_measurement', $this->lang->line('nm_measurement'), 'trim|required');
        $this->form_validation->set_rules('kd_bd', $this->lang->line('kd_bd'), 'trim|required');
        // $this->form_validation->set_rules('unit', $this->lang->line('unit'), 'trim|required');
        // $this->form_validation->set_rules('period', $this->lang->line('period'), 'trim|required');
        // $this->form_validation->set_rules('aggregation', $this->lang->line('aggregation'), 'trim|required');
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        
        if ($this->form_validation->run() == FALSE ){
//                echo form_error('kd_measurement');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
            }
        }else{
                $kd_ms= $this->measurement_model->create_kd_mesurement($this->input->post('kd_bd'));
                //$kd_ms=$this->input->post('kd_measurement');
                $Kode=$kd_ms.$this->kd_perusahaan;
                $stat_bobot=$this->input->post('stat_bobot');
                $Input=['kd_measurement'=>$Kode,
                        'kd_ms'=>$kd_ms,
                        'nm_measurement'=>$this->input->post('nm_measurement'),
                        'kd_bd'=>$this->input->post('kd_bd'),
                        'unit'=>$this->input->post('unit'),
                        'period'=>$this->input->post('period'),
                        'aggregation'=>$this->input->post('aggregation')
                        ];

                $id=$this->measurement_model->insert_measurement($Input);

                //insert user activity
                $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$this->input->post('kd_measurement'),$Input);
                $weightage=0;
                if($stat_bobot == 1)
                {
                    $weightage=1;
                
                }
                $kd_mb=$Kode.$Thn;
                $Input=['kd_mb'=>$kd_mb,
                        'tahun'=>$Thn,
                        'kd_measurement'=>$Kode,
                        'weightage'=>$weightage,
                        'status'=>1,
                        'user_input'=>$this->session->userdata('identity'),
                        'tgl_input'=>date("Y-m-d H:i:s")
                        ];
                $id=$this->measurement_model->insert_measurement_bobot($Input);
                //insert user activity
                $this->useractivity->run_acitivity('insert '.$this->lang->line('input_header_bobot')." ".$Thn,$kd_mb,$Input);
                    
                $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
                $Data["success"]=true;
                $Data["kode"]=$Kode;
            
        }
        
        echo json_encode($Data);
    }
    // insert bobot measurement
    public function bobot_insert_form()
    {   
        $tahun=$this->uri->segment(4);
        $kd_bd=$this->uri->segment(5);
        $kd_measurement=$this->uri->segment(6);
        $tahun=($tahun=="")?date("Y"):$tahun;
        if($this->mion_auth->is_allowed('add_measurement_bobot')){
            $Data=array();
            $Data['DataMeasurement']=$this->measurement_model->get_measurement_all_by_business_driver($kd_bd,$tahun);
            $Data['Tahun']=$tahun;
            $Data['ListTahun']= ListTahunBerjalan($this->config->item('year_apps'));
            
            $this->load->view('Measurement_vf/v_Measurement_Bobot_input',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_access'));
        }
    }
    // insert bobot measurement
    public function bobot_save()
    {
        $tahun=$this->uri->segment(4);
        $kd_bd=$this->uri->segment(5);
        $kd_measurement=$this->uri->segment(6);
        $tahun=($tahun=="")?date("Y"):$tahun;
        $Data=["success"=>false,"messages"=>array(),'kode'=>$kd_measurement];
        
        $this->form_validation->set_rules('tahun', $this->lang->line('tahun'), 'trim|required');
        
        $this->form_validation->set_rules('kd_measurement[]', $this->lang->line('kd_measurement'), 'trim|required');
        $this->form_validation->set_rules('weightage[]', $this->lang->line('weightage'), 'trim|required');
        
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        
        if ($this->form_validation->run() == FALSE ){
//                echo form_error('weightage[]');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                if($key=='weightage'){
                    $Data['messages'][$key]= form_error('weightage[]');
                }else if($key=='kd_measurement'){
                    $Data['messages'][$key]= form_error('kd_measurement[]');
                }else{
                    $Data['messages'][$key]= form_error('tahun');
                }
                
                
            }
        }else{
            $kd_measurement=$this->input->post('kd_measurement');
            $weightage=$this->input->post('weightage');
            $TotalBobot=$this->input->post('total_bobot');
//            $TotalBobot=0;
//            foreach($kd_measurement as $key=>$val)
//            {
//                if($weightage[$key]=="")
//                {
//                    $Bobot=0;
//                }
//                else
//                {
//                    $Bobot=$weightage[$key];
//                }
//                $TotalBobot=$TotalBobot+$Bobot;
//            }
            if($TotalBobot<100)
            {
                //echo $TotalBobot;
                $Data['messages']['error_total_bobot']= $this->lang->line('error_total_bobot');
            }
            else
            {
                $no=1;
                $this->measurement_model->delete_measurement_bobot($kd_bd,$tahun);
                foreach($kd_measurement as $key=>$val)
                {
                    $kd_mb=$val.$this->input->post('tahun');
                    $Input=['kd_mb'=>$kd_mb,
                            'tahun'=>$this->input->post('tahun'),
                            'kd_measurement'=>$val,
                            'weightage'=>$weightage[$key],
                            'status'=>1,
                            'user_input'=>$this->session->userdata('identity'),
                            'tgl_input'=>date("Y-m-d H:i:s")
                            ];
                    $id=$this->measurement_model->insert_measurement_bobot($Input);
                    //insert user activity
                    $this->useractivity->run_acitivity('insert '.$this->lang->line('input_header_bobot'),$kd_mb,$Input);
                }

                    //$id=$this->measurement_model->insert_measurement($Input);

                    $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
                    $Data["success"]=true;

            }
        }
        
        echo json_encode($Data);
    }
    // insert target measurement
    public function target_insert_form()
    {   
        if($this->mion_auth->is_allowed('add_measurement_target')){
            $kd_measurement=$this->uri->segment(4);
            $tahun=$this->uri->segment(5);
            $tahun=($tahun=="")?date("Y"):$tahun;
            $Data['DataMeasurement']=$this->measurement_model->get_measurement_by_code($kd_measurement);
            if($Data['DataMeasurement']->num_rows() > 0)
            {
                $Data["title_web"]=$this->lang->line('title_web');
                $Data["subheader"]=$this->lang->line('subheader');
                $Data["input_header"]=$this->lang->line('input_target_header');
                $this->breadcrumbs->push($this->lang->line('input_target_header'), '/scorecards/Measurement/target_insert_form');
                $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
                $Data['AlertInput']=$this->session->flashdata('AlertInput');

                $Data['ListType']= ListType();
                $Data['ListUnit']= ListUnit();
                $Data['ListUnitSimbol']= ListUnitSimbol();
                $Data['ListPeriodAll']= ListPeriodAll();
                $Data['ListAggregation']= ListAggregation();
                $Data['Tahun']=$tahun;
                $Data['ListBulan']= ListBulan();
                $LTahun=ListTahunBerjalan($this->config->item('year_apps'));
                krsort($LTahun);
                $Data['ListTahun']= $LTahun;
        
                $this->template->temp_default();
                $this->template->add_section('viewjs', 'scorecards/Measurement_vf/v_Measurement_js3');
                $this->load->view('Measurement_vf/v_Measurement_Target_input',$Data);
            }
            else
            {
                $Data['text_error']=$this->lang->line('not_found');
                $this->template->temp_default();
                $this->template->add_section('t_alert', 'alert_error',$Data);
            }
        }
        else
        {
            $Data['text_error']=$this->lang->line('not_access');
            $this->template->temp_default();
            $this->template->add_section('t_alert', 'alert_error',$Data);
        }
    }
    // insert target measurement
    public function target_save()
    {
        $kd_measurement=$this->uri->segment(4);
        $tahun=$this->uri->segment(5);
        $tahun=($tahun=="")?date("Y"):$tahun;
        $Data=["success"=>false,"messages"=>array(),'kode'=>$kd_measurement];
        
        $this->form_validation->set_rules('tahun', $this->lang->line('tahun'), 'trim|required');
        $this->form_validation->set_rules('bulan', $this->lang->line('bulan'), 'trim|required');
        $this->form_validation->set_rules('deskripsi', $this->lang->line('deskripsi'), 'trim|required');
        $this->form_validation->set_rules('target_setahun', $this->lang->line('target_setahun'), 'trim|required');
        $this->form_validation->set_rules('type', $this->lang->line('type'), 'trim|required');
//        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        
        if ($this->form_validation->run() == FALSE ){
//                echo form_error('weightage[]');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                if($key=='weightage'){
                    $Data['messages'][$key]= form_error('weightage[]');
                }else if($key=='kd_measurement'){
                    $Data['messages'][$key]= form_error('kd_measurement[]');
                }else{
                    $Data['messages'][$key]= form_error('tahun');
                }
                
                
            }
        }else{
            $tahun=$this->input->post('tahun');
            $bulan=$this->input->post('bulan');
            $target_setahun=$this->input->post('target_setahun');
            $type=$this->input->post('type');
            $unit=$this->input->post('unit');
            $period=$this->input->post('period');
            $TotalBobot=0;
            $TargetDetail=array();
            $KodeMT=$tahun.$bulan.$kd_measurement;
            
            $dataMeasurement = $this->getDataMesurementDB($kd_measurement);
            $Aggregation = ($dataMeasurement)?$dataMeasurement->aggregation:'';

            $TotTargetSetahun=0;     
            for($i=1;$i<=12;$i++)
            {
                $TargetDetail[$i]['kd_mtd']=$KodeMT."-".$i;
                $TargetDetail[$i]['kd_mt']=$KodeMT;
                $TargetDetail[$i]['bulan']=$i;
                $TargetDetail[$i]['target']=$this->input->post('bulan_'.$i);
                
                $TotTargetSetahun=$TotTargetSetahun+$this->input->post('bulan_'.$i);
                
                // if($unit!="p"){
                //     $TotTargetSetahun=$TotTargetSetahun+$this->input->post('bulan_'.$i);
                // }else{
                //     $TotTargetSetahun=$target_setahun;
                // }
            }
            if($Aggregation=="AVG"){
                $TotTargetSetahun=$TotTargetSetahun/12;
            }
            if($period=="ytd"){
                $TotTargetSetahun=$this->input->post('bulan_12');
            }else if($period=="q"){
                $TotTargetSetahun=$this->input->post('bulan_3')+$this->input->post('bulan_6')+$this->input->post('bulan_9')+$this->input->post('bulan_12');
            }
            //var_dump($TargetDetail);
            $this->measurement_model->delete_measurement_target($KodeMT);
            $Input=['kd_mt'=>$KodeMT,
                    'tahun'=>$this->input->post('tahun'),
                    'bulan'=>$this->input->post('bulan'),
                    'deskripsi'=>$this->input->post('deskripsi'),
                    'kd_measurement'=>$kd_measurement,
                    'target_setahun'=>$target_setahun,
                    'target_setahun_aktual'=>$TotTargetSetahun,
                    'type'=>$type,
                    'unit'=>$unit,
                    'period'=>$period,
                    'aggregation'=>$Aggregation,
                    'status'=>1,
                    'user_input'=>$this->session->userdata('identity'),
                    'tgl_input'=>date("Y-m-d H:i:s")
                    ];
            $id=$this->measurement_model->insert_measurement_target($Input);
            
            $this->measurement_model->delete_measurement_target_d_kd_mt($KodeMT);
            $this->measurement_model->insert_measurement_target_d_batch($TargetDetail);
            

                    //$id=$this->measurement_model->insert_measurement($Input);
                    //insert user activity
                    $this->useractivity->run_acitivity('insert '.$this->lang->line('input_target_header'),$KodeMT,$Input);
                    $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
                    $Data["success"]=true;

        }
        
        echo json_encode($Data);
    }
    public function getDataMesurementDB($kd_measurement)
    {
        $DataMeasurement = $this->measurement_model->get_measurement_by_code($kd_measurement);
        if($DataMeasurement->num_rows()>0){
            return $DataMeasurement->row();
        }
        return false;
    }
    //edit form measurement
    public function edit_form()
    {
        if($this->mion_auth->is_allowed('edit_measurement')){
            $Kode=$this->uri->segment(4);
            $DataMeasurement = $this->measurement_model->get_measurement_by_code($Kode);
            if($DataMeasurement->num_rows() > 0)
            {
                $Data["title_web"]=$this->lang->line('title_web');
                $Data["subheader"]=$this->lang->line('subheader');
                $Data["input_header"]=$this->lang->line('edit_header');
                $this->breadcrumbs->push($this->lang->line('edit_header'), '/scorecards/Measurement/edit_form');
                $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
                $Data['AlertInput']=$this->session->flashdata('AlertInput');

                $DataBusinessDriver=$this->measurement_model->get_business_driver_all_measurement($this->kd_perusahaan);
                $Data['ListBusinessDriver']=  get_value_array($DataBusinessDriver,'kd_bd',['kd_bds','nm_bd'],TRUE);

                $Data['ListType']= ListType();
                $Data['ListUnit']= ListUnit();
                $Data['ListPeriodAll']= ListPeriodAll();
                $Data['ListAggregation']= ListAggregation();

                $Data['DataMeasurement']= $DataMeasurement;
                
                $this->template->temp_default();
                $this->template->add_section('viewjs', 'scorecards/Measurement_vf/v_Measurement_js2');
                $this->load->view('Measurement_vf/v_Measurement_edit',$Data);
            }
            else
            {
                $Data['text_error']=$this->lang->line('not_found');
                $this->template->temp_default();
                $this->template->add_section('t_alert', 'alert_error',$Data);
            }
        }
        else
        {
            $Data['text_error']=$this->lang->line('not_access');
            $this->template->temp_default();
            $this->template->add_section('t_alert', 'alert_error',$Data);
        }
    }
    // edit measurement
    public function edit()
    {
        $Kode=$this->uri->segment(4);
        $DataMeasurement = $this->measurement_model->get_measurement_by_code($Kode);
        $Data=["success"=>false,"messages"=>array(),"data"=>array(),"kode"=>$Kode];
       
        if($DataMeasurement->num_rows() > 0)
        {
            //$this->form_validation->set_rules('kd_measurement_baru', $this->lang->line('kd_measurement_baru'), 'trim|required|max_length[5]|alpha_dash|callback__CekKodeMeasurement['.$this->input->post('kd_measurement').']');
            $this->form_validation->set_rules('nm_measurement', $this->lang->line('nm_measurement'), 'trim|required');
            $this->form_validation->set_rules('kd_bd', $this->lang->line('kd_bd'), 'trim|required');
            // $this->form_validation->set_rules('unit', $this->lang->line('unit'), 'trim|required');
            // $this->form_validation->set_rules('period', $this->lang->line('period'), 'trim|required');
            $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
            
            
        
            if ($this->form_validation->run() == FALSE ){
                foreach($_POST as $key => $value)
                {
                    $Data['messages'][$key]= form_error($key);
                    //$Data['data']= $DataMeasurement->row_array();
                }
            }else{
//                    $kd_ms=$this->input->post('kd_measurement');
//                    $Kode=$kd_ms.$this->kd_perusahaan;
                    $Input=['nm_measurement'=>$this->input->post('nm_measurement'),
                        'kd_bd'=>$this->input->post('kd_bd'),
                        'unit'=>$this->input->post('unit'),
                        'period'=>$this->input->post('period'),
                        'aggregation'=>$this->input->post('aggregation')
                        ];

                    $this->measurement_model->update_measurement($Kode,$Input);
                    $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_edit'));
                    //insert user activity
                    $this->useractivity->run_acitivity('edit '.$this->lang->line('subheader'),$Kode,$Input,$DataMeasurement->row_array());
                    $Data["success"]=true;
                
                
            }

        }
            echo json_encode($Data);
    }
    //cek exist kode Measurement
    public function _CekKodeMeasurement($Str='',$KodeLama=''){
        $Data=$this->measurement_model->get_measurement_all_by_code_perusahaan($Str,$this->kd_perusahaan)->num_rows();
//        echo $KodeLama;
//        die();
        if($Str==$KodeLama){
            return TRUE;
        }else{
            if($Data>0){
                $this->form_validation->set_message('_CekKodeMeasurement', $this->lang->line('error_kode'));
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    //cek exist kode Measurement
    public function _CekTahunTarget($Str='',$kd_measurement=''){
        $Data=$this->measurement_model->get_measurement_target_by_code($kd_measurement,$Str)->num_rows();
//        echo $KodeLama;
//        die();
            if($Data>0){
                $this->form_validation->set_message('_CekTahunTarget', $this->lang->line('error_tahun_exist'));
                return FALSE;
            }else{
                return TRUE;
            }
        
    }
    //cek exist Bulan tahun Measurement
    public function CekBulanTahunTarget(){
        $kd_measurement=$this->input->post('kd_measurement');
        $bulan=$this->input->post('bulan');
        $tahun=$this->input->post('tahun');
        $Data=["status"=>false,"messages"=>""];
        $DataMeasurement=$this->measurement_model->get_measurement_target_by_bulan_tahun($kd_measurement,$bulan,$tahun)->num_rows();
//        echo $KodeLama;
//        die();
            if($DataMeasurement>0){
                $Data["status"]=FALSE;
                $Data["messages"]=$this->lang->line('error_tahun_exist');
            }else{
                $Data["status"]=TRUE;
            }
            echo json_encode($Data);
        
    }
    //delete measurement
    public function delete(){
        if($this->mion_auth->is_allowed('delete_measurement')){
            $DataDelete=$this->uri->segment(4);
            //get history data
            $DataMeasurement = $this->measurement_model->get_measurement_by_code($DataDelete);
            $this->measurement_model->delete_measurement($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataMeasurement->row_array());
        }

    }
    //delete measurement
    public function target_delete(){
        if($this->mion_auth->is_allowed('delete_measurement_target')){
            $DataDelete=$this->uri->segment(4);
            //get history data
            $DataMeasurement = $this->measurement_model->get_measurement_target_by_code_mt($DataDelete);
            $this->measurement_model->delete_measurement_target($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('list_header_target'),$DataDelete,array(),$DataMeasurement->row_array());
        }

    }
    public function search_data(){
        $period = $this->input->post('period_search');
        $bulan = $this->input->post('bulan_search');
        $tahun = $this->input->post('tahun_search');
        
        $uri= $this->input->post('data_uri');
        
        if($period=="m"){
            redirect($uri."/".$tahun."/".$bulan);
        }else if($period=="y"){
            redirect($uri."/".$tahun);
        }else{
            redirect($uri);
        }
    }
    // copy bobot measurement
    public function copy_bobot()
    {
        $thn=$this->uri->segment(4);
        $kd_bd=$this->uri->segment(5);
        $kd_measurement=$this->uri->segment(6);
        
        if($kd_measurement==""){
            $kd_measurement = $this->kd_measurement;
            
        }
        $Data=["success"=>false,"messages"=>array(),'kode'=>$kd_measurement."/".$thn];
        $ThnLalu=$thn-1;
        $DataPerspectiveBobot=$this->measurement_model->get_measurement_all_by_business_driver($kd_bd,$ThnLalu);
        if($DataPerspectiveBobot->num_rows() > 0)
        {
            $this->measurement_model->insert_copy_measurement_bobot($kd_bd,$thn,$ThnLalu,$this->session->userdata('identity'),date("Y-m-d H:i:s"));
            //insert user activity
            $this->useractivity->run_acitivity('duplicate '.$this->lang->line('list_header_bobot')." ".$thn,$thn);
            $this->session->set_flashdata('AlertInput', $this->lang->line('success_duplicate'));
            $Data["success"]=true;
        }
        echo json_encode($Data);
    }
     // view perspective view
    public function target_view_form()
    {
        $Kode=$this->uri->segment(4);
        $DataMeasurementTarget = $this->measurement_model->get_measurement_target_by_code_mt($Kode);
        if($DataMeasurementTarget->num_rows() > 0)
        {
            $Data['ListType']= ListType();
                $Data['ListUnit']= ListUnit();
                $Data['ListUnitSimbol']= ListUnitSimbol();
                $Data['ListPeriodAll']= ListPeriodAll();
            //insert user activity
            $this->useractivity->run_acitivity('view '.$this->lang->line('list_header_target'),$Kode);
            $Data['DataMeasurementTarget']= $DataMeasurementTarget;
            $this->load->view('Measurement_vf/v_Measurement_Target_view',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_found'));
        }
    }
}


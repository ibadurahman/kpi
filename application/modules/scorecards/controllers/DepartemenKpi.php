<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DepartemenKpi extends CI_Controller {
    private $kd_departemen;
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('scorecards/DepartemenKpi',$siteLang);
            $this->load->model('departemen_kpi_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/scorecards/DepartemenKpi');
            $this->kd_perusahaan = $this->session->userdata('ses_perusahaan');
            
            //get kode data
            $Data=$this->departemen_kpi_model->get_departemen_all_departemen_kpi($this->kd_perusahaan);
            if($Data->num_rows() > 0){
                $this->kd_departemen=$Data->row()->kd_departemen;
            }
    }
    
    //list departemen_kpi
    public function index()
    {
        $Bln=$this->uri->segment(6);
        $Thn=$this->uri->segment(5);
        $Kode=$this->uri->segment(4);
        if($Thn=="" and $Bln==""){
            $Bln=date("m");
        }
        if($Kode==""){
            $Kode = $this->kd_departemen;
            
        }
        $Data['DataBulan'] = ($Bln=="")?$Bln= '':$Bln;
        $Data['DataTahun'] = ($Thn=="")?$Thn=date("Y"):$Thn;
        $Data["title_web"]=$this->lang->line('title_web');
        $Data["subheader"]=$this->lang->line('subheader');
        $Data["list_header"]=$this->lang->line('list_header');
        $Data["input_header"]=$this->lang->line('view_header');
        $Data["result_header"]=$this->lang->line('result');
        $Data["list_header_bobot"]=$this->lang->line('list_header_bobot');
        $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
        $Data['AlertInput']=$this->session->flashdata('AlertInput');
        $Data['data_uri']= "scorecards/DepartemenKpi/index/".$Kode;
        $Data['KdDepartemen']= $Kode;
        
        $Data['ListDepartemen'] = $this->departemen_kpi_model->get_departemen_all_departemen_kpi($this->kd_perusahaan);
        $Data['DataDepartemen'] = $this->departemen_kpi_model->get_departemen_code_departemen_kpi($Kode);
        $Data['DataDepartemenKpi'] = $this->departemen_kpi_model->get_departemen_kpi_by_kd_departemen($Kode,$Thn);
        if($Data['DataDepartemen']->num_rows()<=0 and $this->mion_auth->is_allowed('add_departemen_kpi')){
            //redirect('scorecards/DepartemenKpi/insert_form');
//        echo $Data['DataDepartemenKpi']->num_rows();
//        die();
            $Data2['text_error']=$this->lang->line('dept_not_found')." <a href='". site_url('organisasi/Departemen')."'>".$this->lang->line('here')."</a>";
//            $this->template->add_section('t_alert', 'alert_error',$Data2);
            $Data['WarningInput']=$Data2['text_error'];
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
        
        if($Bln != "") {
            $Data['HistoryDepartemen']=$this->departemen_kpi_model->get_departemen_result_history_kd_departemen($Kode,$Data['DataBulan'],$Data['DataTahun']);
            $Data['ChartDepartemen']=$this->departemen_kpi_model->get_departemen_result_chart_monthly_kd_departemen($Kode,$Data['DataBulan'],$Data['DataTahun']);
            $DataResult=$this->departemen_kpi_model->get_departemen_result_kd_departemen_monthly($Kode,$Data['DataBulan'],$Data['DataTahun']);
        } else {
            $Data['HistoryDepartemen']=$this->departemen_kpi_model->get_departemen_result_history_kd_departemen_yearly($Kode,$Data['DataTahun']);
            $Data['ChartDepartemen']=$this->departemen_kpi_model->get_departemen_result_chart_yearly_kd_departemen($Kode,$Data['DataTahun']);
            $DataResult=$this->departemen_kpi_model->get_departemen_result_kd_departemen_yearly($Kode,$Data['DataTahun']);
        }
        
        $Data['GaugeDepartemen']=0;
        if($DataResult->num_rows()>0){
            $Data['GaugeDepartemen']=$DataResult->row()->score_kpi_point;
        }
        $this->useractivity->run_acitivity('index '.$this->lang->line('subheader'));
        $this->template->temp_default();
        $this->template->add_section('viewjs', 'scorecards/DepartemenKpi_vf/v_DepartemenKpi_js',$Data);
        $this->template->add_section('w_subheader', 'scorecards/DepartemenKpi_vf/v_DepartemenKpi_widget_subheader',$Data);
        $this->load->view('DepartemenKpi_vf/v_DepartemenKpi',$Data);
    }
    //get list departemen_kpi json
    public function get_list()
    {
                    $tahun=$this->uri->segment(4);
                    if($tahun==""){
                        $tahun=date("Y");
                    }
                    $addsql = array();
                    $request = '';
                    $table = "departemen_kpi LEFT JOIN perspective ON perspective.kd_bd = departemen_kpi.kd_bd";
                    $custom_whare="perspective.kd_perusahaan ='$this->kd_perusahaan'";
                    $primaryKey = 'departemen_kpi.kd_departemen';
                    $columns = array(
                            array( 
                                    'NO', 
                                    'dt' => 0 ,
                                    'searchable' => FALSE
                            ),
                            array(
                                    'db' => 'departemen_kpi.kd_departemen',
                                    'dt' => 1,
                            ),
                            array( 
                                    'db' => 'departemen_kpi.nm_departemen_kpi', 
                                    'dt' => 2,
                            ),
                            array( 
                                    'db' => 'perspective.kd_bd', 
                                    'dt' => 3,
                            )

                    );

                    $a_condition = array();
                    $a_condition_type = array(); 
                    $a_link = array();
                    $a_src = array();
                    $a_src_change = array();

                    
                            $a_link['View'] = '<a href="'. site_url('scorecards/DepartemenKpi/view_form/').'#action_lock#/'.$tahun.'" class="#link_class#" title="#link_title#"><i class="la la-file-text"></i></a>';
                            $a_src['View'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupView';
                            
//                    if($this->mion_auth->is_allowed('edit_departemen_kpi')) {
//                            $a_link['Edit'] = '<a href="'. site_url('scorecards/DepartemenKpi/edit_form/').'#action_lock#" class="#link_class#" title="#link_title#"><i class="la la-edit"></i></a>';
//                            $a_src['Edit'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupEdit';
//                    }
                    if($this->mion_auth->is_allowed('delete_departemen_kpi')) { 
                            $a_link['Delete'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-trash"></i></a>';
                            $a_src['Delete'] = 'm-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-data';
                    }
                    //add to ajax columns
                    $columns[] = array(
                                    'action',
                                    'searchable' => FALSE,
                                    'dt'=>4,
                                    'condition'=>$a_condition,
                                    'condition_type'=>$a_condition_type,
                                    'action_link'=>$a_link,
                                    'action_src'=>$a_src,
                                    'action_src_change'=>$a_src_change,
                                    'action_lock'=>'kd_departemen'
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
    // insert departemen_kpi view
    public function insert_form()
    {   
        if($this->mion_auth->is_allowed('add_departemen_kpi')){
//            echo "tes";
//            die();
            $kd_departemen=$this->uri->segment(4);
            $tahun=$this->uri->segment(5);
            $Bln=$this->uri->segment(6);
            $tahun=($tahun=="")?date("Y"):$tahun;
            $Data['DataBulan'] = ($Bln=="")?$Bln= '':$Bln;
            $Data['DataTahun'] = $tahun;
            $Data['DataDepartemen'] = $this->departemen_kpi_model->get_departemen_code_departemen_kpi($kd_departemen);
            if($Data['DataDepartemen']->num_rows() > 0)
            {
                $Data["title_web"]=$this->lang->line('title_web');
                $Data["subheader"]=$this->lang->line('subheader');
                $Data["input_header"]=$this->lang->line('input_header');
                $this->breadcrumbs->push($this->lang->line('input_header'), '/scorecards/DepartemenKpi/insert_form');
                $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
                $Data['AlertInput']=$this->session->flashdata('AlertInput');

                $Data['DataMeasurement']=$this->departemen_kpi_model->get_measurement_remaining_bobot($this->kd_perusahaan,$tahun,TRUE);
                $Data['Tahun']=$tahun;
                $Data['ListTahun']= ListTahunBerjalan($this->config->item('year_apps'));


                $this->template->temp_default();
                $this->template->add_section('viewjs', 'scorecards/DepartemenKpi_vf/v_DepartemenKpi_input_js',$Data);
                $this->load->view('DepartemenKpi_vf/v_DepartemenKpi_input',$Data);
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
    // insert departemen_kpi
    public function save()
    {
        $kd_departemen=$this->uri->segment(4);
        $tahun=$this->uri->segment(5);
        $tahun=($tahun=="")?date("Y"):$tahun;
        $Data=["success"=>false,"messages"=>array(),'kode'=>$kd_departemen];
        
        $this->form_validation->set_rules('tahun', $this->lang->line('tahun'), 'trim|required');
        //$this->form_validation->set_rules('weightage_bd[]', $this->lang->line('weightage_bd'), 'trim|required');
        $this->form_validation->set_rules('weightage_kpi[]', $this->lang->line('weightage_kpi'), 'trim|required');
//        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        
        if ($this->form_validation->run() == FALSE ){
//                echo form_error('weightage[]');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
                
                
            }
        }else{
            $tahun=$this->input->post('tahun');
            $weightage_bd=$this->input->post('weightage_bd');
            $kd_measurement2=$this->input->post('kd_measurement2');
            $weightage_kpi=$this->input->post('weightage_kpi');
            $this->departemen_kpi_model->delete_departemen_kpi_kd_departemen($kd_departemen,$tahun);
//            var_dump($kd_measurement2);
            foreach($kd_measurement2 as $key=>$val)
            {
                $KodeDK=$tahun.$kd_departemen.$val;
                $WKPI=$weightage_bd[$key];
                if($WKPI==""){
                    $WKPI=1;
                }
                //$this->departemen_kpi_model->delete_departemen_kpi($KodeDK);
                $Input=['kd_dk'=>$KodeDK,
                        'tahun'=>$this->input->post('tahun'),
                        'kd_departemen'=>$kd_departemen,
                        'kd_measurement'=>$val,
                        'weightage_bd'=>$WKPI,
                        'weightage_kpi'=>$weightage_kpi[$key],
                        'status'=>1,
                        'user_input'=>$this->session->userdata('identity'),
                        'tgl_input'=>date("Y-m-d H:i:s")
                        ];
                $id=$this->departemen_kpi_model->insert_departemen_kpi($Input);
                //insert user activity
                $this->useractivity->run_acitivity('insert '.$this->lang->line('input_header'),$KodeDK,$Input);
            }
                    
                    $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
                    $Data["success"]=true;

        }
        
        echo json_encode($Data);
    }
    
    //edit form departemen_kpi
    public function edit_form()
    {
        if($this->mion_auth->is_allowed('edit_departemen_kpi')){
            $kd_departemen=$this->uri->segment(4);
            $tahun=$this->uri->segment(5);
            $Bln=$this->uri->segment(6);
            $tahun=($tahun=="")?date("Y"):$tahun;
            $Data['DataBulan'] = ($Bln=="")?$Bln= '':$Bln;
            $Data['DataTahun'] = $tahun;
            $DataDepartemenKpi = $this->departemen_kpi_model->get_departemen_kpi_by_kd_departemen($kd_departemen,$tahun);
            if($DataDepartemenKpi->num_rows() > 0)
            {
                $Data["title_web"]=$this->lang->line('title_web');
                $Data["subheader"]=$this->lang->line('subheader');
                $Data["input_header"]=$this->lang->line('edit_header');
                $this->breadcrumbs->push($this->lang->line('edit_header'), '/scorecards/DepartemenKpi/edit_form/'.$kd_departemen."/".$tahun);
                $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
                $Data['AlertInput']=$this->session->flashdata('AlertInput');

                $Data['DataMeasurement']=$this->departemen_kpi_model->get_measurement_remaining_bobot2($this->kd_perusahaan,$kd_departemen,$tahun);
                $Data['Tahun']=$tahun;
                $Data['ListTahun']= ListTahunBerjalan($this->config->item('year_apps'));
                $Data['ListMeasurement']=array();
                if($DataDepartemenKpi->num_rows() > 0)
                {
                    foreach($DataDepartemenKpi->result() as $row)
                    {
                        $Data['ListMeasurement'][$row->kd_measurement] = $row->kd_measurement; 
                    }
                }
                $Data['DataDepartemenKpi']= $DataDepartemenKpi;

                $this->template->temp_default();
                $this->template->add_section('viewjs', 'scorecards/DepartemenKpi_vf/v_DepartemenKpi_input_js',$Data);
                $this->load->view('DepartemenKpi_vf/v_DepartemenKpi_edit',$Data);
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
    // edit departemen_kpi
    public function edit()
    {
        $Kode=$this->uri->segment(4);
        $DataDepartemenKpi = $this->departemen_kpi_model->get_departemen_kpi_by_code($Kode);
        $Data=["success"=>false,"messages"=>array(),"data"=>array(),"kode"=>$Kode];
       
        if($DataDepartemenKpi->num_rows() > 0)
        {
            $this->form_validation->set_rules('kd_departemen_baru', $this->lang->line('kd_departemen_baru'), 'trim|required|max_length[5]|alpha_dash|callback__CekKodeDepartemenKpi['.$this->input->post('kd_departemen').']');
            $this->form_validation->set_rules('nm_departemen_kpi', $this->lang->line('nm_departemen_kpi'), 'trim|required');
            $this->form_validation->set_rules('kd_bd', $this->lang->line('kd_bd'), 'trim|required');
            $this->form_validation->set_rules('unit', $this->lang->line('unit'), 'trim|required');
            $this->form_validation->set_rules('period', $this->lang->line('period'), 'trim|required');
            $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
            
            
        
            if ($this->form_validation->run() == FALSE ){
                foreach($_POST as $key => $value)
                {
                    $Data['messages'][$key]= form_error($key);
                    //$Data['data']= $DataDepartemenKpi->row_array();
                }
            }else{
                    $kd_ms=$this->input->post('kd_departemen');
                    $Kode=$kd_ms.$this->kd_perusahaan;
                    $Input=['kd_departemen'=>$Kode,
                        'kd_ms'=>$kd_ms,
                        'nm_departemen_kpi'=>$this->input->post('nm_departemen_kpi'),
                        'kd_bd'=>$this->input->post('kd_bd'),
                        'unit'=>$this->input->post('unit'),
                        'period'=>$this->input->post('period')
                        ];

                    $this->departemen_kpi_model->update_departemen_kpi($Kode,$Input);
                    $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_edit'));
                    //insert user activity
                    $this->useractivity->run_acitivity('edit '.$this->lang->line('subheader'),$Kode,$Input,$DataDepartemenKpi->row_array());
                    $Data["success"]=true;
                
                
            }

        }
            echo json_encode($Data);
    }
    //cek exist kode DepartemenKpi
    public function _CekKodeDepartemenKpi($Str='',$KodeLama=''){
        $Data=$this->departemen_kpi_model->get_departemen_kpi_all_by_code_perusahaan($Str,$this->kd_perusahaan)->num_rows();
//        echo $KodeLama;
//        die();
        if($Str==$KodeLama){
            return TRUE;
        }else{
            if($Data>0){
                $this->form_validation->set_message('_CekKodeDepartemenKpi', $this->lang->line('error_kode'));
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    //cek exist kode DepartemenKpi
    public function _CekTahunTarget($Str='',$kd_departemen=''){
        $Data=$this->departemen_kpi_model->get_departemen_kpi_target_by_code($kd_departemen,$Str)->num_rows();
//        echo $KodeLama;
//        die();
            if($Data>0){
                $this->form_validation->set_message('_CekTahunTarget', $this->lang->line('error_tahun_exist'));
                return FALSE;
            }else{
                return TRUE;
            }
        
    }
    //delete departemen_kpi
    public function delete(){
        if($this->mion_auth->is_allowed('delete_departemen_kpi')){
            $DataDelete=$this->uri->segment(5);
            $tahun=$this->uri->segment(4);
            //get history data
            $DataDepartemenKpi = $this->departemen_kpi_model->get_departemen_kpi_by_kd_departemen($DataDelete,$tahun);
            $this->departemen_kpi_model->delete_departemen_kpi_kd_departemen($DataDelete,$tahun);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataDepartemenKpi->row_array());
        }

    }
    //delete departemen_kpi
    public function target_delete(){
        if($this->mion_auth->is_allowed('delete_departemen_kpi_target')){
            $DataDelete=$this->uri->segment(4);
            //get history data
            $DataDepartemenKpi = $this->departemen_kpi_model->get_departemen_kpi_target_by_code_mt($DataDelete);
            $this->departemen_kpi_model->delete_departemen_kpi_target($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('list_header_target'),$DataDelete,array(),$DataDepartemenKpi->row_array());
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
    
    public function get_list_measurement(){
        $Thn=$this->uri->segment(5);
        $kd_departemen=$this->uri->segment(4);
        $measurement = $this->input->post('data');
        $DataDepartemenKpi = $this->departemen_kpi_model->get_departemen_kpi_by_kd_departemen($kd_departemen,$Thn);
//        $Data["DataMeasurement"]=$this->departemen_kpi_model->get_measurement_search_multi_pegawai($kd_departemen,$measurement,$Thn);
        $Data["DataMeasurement"]=$this->departemen_kpi_model->get_measurement_search_multi2($measurement,$kd_departemen,$Thn);
        $Data['ListMeasurement']=array();
        if($DataDepartemenKpi->num_rows() > 0)
        {
            foreach($DataDepartemenKpi->result() as $row)
            {
                $Data['ListMeasurement'][$row->kd_measurement]['kode'] = $row->kd_measurement; 
                $Data['ListMeasurement'][$row->kd_measurement]['weightage_kpi'] = $row->weightage_kpi; 
                $Data['ListMeasurement'][$row->kd_measurement]['weightage_bd'] = $row->weightage_bd; 
                $Data['ListMeasurement'][$row->kd_measurement]['Tot_bobot_kpi'] = $row->Tot_bobot_kpi; 
            }
        }
        $this->load->view('DepartemenKpi_vf/v_DepartemenKpi_input_list',$Data);
    }
    
    public function get_list_measurement_view(){
        $Thn=$this->uri->segment(5);
        $kd_departemen=$this->uri->segment(4);
        $Data["weightage_kpi"] = $this->input->post('weightage_kpi');
        $Data["weightage_bd"] = $this->input->post('weightage_bd');
        $kd_measurement = $this->input->post('kd_measurement');
//        var_dump($Data["weightage_bd"] );
//        die();
        $Data["DataMeasurement"]=$this->departemen_kpi_model->get_measurement_search_multi2($kd_measurement,$kd_departemen,$Thn);
        $this->load->view('DepartemenKpi_vf/v_DepartemenKpi_view_list',$Data);
    }
    // copy bobot Departemen KPI
    public function copy_bobot()
    {
        $thn=$this->uri->segment(4);
        $kd_departemen=$this->uri->segment(5);
        $Data=["success"=>false,"messages"=>array(),'kode'=>$kd_departemen];
        $ThnLalu=$thn-1;
        $DataBobot=$this->departemen_kpi_model->get_departemen_kpi_by_kd_departemen($kd_departemen,$ThnLalu);
        if($DataBobot->num_rows() > 0)
        {
            $this->departemen_kpi_model->insert_copy_bobot_departemen_kpi($kd_departemen,$thn,$ThnLalu,$this->session->userdata('identity'),date("Y-m-d H:i:s"));
            //insert user activity
            $this->useractivity->run_acitivity('duplicate '.$this->lang->line('list_header_bobot')." ".$thn,$thn);
            $this->session->set_flashdata('AlertInput', $this->lang->line('success_duplicate'));
            $Data["success"]=true;
        }
        echo json_encode($Data);
    }
    // insert bobot bd departemen kpi
    public function bobot_insert_form()
    {   
        $tahun=$this->uri->segment(4);
        $kd_measurement=$this->uri->segment(5);
        $tahun=($tahun=="")?date("Y"):$tahun;
        if($this->mion_auth->is_allowed('add_departemen_kpi_bobot') and $kd_measurement!=""){
            $Data=array();
            $Data['DataMeasurementDept']=$this->departemen_kpi_model->get_departemen_kpi_by_kd_measurement($kd_measurement,$tahun);
            $Data['Tahun']=$tahun;
            $Data['ListTahun']= ListTahunBerjalan($this->config->item('year_apps'));
            
            $this->load->view('DepartemenKpi_vf/v_DepartemenKpi_Bobot_input',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_access'));
        }
    }
    // insert bobot business_driver
    public function bobot_save()
    {
        $tahun=$this->uri->segment(4);
        $kd_measurement=$this->uri->segment(5);
        $kd_departemen=$this->uri->segment(6);
        $tahun=($tahun=="")?date("Y"):$tahun;
        $Data=["success"=>false,"messages"=>array(),'kode'=>$kd_departemen];
        $this->form_validation->set_rules('tahun', $this->lang->line('tahun'), 'trim|required');
        
        $this->form_validation->set_rules('kd_departemen[]', $this->lang->line('kd_departemen'), 'trim|required');
        $this->form_validation->set_rules('weightage_bd[]', $this->lang->line('weightage_bd'), 'trim|required');
        
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        
        if ($this->form_validation->run() == FALSE ){
//                echo form_error('weightage[]');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                if($key=='weightage_bd'){
                    $Data['messages'][$key]= form_error('weightage_bd[]');
                }else if($key=='kd_departemen'){
                    $Data['messages'][$key]= form_error('kd_departemen[]');
                }else{
                    $Data['messages'][$key]= form_error('tahun');
                }
                
                
            }
        }else{
            $kd_departemen=$this->input->post('kd_departemen');
            $weightage_bd=$this->input->post('weightage_bd');
            $weightage_kpi=$this->input->post('weightage_kpi');
            $TotalBobot=$this->input->post('total_bobot');
//            $TotalBobot=0;
//            foreach($kd_bd as $key=>$val)
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
                $Data['messages']['error_total_bobot']= $this->lang->line('error_total_bobot');
            }
            else
            {
                $no=1;
                $this->departemen_kpi_model->delete_departemen_kpi_kd_measurement($kd_measurement,$tahun);
                foreach($kd_departemen as $key=>$val)
                {
                    $KodeDK=$tahun.$val.$kd_measurement;
                    $WBD=$weightage_bd[$key];
                    if($WBD==""){
                        $WBD=1;
                    }
                    $WKPI=$weightage_kpi[$key];
                    if($WKPI==""){
                        $WKPI=1;
                    }
                    //$this->departemen_kpi_model->delete_departemen_kpi($KodeDK);
                    $Input=['kd_dk'=>$KodeDK,
                            'tahun'=>$this->input->post('tahun'),
                            'kd_departemen'=>$val,
                            'kd_measurement'=>$kd_measurement,
                            'weightage_bd'=>$WBD,
                            'weightage_kpi'=>$WKPI,
                            'status'=>1,
                            'user_input'=>$this->session->userdata('identity'),
                            'tgl_input'=>date("Y-m-d H:i:s")
                            ];
                    $id=$this->departemen_kpi_model->insert_departemen_kpi($Input);

                    //insert user activity
                    $this->useractivity->run_acitivity('insert '.$this->lang->line('input_header_bobot'),$KodeDK,$Input);
                }

                    //$id=$this->business_driver_model->insert_business_driver($Input);

                    $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
                    $Data["success"]=true;

            }
        }
        
        echo json_encode($Data);
    }
}
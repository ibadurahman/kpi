<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BusinessDriver extends CI_Controller {
    private $kd_bd;
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('scorecards/BusinessDriver',$siteLang);
            $this->load->model('business_driver_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/scorecards/BusinessDriver');
            $this->kd_perusahaan = $this->session->userdata('ses_perusahaan');
            
            //get kode data
            $Data=$this->business_driver_model->get_business_driver_all($this->kd_perusahaan);
            if($Data->num_rows() > 0){
                $this->kd_bd=$Data->row()->kd_bd;
            }
    }
    
    //list business_driver
    public function index()
    {
        $Bln=$this->uri->segment(6);
        $Thn=$this->uri->segment(5);
        $Kode=$this->uri->segment(4);
        if($Thn=="" and $Bln==""){
            $Bln=date("m");
        }
        if($Kode==""){
            $Kode = $this->kd_bd;
            
        }
        $Data['DataBulan'] = ($Bln=="")? '':$Bln;
        $Data['DataTahun'] = ($Thn=="")?date("Y"):$Thn;
        $Data["title_web"]=$this->lang->line('title_web');
        $Data["subheader"]=$this->lang->line('subheader');
        $Data["list_header"]=$this->lang->line('list_header');
        $Data["input_header"]=$this->lang->line('view_header');
        $Data["result_header"]=$this->lang->line('result');
        $Data["list_header_bobot"]=$this->lang->line('list_header_bobot');
        $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
        $Data['AlertInput']=$this->session->flashdata('AlertInput');
        $Data['data_kd_bd']=$Kode;
        $Data['data_uri']= "scorecards/BusinessDriver/index/".$Kode;
        
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
        
        $Data['ListBusinessDriver']=$this->business_driver_model->get_business_driver_all($this->kd_perusahaan,$Data['DataTahun']);
        $Data['DataBusinessDriver'] = $this->business_driver_model->get_business_driver_by_code($Kode,$Thn);
        
        
        if($Bln!=""){
            $DataResult=$this->business_driver_model->get_business_driver_result_kd_bd_monthly($Kode,$Data['DataBulan'],$Data['DataTahun']);
            $Data['Historybd']=$this->business_driver_model->get_business_driver_result_history_kd_perspective($Kode,$Data['DataBulan'],$Data['DataTahun']);
            $Data['Chartbd']=$this->business_driver_model->get_business_driver_result_chart_monthly_kd_bd($Kode,$Data['DataBulan'],$Data['DataTahun']);
        } else {
            $DataResult=$this->business_driver_model->get_business_driver_result_kd_bd_yearly($Kode,$Data['DataBulan'],$Data['DataTahun']);
            $Data['Historybd']=$this->business_driver_model->get_business_driver_result_history_kd_perspective_yearly($Kode,$Data['DataTahun']);
            $Data['Chartbd']=$this->business_driver_model->get_business_driver_result_chart_yearly_kd_bd($Kode,$Data['DataTahun']);
        }
        $Data['Gaugebd']=0;
        if($DataResult->num_rows()>0){
            $Data['Gaugebd']=$DataResult->row()->point_result;
        }
        //insert user activity
        $this->useractivity->run_acitivity('index '.$this->lang->line('subheader'));
        $this->template->temp_default();
        $this->template->add_section('viewjs', 'scorecards/BusinessDriver_vf/v_BusinessDriver_js',$Data);
        $this->template->add_section('w_subheader', 'scorecards/BusinessDriver_vf/v_BusinessDriver_widget_subheader',$Data);
        $this->load->view('BusinessDriver_vf/v_BusinessDriver',$Data);
    }
    //get list business_driver json
    public function get_list()
    {
                    $tahun=$this->uri->segment(4);
                    if($tahun==""){
                        $tahun=date("Y");
                    }
                    $addsql = array();
                    $request = '';
                    $table = "business_driver LEFT JOIN perspective ON perspective.kd_perspective = business_driver.kd_perspective";
                    $custom_whare="perspective.kd_perusahaan ='$this->kd_perusahaan'";
                    $primaryKey = 'business_driver.kd_bd';
                    $columns = array(
                            array( 
                                    'NO', 
                                    'dt' => 0 ,
                                    'searchable' => FALSE
                            ),
                            array(
                                    'db' => 'business_driver.kd_bd',
                                    'dt' => 1,
                            ),
                            array( 
                                    'db' => 'business_driver.nm_bd', 
                                    'dt' => 2,
                            ),
                            array( 
                                    'db' => 'perspective.kd_perspective', 
                                    'dt' => 3,
                            )

                    );

                    $a_condition = array();
                    $a_condition_type = array(); 
                    $a_link = array();
                    $a_src = array();
                    $a_src_change = array();

                    
                            $a_link['View'] = '<a href="'. site_url('scorecards/BusinessDriver/view_form/').'#action_lock#/'.$tahun.'" class="#link_class#" title="#link_title#"><i class="la la-file-text"></i></a>';
                            $a_src['View'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupView';
                            
//                    if($this->mion_auth->is_allowed('edit_business_driver')) {
//                            $a_link['Edit'] = '<a href="'. site_url('scorecards/BusinessDriver/edit_form/').'#action_lock#" class="#link_class#" title="#link_title#"><i class="la la-edit"></i></a>';
//                            $a_src['Edit'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupEdit';
//                    }
                    if($this->mion_auth->is_allowed('delete_business_driver')) { 
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
                                    'action_lock'=>'kd_bd'
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
    // insert business_driver view
    public function insert_form()
    {   
        if($this->mion_auth->is_allowed('add_business_driver')){
            $Thn=$this->uri->segment(4);
            $Data=array();
            $Data['DataTahun']=($Thn=="")?date("Y"):$Thn;
            $DataPerspective=$this->business_driver_model->get_perspective_all_business_driver($this->kd_perusahaan);
            $Data['ListPerspective']=  get_value_array($DataPerspective,['kd_perspective','kd_ps'],'nm_perspective',TRUE);

            $this->load->view('BusinessDriver_vf/v_BusinessDriver_input',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_access'));
        }
    }
    // insert business_driver
    public function save()
    {
        $Thn=$this->uri->segment(4);
        $Data=["success"=>false,"messages"=>array(),'kode'=>""];
        //$this->form_validation->set_rules('kd_bd', $this->lang->line('kd_bd'), 'trim|required|max_length[5]|alpha_dash|callback__CekKodeBD[]');
        $this->form_validation->set_rules('nm_bd', $this->lang->line('nm_bd'), 'trim|required');
        $this->form_validation->set_rules('kd_perspective', $this->lang->line('kd_perspective'), 'trim|required');
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        
        if ($this->form_validation->run() == FALSE ){
//                echo form_error('kd_bd');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
            }
        }else{
                //$kd_bds=$this->input->post('kd_bd');
                $perspective=$this->input->post('kd_perspective');
                $arr_ps = explode("|", $perspective);
                $kd_bds=$this->business_driver_model->create_kd_bd($arr_ps[0],$arr_ps[1]);
                $Kode=$kd_bds.$this->kd_perusahaan;
                $stat_bobot=$this->input->post('stat_bobot');
                $Input=['kd_bd'=>$Kode,
                        'kd_bds'=>$kd_bds,
                        'nm_bd'=>$this->input->post('nm_bd'),
                        'kd_perspective'=>$arr_ps[0]
                        ];

                $id=$this->business_driver_model->insert_business_driver($Input);

                //insert user activity
                $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$Kode,$Input);
                $weightage=0;
                if($stat_bobot == 1)
                {
                    $weightage=1;
                
                }
                $kd_bdb=$Kode.$Thn;
                $Input=['kd_bdb'=>$kd_bdb,
                        'tahun'=>$Thn,
                        'kd_bd'=>$Kode,
                        'weightage'=>$weightage,
                        'status'=>1,
                        'user_input'=>$this->session->userdata('identity'),
                        'tgl_input'=>date("Y-m-d H:i:s")
                        ];
                $this->business_driver_model->insert_business_driver_bobot($Input);
                //insert user activity
                $this->useractivity->run_acitivity('insert '.$this->lang->line('list_header_bobot'),$kd_bdb,$Input);
                
                $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));    
                $Data["success"]=true;
                $Data["kode"]=$Kode;
            
            
        }
        
        echo json_encode($Data);
    }
    // insert bobot business_driver
    public function bobot_insert_form()
    {   
        $tahun=$this->uri->segment(4);
        $kd_perspective=$this->uri->segment(5);
        $tahun=($tahun=="")?date("Y"):$tahun;
        if($this->mion_auth->is_allowed('add_business_driver_bobot') and $kd_perspective!=""){
            $Data=array();
            $Data['DataBusinessDriver']=$this->business_driver_model->get_business_driver_by_perspective($kd_perspective,$tahun);
            $Data['Tahun']=$tahun;
            $Data['ListTahun']= ListTahunBerjalan($this->config->item('year_apps'));
            
            $this->load->view('BusinessDriver_vf/v_BusinessDriver_Bobot_input',$Data);
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
        $kd_perspective=$this->uri->segment(5);
        $kd_bd=$this->uri->segment(6);
        $tahun=($tahun=="")?date("Y"):$tahun;
        $Data=["success"=>false,"messages"=>array(),'kode'=>$kd_bd];
        $this->form_validation->set_rules('tahun', $this->lang->line('tahun'), 'trim|required');
        
        $this->form_validation->set_rules('kd_bd[]', $this->lang->line('kd_bd'), 'trim|required');
        $this->form_validation->set_rules('weightage[]', $this->lang->line('weightage'), 'trim|required');
        
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        
        if ($this->form_validation->run() == FALSE ){
//                echo form_error('weightage[]');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                if($key=='weightage'){
                    $Data['messages'][$key]= form_error('weightage[]');
                }else if($key=='kd_bd'){
                    $Data['messages'][$key]= form_error('kd_bd[]');
                }else{
                    $Data['messages'][$key]= form_error('tahun');
                }
                
                
            }
        }else{
            $kd_bd=$this->input->post('kd_bd');
            $weightage=$this->input->post('weightage');
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
                //echo $TotalBobot;
                $Data['messages']['error_total_bobot']= $this->lang->line('error_total_bobot');
            }
            else
            {
                $no=1;
                $this->business_driver_model->delete_business_driver_bobot($kd_perspective,$tahun);
                foreach($kd_bd as $key=>$val)
                {
                    $kd_bdb=$val.$this->input->post('tahun');
                    $Input=['kd_bdb'=>$kd_bdb,
                            'tahun'=>$this->input->post('tahun'),
                            'kd_bd'=>$val,
                            'weightage'=>$weightage[$key],
                            'status'=>1,
                            'user_input'=>$this->session->userdata('identity'),
                            'tgl_input'=>date("Y-m-d H:i:s")
                            ];
                    $id=$this->business_driver_model->insert_business_driver_bobot($Input);
                    //insert user activity
                    $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$kd_bdb,$Input);
                }

                    //$id=$this->business_driver_model->insert_business_driver($Input);

                    $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
                    $Data["success"]=true;

            }
        }
        
        echo json_encode($Data);
    }
    //edit form business_driver
    public function edit_form()
    {
        if($this->mion_auth->is_allowed('edit_business_driver')){
            $Kode=$this->uri->segment(4);
            $DataBusinessDriver = $this->business_driver_model->get_business_driver_by_code($Kode);
            if($DataBusinessDriver->num_rows() > 0)
            {
                
                $DataPerspective=$this->business_driver_model->get_perspective_all_business_driver($this->kd_perusahaan);
                $Data['ListPerspective']=  get_value_array($DataPerspective,['kd_perspective','kd_ps'],'nm_perspective',TRUE);

                $Data['DataBusinessDriver']= $DataBusinessDriver;

                $this->load->view('BusinessDriver_vf/v_BusinessDriver_edit',$Data);
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
    // edit business_driver
    public function edit()
    {
        $this->template->unset_template();
        $Kode=$this->uri->segment(4);
        $DataBusinessDriver = $this->business_driver_model->get_business_driver_by_code($Kode);
        $Data=["success"=>false,"messages"=>array(),"data"=>array(),"kode"=>$Kode];
        if($DataBusinessDriver->num_rows() > 0)
        {
            //$this->form_validation->set_rules('kd_bd_baru', $this->lang->line('kd_bd_baru'), 'trim|required|max_length[5]|alpha_dash|callback__CekKodeBD['.$this->input->post('kd_bd').']');
            $this->form_validation->set_rules('nm_bd', $this->lang->line('nm_bd'), 'trim|required');
            $this->form_validation->set_rules('kd_perspective', $this->lang->line('kd_perspective'), 'trim|required');
            $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
            
            
        
            if ($this->form_validation->run() == FALSE ){
                foreach($_POST as $key => $value)
                {
                    $Data['messages'][$key]= form_error($key);
                    //$Data['data']= $DataBusinessDriver->row_array();
                }
            }else{
                    $perspective=$this->input->post('kd_perspective');
                    $kd_perspective_lm=$this->input->post('kd_perspective_lm');
                    $arr_ps = explode("|", $perspective);
                    if($kd_perspective_lm==$arr_ps[0]){
                        $kd_bd=$Kode;
                        $Input=['nm_bd'=>$this->input->post('nm_bd'),
                                'kd_perspective'=>$arr_ps[0]
                        ];
                    }else{
                        $kd_bds=$this->business_driver_model->create_kd_bd($arr_ps[0],$arr_ps[1]);
                        //$kd_bds=$this->input->post('kd_bd_baru');
                        $kd_bd=$kd_bds.$this->kd_perusahaan;
                        $Input=['kd_bd'=>$kd_bd,
                                    'kd_bds'=>$kd_bds,
                                    'nm_bd'=>$this->input->post('nm_bd'),
                                    'kd_perspective'=>$arr_ps[0]
                            ];
                    }

                    $this->business_driver_model->update_business_driver($Kode,$Input);
                    $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_edit'));
                    //insert user activity
                    $this->useractivity->run_acitivity('edit '.$this->lang->line('subheader'),$Kode,$Input,$DataBusinessDriver->row_array());
                    $Data["success"]=true;
                    $Data["kode"]=$kd_bd;
                
            }

        }
            echo json_encode($Data);
    }
    //cek exist kode permission
    public function _CekKodeBD($Str='',$KodeLama=''){
        $Data=$this->business_driver_model->get_business_driver_by_code_perusahaan($Str, $this->kd_perusahaan)->num_rows();
//        echo $KodeLama;
//        die();
        if($Str==$KodeLama){
            return TRUE;
        }else{
            if($Data>0){
                $this->form_validation->set_message('_CekKodeBD', $this->lang->line('error_kode'));
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    //delete business_driver
    public function delete(){
        if($this->mion_auth->is_allowed('delete_business_driver')){
            $DataDelete=$this->uri->segment(4);
            //get history data
            $DataBusinessDriver = $this->business_driver_model->get_business_driver_by_code($DataDelete);
            $this->business_driver_model->delete_business_driver($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataBusinessDriver->row_array());
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
    // copy bobot business driver
    public function copy_bobot()
    {
        $thn=$this->uri->segment(4);
        $kd_perspective=$this->uri->segment(5);
        $kd_bd=$this->uri->segment(6);
        
        if($kd_bd==""){
            $kd_bd = $this->kd_bd;
            
        }
        $Data=["success"=>false,"messages"=>array(),'kode'=>$kd_bd."/".$thn];
        $ThnLalu=$thn-1;
        $DataPerspectiveBobot=$this->business_driver_model->get_business_driver_by_perspective($kd_perspective,$ThnLalu);
        if($DataPerspectiveBobot->num_rows() > 0)
        {
            $this->business_driver_model->insert_copy_business_driver_bobot($kd_perspective,$thn,$ThnLalu,$this->session->userdata('identity'),date("Y-m-d H:i:s"));
            //insert user activity
            $this->useractivity->run_acitivity('duplicate '.$this->lang->line('list_header_bobot')." ".$thn,$thn);
            $this->session->set_flashdata('AlertInput', $this->lang->line('success_duplicate'));
            $Data["success"]=true;
        }
        echo json_encode($Data);
    }
}


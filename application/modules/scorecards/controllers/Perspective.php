<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perspective extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('scorecards/Perspective',$siteLang);
            $this->load->model('perspective_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/scorecards/Perspective');
            $this->kd_perusahaan = $this->session->userdata('ses_perusahaan');
    }
    
    //list perspective
    public function index()
    {
        $Bln=$this->uri->segment(5);
        $Thn=$this->uri->segment(4);
        if($Thn=="" and $Bln==""){
            $Bln=date("m");
        }
        $Data['DataBulan'] = ($Bln=="")?$Bln= '':$Bln;
        $Data['DataTahun'] = ($Thn=="")?$Thn=date("Y"):$Thn;
        $Data["title_web"]=$this->lang->line('title_web');
        $Data["subheader"]=$this->lang->line('subheader');
        $Data["list_header"]=$this->lang->line('list_header');
        $Data["input_header"]=$this->lang->line('input_header');
        $Data["list_header_bobot"]=$this->lang->line('list_header_bobot');
        $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
        $Data['AlertInput']=$this->session->flashdata('AlertInput');
        $Data['data_uri']= "scorecards/Perspective/index";
        $Data['perspective_bobot']= $this->perspective_model->get_perspective_bobot_by_tahun($Thn,$this->kd_perusahaan);
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
        $Data['list_perspective']=$this->perspective_model->get_perspective_result_chart($this->kd_perusahaan,$Data['DataTahun']);
        
        if($Bln!="") {
            $Data['radar_perspective']=$this->perspective_model->get_perspective_result_radar_monthly($this->kd_perusahaan,$Data['DataTahun'],$Data['DataBulan']);
            $Data['line_perspective']=$this->perspective_model->get_perspective_result_chart_monthly($this->kd_perusahaan,$Data['DataBulan'],$Data['DataTahun']);
        } else {
            $Data['radar_perspective']=$this->perspective_model->get_perspective_result_radar_yearly($this->kd_perusahaan,$Data['DataTahun'],$Data['DataBulan']);
            $Data['line_perspective']=$this->perspective_model->get_perspective_bar_chart_tahun($this->kd_perusahaan,$Data['DataTahun']);
        }
        //insert user activity
        $this->useractivity->run_acitivity('index '.$this->lang->line('subheader'));
        $this->template->temp_default();
        $this->template->add_section('viewjs', 'scorecards/Perspective_vf/v_Perspective_js',$Data);
        $this->template->add_section('w_subheader', 'scorecards/Perspective_vf/v_Perspective_widget_subheader',$Data);
        $this->load->view('Perspective_vf/v_Perspective',$Data);
    }
    //get list perspective json
    public function get_list()
    {
                    $tahun=$this->uri->segment(4);
                    $bulan=$this->uri->segment(5);
                    if($tahun=="" and $bulan==""){
                        $bulan=date("m");
                    }
                    if($tahun==""){
                        $tahun=date("Y");
                    }
                    $addsql = array();
                    $request = '';
                    $table = "(select perspective.*, jml_data.jmldata
                                from perspective
                                LEFT JOIN (
                                        select business_driver.kd_perspective, count(business_driver.kd_perspective)jmldata
                                        from business_driver
                                        group by business_driver.kd_perspective
                                )as jml_data ON perspective.kd_perspective = jml_data.kd_perspective)tbl_data";
                    $custom_whare="tbl_data.kd_perusahaan ='$this->kd_perusahaan'";
                    $primaryKey = 'tbl_data.kd_perspective';
                    $columns = array(
                            array( 
                                    'NO', 
                                    'dt' => 0 ,
                                    'searchable' => FALSE
                            ),
                            array(
                                    'db' => 'tbl_data.kd_perspective',
                                    'dt' => 1,
                            ),
                            array(
                                    'db' => 'tbl_data.kd_ps',
                                    'dt' => 2,
                            ),
                            array( 
                                    'db' => 'tbl_data.nm_perspective', 
                                    'dt' => 3,
                            ),
                            array( 
                                    'db' => 'tbl_data.jmldata', 
                                    'dt' => 4,
                            )

                    );

                    $a_condition = array();
                    $a_condition_type = array(); 
                    $a_link = array();
                    $a_src = array();
                    $a_src_change = array();

                    
                            $a_link['View'] = '<a href="'. site_url('scorecards/Perspective/view_form/').'#action_lock#/'.$tahun.'/'.$bulan.'" class="#link_class#" title="#link_title#"><i class="la la-file-text"></i></a>';
                            $a_src['View'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupView';
                            
//                    if($this->mion_auth->is_allowed('edit_perspective')) {
//                            $a_link['Edit'] = '<a href="'. site_url('scorecards/Perspective/edit_form/').'#action_lock#" class="#link_class#" title="#link_title#"><i class="la la-edit"></i></a>';
//                            $a_src['Edit'] = 'm-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill openPopupEdit';
//                    }
                    if($this->mion_auth->is_allowed('delete_perspective')) { 
                            $a_condition['Delete']=[4=>'|0'];
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
                                    'action_lock'=>'kd_perspective'
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
    //get list bobot perspective json
    public function get_list_bobot()
    {
                    $tahun=$this->uri->segment(4);
                    if($tahun==""){
                        $tahun=date("Y");
                    }
//                    $addsql = array();
//                    $request = '';
                    $table = "(select perspective.*, 
                                                        ifnull(perspective_bobot.weightage,0) weightage,
                                                        perspective_bobot.kd_pb,
                                                        perspective_bobot.weightage_persen,
                                                        perspective_bobot.tahun,
                                                        perspective_bobot.`status`,
                                                        tbl_total_bobot.total_weightage,
                                                        round((ifnull(perspective_bobot.weightage,0)/tbl_total_bobot.total_weightage)*100,2) bobot
                                from perspective 
                                LEFT JOIN perspective_bobot ON perspective_bobot.kd_perspective = perspective.kd_perspective,
                                (
                                    select SUM(perspective_bobot.weightage) as total_weightage 
                                    from perspective_bobot 
                                    INNER JOIN perspective ON perspective_bobot.kd_perspective = perspective.kd_perspective
                                    where perspective.kd_perusahaan = '$this->kd_perusahaan' and perspective_bobot.tahun = '$tahun'
                                ) as tbl_total_bobot
                               ) as tbl_pb";
                    $custom_whare="tbl_pb.kd_perusahaan ='$this->kd_perusahaan' and tbl_pb.tahun = '$tahun'";
                    $primaryKey = 'tbl_pb.kd_pb';
                    $columns = array(
                            array( 
                                    'NO', 
                                    'dt' => 0 ,
                                    'searchable' => FALSE
                            ),
                            array(
                                    'db' => 'tbl_pb.kd_ps',
                                    'dt' => 1,
                            ),
                            array( 
                                    'db' => 'tbl_pb.nm_perspective', 
                                    'dt' => 2,
                            ),
                            array( 
                                    'db' => 'tbl_pb.bobot', 
                                    'dt' => 3,
                                    'formatter' => function( $d, $row ) {
                                                return $d."%";
                                            }
                            )

                    );

                    $a_condition = array();
                    $a_condition_type = array(); 
                    $a_link = array();
                    $a_src = array();
                    $a_src_change = array();

                    
                            $a_link['View'] = '<a href="'. site_url('scorecards/Perspective/view_form/').'#action_lock#" class="#link_class#" title="#link_title#"><i class="la la-file-text"></i></a>';
                            $a_src['View'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupView';
                            
//                    if($this->mion_auth->is_allowed('edit_perspective')) {
//                            $a_link['Edit'] = '<a href="'. site_url('scorecards/Perspective/edit_form/').'#action_lock#" class="#link_class#" title="#link_title#"><i class="la la-edit"></i></a>';
//                            $a_src['Edit'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupEdit';
//                    }
                    if($this->mion_auth->is_allowed('delete_perspective')) { 
                            $a_link['Delete'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-trash"></i></a>';
                            $a_src['Delete'] = 'm-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-data';
                    }
                    //add to ajax columns
                    $columns[] = array();

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
    // insert perspective view
    public function insert_form()
    {   
        if($this->mion_auth->is_allowed('add_perspective')){
            $Thn=$this->uri->segment(4);
            $Data=array();
            $Data['DataTahun']=($Thn=="")?date("Y"):$Thn;
            $this->load->view('Perspective_vf/v_Perspective_input',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_access'));
        }
    }
    // insert perspective
    public function save()
    {
        $Thn=$this->uri->segment(4);
        $Data=["success"=>false,"messages"=>array(),'kode'=>''];
        $this->form_validation->set_rules('kd_perspective', $this->lang->line('kd_perspective'), 'trim|required|max_length[5]|alpha_dash|callback__CekKodePerspective[]');
        $this->form_validation->set_rules('nm_perspective', $this->lang->line('nm_perspective'), 'trim|required');
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        
        if ($this->form_validation->run() == FALSE ){
//                echo form_error('kd_perspective');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
            }
        }else{
                $kd_ps=$this->input->post('kd_perspective');
                $stat_bobot=$this->input->post('stat_bobot');
                $Kode=$kd_ps.$this->kd_perusahaan;
                $Input=['kd_perspective'=>$Kode,
                        'kd_ps'=>$kd_ps,
                        'nm_perspective'=>$this->input->post('nm_perspective'),
                        'kd_perusahaan'=>$this->kd_perusahaan
                        ];

                $id=$this->perspective_model->insert_perspective($Input);
                //insert user activity
                $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$this->input->post('kd_perspective'),$Input);
                $weightage=0;
                if($stat_bobot == 1)
                {
                    $weightage=1;
                
                }
                    $kd_pb=$Kode.$Thn;
                    $Input=['kd_pb'=>$kd_pb,
                            'tahun'=>$Thn,
                            'kd_perspective'=>$Kode,
                            'weightage'=>$weightage,
                            'status'=>1,
                            'user_input'=>$this->session->userdata('identity'),
                            'tgl_input'=>date("Y-m-d H:i:s")
                            ];
                    $id=$this->perspective_model->insert_perspective_bobot($Input);
                    //insert user activity
                    $this->useractivity->run_acitivity('insert '.$this->lang->line('list_header_bobot'),$kd_pb,$Input);
                
                
                $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
                $Data["success"]=true;
            
            
        }
        
        echo json_encode($Data);
    }
    // insert bobot perspective
    public function bobot_insert_form()
    {   
        if($this->mion_auth->is_allowed('add_perspective_bobot')){
            $Thn=$this->uri->segment(4);
            $Data=array();
            $Data['DataTahun']=($Thn=="")?date("Y"):$Thn;
            $Data['DataPerspective']=$this->perspective_model->get_perspective_all_perusahaan($this->kd_perusahaan);
            
            $Data['ListTahun']= ListTahunBerjalan($this->config->item('year_apps'));
            
            $this->load->view('Perspective_vf/v_Perspective_Bobot_input',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_access'));
        }
    }
    // insert bobot perspective
    public function bobot_save()
    {
        $Data=["success"=>false,"messages"=>array(),'kode'=>''];
        $DataPerspective=$this->perspective_model->get_perspective_all();
        $this->form_validation->set_rules('tahun', $this->lang->line('tahun'), 'trim|required|callback__CekKode[]');
        
        $this->form_validation->set_rules('kd_perspective[]', $this->lang->line('kd_perspective'), 'trim|required');
        $this->form_validation->set_rules('weightage[]', $this->lang->line('weightage'), 'trim|required');
        
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        
        if ($this->form_validation->run() == FALSE ){
//                echo form_error('weightage[]');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                if($key=='weightage'){
                    $Data['messages'][$key]= form_error('weightage[]');
                }else if($key=='kd_perspective'){
                    $Data['messages'][$key]= form_error('kd_perspective[]');
                }else{
                    $Data['messages'][$key]= form_error('tahun');
                }
                
                
            }
        }else{
            $kd_perspective=$this->input->post('kd_perspective');
            $weightage=$this->input->post('weightage');
            $TotalBobot=$this->input->post('total_bobot');
//            foreach($kd_perspective as $key=>$val)
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
                foreach($kd_perspective as $key=>$val)
                {
                    $kd_pb=$val.$this->input->post('tahun');
                    $Input=['kd_pb'=>$kd_pb,
                            'tahun'=>$this->input->post('tahun'),
                            'kd_perspective'=>$val,
                            'weightage'=>$weightage[$key],
                            'status'=>1,
                            'user_input'=>$this->session->userdata('identity'),
                            'tgl_input'=>date("Y-m-d H:i:s")
                            ];
                    $id=$this->perspective_model->insert_perspective_bobot($Input);
                    //insert user activity
                    $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$kd_pb,$Input);
                }

                    //$id=$this->perspective_model->insert_perspective($Input);

                    $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
                    $Data["success"]=true;

            }
        }
        
        echo json_encode($Data);
    }
    // view perspective view
    public function view_form()
    {
        $Kode=$this->uri->segment(4);
        $Thn=$this->uri->segment(5);
        $Bln=$this->uri->segment(6);
        if($Thn=="" and $Bln==""){
            $Bln=date("m");
        }
        $Data['DataBulan'] = ($Bln=="")?$Bln= "":$Bln;
        $Data['DataTahun'] = ($Thn=="")?$Thn=date("Y"):$Thn;
        
        $DataPerspective = $this->perspective_model->get_perspective_by_code($Kode);
        if($DataPerspective->num_rows() > 0)
        {
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('view_header');
            $Data["list_header"]=$this->lang->line('list_header');
            $Data["input_header"]=$this->lang->line('view_header');
            $Data["result_header"]=$this->lang->line('result');
            $this->breadcrumbs->push($this->lang->line('view_header'), '/scorecards/Perspective/view_form/'.$Kode);
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['AlertInput']=$this->session->flashdata('AlertInput');
            $Data['data_uri']= "scorecards/Perspective/view_form/".$Kode;
        
            $Data['DataPerspective']= $DataPerspective;
            $DataBobot = $this->perspective_model->get_perspective_bobot_list_tahun($Kode,$Thn,$this->kd_perusahaan);
            $Data['weightage']=0;
            if($DataBobot->num_rows() > 0)
            {
                $RowBobot=$DataBobot->row();
                $Data['weightage'] = $RowBobot->bobot;
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
            $Data['ListPerspective']=$this->perspective_model->get_perspective_all_perusahaan($this->kd_perusahaan);
            
            
            
            
            if($Bln!="") {
                $DataResult=$this->perspective_model->get_perspective_result_kd_perspective_monthly($Kode,$Data['DataBulan'],$Data['DataTahun']);
                $Data['HistoryPerspective']=$this->perspective_model->get_perspective_result_history_kd_perspective($Kode,$Data['DataBulan'],$Data['DataTahun']);
                $Data['ChartPerspective']=$this->perspective_model->get_perspective_result_chart_monthly_kd_perspective($Kode,$Data['DataBulan'],$Data['DataTahun']);
            } else {
                $DataResult=$this->perspective_model->get_perspective_result_kd_perspective_yearly($Kode,$Data['DataTahun']);
                $Data['HistoryPerspective']=$this->perspective_model->get_perspective_result_history_kd_perspective_yearly($Kode,$Data['DataTahun']);
                $Data['ChartPerspective']=$this->perspective_model->get_perspective_result_chart_yearly_kd_perspective($Kode,$Data['DataTahun']);
            }
            $Data['GaugePerspective']=0;
            if($DataResult->num_rows()>0){
            $Data['GaugePerspective']=$DataResult->row()->point_result;
            }
             //insert user activity
            $this->useractivity->run_acitivity('view '.$this->lang->line('subheader'),$Kode);
                    
            $this->template->temp_default();
            $this->template->add_section('viewjs', 'scorecards/Perspective_vf/v_Perspective_view_js',$Data);
            $this->template->add_section('w_subheader', 'scorecards/Perspective_vf/v_Perspective_widget_subheader',$Data);
            $this->load->view('Perspective_vf/v_Perspective_view',$Data);
        }
        else
        {
            $Data['text_error']=$this->lang->line('not_found');
            $this->template->temp_default();
            $this->template->add_section('t_alert', 'alert_error',$Data);
        }
    }
    //edit form perspective
    public function edit_form()
    {
        if($this->mion_auth->is_allowed('edit_perspective')){
            $Kode=$this->uri->segment(4);
            $DataPerspective = $this->perspective_model->get_perspective_by_code($Kode);
            if($DataPerspective->num_rows() > 0)
            {
                

                $Data['DataPerspective']= $DataPerspective;

                $this->load->view('Perspective_vf/v_Perspective_edit',$Data);
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
    // edit perspective
    public function edit()
    {
        $this->template->unset_template();
        $Kode=$this->uri->segment(4);
        $DataPerspective = $this->perspective_model->get_perspective_by_code($Kode);
        $Data=["success"=>false,"messages"=>array(),"data"=>array(),"kode"=>$Kode];
        if($DataPerspective->num_rows() > 0)
        {
            $this->form_validation->set_rules('kd_perspective_baru', $this->lang->line('kd_perspective_baru'), 'trim|required|max_length[5]|alpha_dash|callback__CekKodePerspective['.$this->input->post('kd_perspective').']');
            $this->form_validation->set_rules('nm_perspective', $this->lang->line('nm_perspective'), 'trim|required');
            $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
            
            
        
            if ($this->form_validation->run() == FALSE ){
                foreach($_POST as $key => $value)
                {
                    $Data['messages'][$key]= form_error($key);
                    //$Data['data']= $DataPerspective->row_array();
                }
            }else{
                    $kd_ps=$this->input->post('kd_perspective_baru');
                    $kd_perspective=$kd_ps.$this->kd_perusahaan;
                    $Input=['kd_perspective'=>$kd_perspective,
                        'kd_ps'=>$kd_ps,
                        'nm_perspective'=>$this->input->post('nm_perspective'),
                        'kd_perusahaan'=>$this->kd_perusahaan
                        ];


                    $this->perspective_model->update_perspective($Kode,$Input);
                    $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_edit'));
                    //insert user activity
                    $this->useractivity->run_acitivity('edit '.$this->lang->line('subheader'),$Kode,$Input,$DataPerspective->row_array());
                    $Data["success"]=true;
                
                
            }

        }
            echo json_encode($Data);
    }
    //edit form perspective bobot
    public function bobot_edit_form()
    {
        if($this->mion_auth->is_allowed('edit_perspective_bobot')){
            $Kode=$this->uri->segment(4);
            $DataPerspectiveBobot = $this->perspective_model->get_perspective_bobot_by_tahun($Kode,$this->kd_perusahaan);
            if($DataPerspectiveBobot->num_rows() > 0)
            {
                $Data['DataTahun']=($Kode=="")?date("Y"):$Kode;
                
                $Data['DataPerspective']=$this->perspective_model->get_perspective_all_perusahaan($this->kd_perusahaan);
            
                $Data['ListTahun']= ListTahunBerjalan($this->config->item('year_apps'));
                $Data['DataPerspectiveBobot']= $DataPerspectiveBobot;

                $this->load->view('Perspective_vf/v_Perspective_Bobot_edit',$Data);
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
    // edit bobot perspective
    public function bobot_edit()
    {
        $Kode=$this->uri->segment(4);
        $Data=["success"=>false,"messages"=>array(),'kode'=>''];
        $DataPerspectiveBobot=$this->perspective_model->get_perspective_bobot_by_tahun($Kode,$this->kd_perusahaan);
        if($DataPerspectiveBobot->num_rows() > 0)
        {
            $this->form_validation->set_rules('tahun_baru', $this->lang->line('tahun'), 'trim|required|callback__CekKodeEdit['.$this->input->post('tahun').']');

            $this->form_validation->set_rules('kd_perspective[]', $this->lang->line('kd_perspective'), 'trim|required');
            $this->form_validation->set_rules('weightage[]', $this->lang->line('weightage'), 'trim|required');

            $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');


            if ($this->form_validation->run() == FALSE ){
    //                echo form_error('weightage[]');
    //                var_dump($_POST);
                foreach($_POST as $key => $value)
                {
                    if($key=='weightage'){
                        $Data['messages'][$key]= form_error('weightage[]');
                    }else if($key=='kd_perspective'){
                        $Data['messages'][$key]= form_error('kd_perspective[]');
                    }else{
                        $Data['messages'][$key]= form_error('tahun');
                    }


                }
            }else{
                $kd_perspective=$this->input->post('kd_perspective');
                $weightage=$this->input->post('weightage');
                $TotalBobot=$this->input->post('total_bobot');
//                echo $TotalBobot;
//                die();
//                foreach($kd_perspective as $key=>$val)
//                {
//                    if($weightage[$key]=="")
//                    {
//                        $Bobot=0;
//                    }
//                    else
//                    {
//                        $Bobot=$weightage[$key];
//                    }
//                    $TotalBobot=$TotalBobot+$Bobot;
//                }
                if($TotalBobot<100)
                {
                    //echo $TotalBobot;
                    $Data['messages']['error_total_bobot']= $this->lang->line('error_total_bobot');
                }
                else
                {
                    $no=1;
                    //delete data bobot
                    $this->perspective_model->delete_perspective_bobot($Kode,$this->kd_perusahaan);
                    // insert data bobot
                    foreach($kd_perspective as $key=>$val)
                    {
                        $kd_pb=$val.$this->input->post('tahun');
                        $Input=['kd_pb'=>$kd_pb,
                                'tahun'=>$this->input->post('tahun'),
                                'kd_perspective'=>$val,
                                'weightage'=>$weightage[$key],
                                'status'=>1,
                                'user_input'=>$this->session->userdata('identity'),
                                'tgl_input'=>date("Y-m-d H:i:s")
                                ];
                        $id=$this->perspective_model->insert_perspective_bobot($Input);
                        //insert user activity
                        $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$kd_pb,$Input);
                    }

                        //$id=$this->perspective_model->insert_perspective($Input);

                        $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
                        $Data["success"]=true;

                }
            }
        }
        echo json_encode($Data);
    }
    //cek exist kode permission
    public function _CekKodePerspective($Str='',$KodeLama=''){
        $Data=$this->perspective_model->get_perspective_by_code_perusahaan($Str,$this->kd_perusahaan)->num_rows();
//        echo $KodeLama;
//        die();
        if($Str==$KodeLama){
            return TRUE;
        }else{
            if($Data>0){
                $this->form_validation->set_message('_CekKodePerspective', $this->lang->line('error_kode'));
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    //cek exist tahun
    public function _CekKode($Str=''){
        $Data=$this->perspective_model->get_perspective_bobot_by_tahun($Str,$this->kd_perusahaan)->num_rows();
        if($Data>0){
                $this->form_validation->set_message('_CekKode', $this->lang->line('error_tahun_exist'));
                return FALSE;
            }else{
                return TRUE;
            }
        
    }
    //cek exist tahun edit
    public function _CekKodeEdit($Str='',$KodeLama=''){
        $Data=$this->perspective_model->get_perspective_bobot_by_tahun($Str,$this->kd_perusahaan)->num_rows();
        if($Str==$KodeLama){
            return TRUE;
        }else{
            if($Data>0){
                $this->form_validation->set_message('_CekKodeEdit', $this->lang->line('error_tahun_exist'));
                return FALSE;
            }else{
                return TRUE;
            }
        }
        
        
    }
    //delete perspective
    public function delete(){
        if($this->mion_auth->is_allowed('delete_perspective')){
            $DataDelete=$this->uri->segment(4);
            //get history data
            $DataPerspective = $this->perspective_model->get_perspective_by_code($DataDelete);
            $this->perspective_model->delete_perspective($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataPerspective->row_array());
        }

    }
    //delete bobot perspective
    public function delete_bobot(){
        if($this->mion_auth->is_allowed('delete_perspective_bobot')){
            $DataDelete=$this->uri->segment(4);
            //get history data
            $DataPerspective = $this->perspective_model->get_perspective_bobot_by_tahun($DataDelete,$this->kd_perusahaan);
            $this->perspective_model->delete_perspective_bobot($DataDelete,$this->kd_perusahaan);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('list_header_bobot'),$DataDelete,array(),$DataPerspective->row_array());
        }

    }
    protected function _list_status($Status=""){
        $Data['']='';
        $Data['1']=$this->lang->line('aktif');
        $Data['2']=$this->lang->line('resign');
        if($Status!=""){
            return $Data[$Status];
        }else{
            return $Data;
        }
    }
    protected function _list_kelamin($Status=""){
        $Data['']='';
        $Data['L']=$this->lang->line('pria');
        $Data['P']=$this->lang->line('wanita');
        if($Status!=""){
            return $Data[$Status];
        }else{
            return $Data;
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
    // edit bobot perspective
    public function copy_bobot()
    {
        $thn=$this->uri->segment(4);
        $Data=["success"=>false,"messages"=>array(),'kode'=>$thn];
        $ThnLalu=$thn-1;
        $DataPerspectiveBobot=$this->perspective_model->get_perspective_bobot_by_tahun($ThnLalu,$this->kd_perusahaan);
        if($DataPerspectiveBobot->num_rows() > 0)
        {
            $this->perspective_model->insert_copy_bobot($thn,$ThnLalu,$this->session->userdata('identity'),date("Y-m-d H:i:s"),$this->kd_perusahaan);
            //insert user activity
            $this->useractivity->run_acitivity('duplicate '.$this->lang->line('list_header_bobot')." ".$thn,$thn);
            $this->session->set_flashdata('AlertInput', $this->lang->line('success_duplicate'));
            $Data["success"]=true;
        }
        echo json_encode($Data);
    }
}


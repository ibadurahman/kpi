<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class WeightageCompany extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('scorecards/WeightageCompany',$siteLang);
            $this->load->model('weightage_company_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/scorecards/WeightageCompany');
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
        $Data['data_uri']= "scorecards/WeightageCompany/index";
     
        
        //insert user activity
        $this->useractivity->run_acitivity('index '.$this->lang->line('subheader'));
            
        $this->template->temp_default();
        $this->template->add_section('viewjs', 'scorecards/WeightageCompany_vf/v_WeightageCompany_js',$Data);
        $this->load->view('WeightageCompany_vf/v_WeightageCompany',$Data);
        //die();
    }
    //get list appraisal json
    public function get_list()
    {
                    $addsql = array();

                    $request = '';
                    $custom_whare="tbl_bobot.kd_perusahaan ='$this->kd_perusahaan' ";
                    
                        $table = " 
                        (   
                            SELECT weightage_company.*, perusahaan.nm_perusahaan
                            FROM weightage_company
                            INNER JOIN perusahaan ON weightage_company.kd_perusahaan = perusahaan.kd_perusahaan
                        )as tbl_bobot
                        
                        ";
                    $primaryKey = 'tbl_bobot.kd_wc';
                    $columns = array(
                            array( 
                                    'NO', 
                                    'dt' => 0 ,
                                    'searchable' => FALSE
                            ),
                            array(
                                    'db' => 'tbl_bobot.deskripsi',
                                    'dt' => 1,
                            ),
                            array( 
                                    'db' => 'tbl_bobot.bulan', 
                                    'dt' => 7,
                                    'default_value' => '',
                                    'formatter' => function( $d, $row ) {
                                                return getNamaBulan($d);
                                            }
                            ),
                            array(
                                    'db' => 'tbl_bobot.tahun',
                                    'dt' => 2,
                            )

                    );

                    $a_condition = array();
                    $a_condition_type = array(); 
                    $a_link = array();
                    $a_src = array();
                    $a_src_change = array();

                            $a_link['View'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock_2#"><i class="la la-file-text"></i></a>';
                            $a_src['View'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupView';
                            
                    if($this->mion_auth->is_allowed('add_weightage_company')) {
                            $a_link['input'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-plus"></i></a>';
                            $a_src['input'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupAdd';
                    }        
                    if($this->mion_auth->is_allowed('edit_weightage_company')) {
                            $a_link['edit'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock_2#"><i class="la la-edit"></i></a>';
                            $a_src['edit'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupEdit';
                    }
                    //add to ajax columns
                    $columns[] = array(
                                    'action',
                                    'searchable' => FALSE,
                                    'dt'=>10,
                                    'condition'=>$a_condition,
                                    'condition_type'=>$a_condition_type,
                                    'action_link'=>$a_link,
                                    'action_src'=>$a_src,
                                    'action_src_change'=>$a_src_change,
                                    'action_lock'=>'nip',
                                    'action_lock_2'=>'kd_wc'
                            );

                    // manual ordering at the first page load (server side)
                    if( $_GET['order'][0]['column'] == 0)
                    {
                            $_GET['order'][0]['column'] = '3';
                            $_GET['order'][0]['dir'] = 'desc';
                            $_GET['order'][1]['column'] = '2';
                            $_GET['order'][1]['dir'] = 'desc';
                    }

                    //
                    echo json_encode(
                            SSP::simple( $_GET, $table, $primaryKey, $columns,$custom_whare)
                    );
    }
    public function insert_form()
    {   
        if($this->mion_auth->is_allowed('add_pegawai')){
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader');
            $Data["input_header"]=$this->lang->line('input_header');
            $this->breadcrumbs->push($this->lang->line('input_header'), '/scorecards/WeightageCompany/insert_form');
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['AlertInput']=$this->session->flashdata('AlertInput');

            $DataPerspective=$this->weightage_company_model->get_perspective_weightage_company($this->kd_perusahaan);
            $Data['DataPerspective']=  $DataPerspective;
            $DataBD=$this->weightage_company_model->get_bd_weightage_company($this->kd_perusahaan);
            $Data['DataBD']=  $DataBD;
            $Data['ListTahun']= ListTahunBerjalan($this->config->item('year_apps'));
            $Data['ListBulan']= ListBulan();

            $this->template->temp_default();
            $this->template->add_section('viewjs', 'scorecards/WeightageCompany_vf/v_WeightageCompany_js');
            $this->load->view('WeightageCompany_vf/v_WeightageCompany_input',$Data);
        }
        else
        {
            $Data['text_error']=$this->lang->line('not_access');
            $this->template->temp_default();
            $this->template->add_section('t_alert', 'alert_error',$Data);
        }
    }
    
}


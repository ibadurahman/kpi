<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Level extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('organisasi/Level',$siteLang);
            $this->load->model('level_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/organisasi/Level');
            $this->kd_perusahaan = $this->session->userdata('ses_perusahaan');
    }
    
    //list level
    public function index()
    {
        $Data["title_web"]=$this->lang->line('title_web');
        $Data["subheader"]=$this->lang->line('subheader');
        $Data["list_header"]=$this->lang->line('list_header');
        $Data["input_header"]=$this->lang->line('input_header');
        $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
        $Data['AlertInput']=$this->session->flashdata('AlertInput');
        
        
        //insert user activity
        $this->useractivity->run_acitivity('index '.$this->lang->line('subheader'));
        $this->template->temp_default();
        $this->template->add_section('viewjs', 'organisasi/Level_vf/v_Level_js');
        $this->load->view('Level_vf/v_Level',$Data);
    }
    //get list level json
    public function get_list()
    {
                    $addsql = array();

                    $request = '';
                    $table = " 
                            level INNER JOIN (select * from level where kd_perusahaan ='$this->kd_perusahaan') lv2 ON lv2.kd_level = level.kd_level
                    ";
                    $primaryKey = 'level.kd_level';
                    $columns = array(
                            array( 
                                    'NO', 
                                    'dt' => 0 ,
                                    'searchable' => FALSE
                            ),
                            array(
                                    'db' => 'level.kd_level',
                                    'dt' => 1,
                            ),
                            array( 
                                    'db' => 'level.nm_level', 
                                    'dt' => 2,
                            ),
                            array( 
                                    'db' => 'level.level', 
                                    'dt' => 3,
                            )

                    );

                    $a_condition = array();
                    $a_condition_type = array(); 
                    $a_link = array();
                    $a_src = array();
                    $a_src_change = array();

                    
                            $a_link['View'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-file-text"></i></a>';
                            $a_src['View'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupView';
                            
                    if($this->mion_auth->is_allowed('edit_level')) {
                            $a_link['Edit'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-edit"></i></a>';
                            $a_src['Edit'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupEdit';
                    }
                    if($this->mion_auth->is_allowed('delete_level')) { 
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
                                    'action_lock'=>'kd_level'
                            );

                    // manual ordering at the first page load (server side)
                    if( $_GET['order'][0]['column'] == 0)
                    {
                            $_GET['order'][0]['column'] = '3';
                            $_GET['order'][0]['dir'] = 'desc';
                    }

                    //
                    echo json_encode(
                            SSP::simple( $_GET, $table, $primaryKey, $columns)
                    );
    }
    // insert level view
    public function insert_form()
    {   
        if($this->mion_auth->is_allowed('add_level')){
            $Data=array();

            $this->load->view('Level_vf/v_Level_input',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_access'));
        }
    }
    // insert level
    public function save()
    {
        $Data=["success"=>false,"messages"=>array()];
        $this->form_validation->set_rules('nm_level', $this->lang->line('nm_level'), 'trim|required');
        $this->form_validation->set_rules('level', $this->lang->line('level'), 'trim|required');
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        if ($this->form_validation->run() == FALSE ){
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
            }
        }else{
            
            $Input=['nm_level'=>$this->input->post('nm_level'),
                    'level'=>$this->input->post('level'),
                    'kd_perusahaan'=>$this->kd_perusahaan
                    ];
            
            $id=$this->level_model->insert_level($Input);
            
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
            //insert user activity
            $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$id,$Input);
            $Data["success"]=true;
        }
        
        echo json_encode($Data);
    }
    // view level view
    public function view_form()
    {
        $Kode=$this->uri->segment(4);
        $DataLevel = $this->level_model->get_level_by_code($Kode);
        if($DataLevel->num_rows() > 0)
        {
            $Data['DataLevel']= $DataLevel;
            //insert user activity
            $this->useractivity->run_acitivity('view '.$this->lang->line('subheader'),$Kode);
            $this->load->view('Level_vf/v_Level_view',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_found'));
        }
    }
    //edit form level
    public function edit_form()
    {
        if($this->mion_auth->is_allowed('edit_level')){
            $Kode=$this->uri->segment(4);
            $DataLevel = $this->level_model->get_level_by_code($Kode);
            if($DataLevel->num_rows() > 0)
            {
                $Data['DataLevel']= $DataLevel;
                $this->load->view('Level_vf/v_Level_edit',$Data);
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
    // edit level
    public function edit()
    {
        $this->template->unset_template();
        $Kode=$this->uri->segment(4);
        $DataLevel = $this->level_model->get_level_by_code($Kode);
        $Data=["success"=>false,"messages"=>array(),"data"=>array()];
        if($DataLevel->num_rows() > 0)
        {
            $this->form_validation->set_rules('nm_level', $this->lang->line('nm_level'), 'trim|required');
            $this->form_validation->set_rules('level', $this->lang->line('level'), 'trim|required');
            $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
            
            if ($this->form_validation->run() == FALSE){
                foreach($_POST as $key => $value)
                {
                    $Data['messages'][$key]= form_error($key);
                    //$Data['data']= $DataLevel->row_array();
                }
            }else{
            
                $Input=['nm_level'=>$this->input->post('nm_level'),
                        'level'=>$this->input->post('level'),
                        'kd_perusahaan'=>$this->kd_perusahaan
                        ];
                    

                $this->level_model->update_level($Kode,$Input);
                $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_edit'));
                //insert user activity
                $this->useractivity->run_acitivity('edit '.$this->lang->line('subheader'),$Kode,$Input,$DataLevel->row_array());
                $Data["success"]=true;
            }

        }
            echo json_encode($Data);
    }
    //delete level
    public function delete(){
        if($this->mion_auth->is_allowed('delete_level')){
            $DataDelete=$this->uri->segment(4);
            //get history data
            $DataLevel = $this->level_model->get_level_by_code($DataDelete);
            $this->level_model->delete_level($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataLevel->row_array());
        }

    }
    
}


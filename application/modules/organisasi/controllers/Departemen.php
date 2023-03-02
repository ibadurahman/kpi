<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Departemen extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('organisasi/Departemen',$siteLang);
            $this->load->model('departemen_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/organisasi/Departemen');
            $this->kd_perusahaan = $this->session->userdata('ses_perusahaan');
    }
    
    //list departemen
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
        $this->template->add_section('viewjs', 'organisasi/Departemen_vf/v_Departemen_js');
        $this->load->view('Departemen_vf/v_Departemen',$Data);
        //die();
    }
    //get list departemen json
    public function get_list()
    {
                    $addsql = array();

                    $request = '';
                    $table = " 
                            departemen INNER JOIN (select * from departemen where kd_perusahaan ='$this->kd_perusahaan') dp2 ON dp2.kd_departemen = departemen.kd_departemen
                    ";
                    $primaryKey = 'departemen.kd_departemen';
                    $columns = array(
                            array( 
                                    'NO', 
                                    'dt' => 0 ,
                                    'searchable' => FALSE
                            ),
                            array(
                                    'db' => 'departemen.kd_departemen',
                                    'dt' => 1,
                            ),
                            array( 
                                    'db' => 'departemen.nm_departemen', 
                                    'dt' => 2,
                            )

                    );

                    $a_condition = array();
                    $a_condition_type = array(); 
                    $a_link = array();
                    $a_src = array();
                    $a_src_change = array();

                    
                            $a_link['View'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-file-text"></i></a>';
                            $a_src['View'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupView';
                            
                    if($this->mion_auth->is_allowed('edit_departemen')) {
                            $a_link['Edit'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-edit"></i></a>';
                            $a_src['Edit'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupEdit';
                    }
                    if($this->mion_auth->is_allowed('delete_departemen')) { 
                            $a_link['Delete'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-trash"></i></a>';
                            $a_src['Delete'] = 'm-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-data';
                    }
                    //add to ajax columns
                    $columns[] = array(
                                    'action',
                                    'searchable' => FALSE,
                                    'dt'=>3,
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
                            $_GET['order'][0]['column'] = '2';
                            $_GET['order'][0]['dir'] = 'asc';
                    }

                    //
                    echo json_encode(
                            SSP::simple( $_GET, $table, $primaryKey, $columns)
                    );
    }
    // insert departemen view
    public function insert_form()
    {   
        if($this->mion_auth->is_allowed('add_departemen')){
            $Data=array();

            $this->load->view('Departemen_vf/v_Departemen_input',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_access'));
        }
    }
    // insert departemen
    public function save()
    {
        $Data=["success"=>false,"messages"=>array()];
        $this->form_validation->set_rules('nm_departemen', $this->lang->line('nm_departemen'), 'trim|required');
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        if ($this->form_validation->run() == FALSE ){
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
            }
        }else{
            
            $Input=['nm_departemen'=>$this->input->post('nm_departemen'),
                    'kd_perusahaan'=>$this->kd_perusahaan
                    ];
            
            $id=$this->departemen_model->insert_departemen($Input);
            
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
            //insert user activity
            $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$id,$Input);
            $Data["success"]=true;
        }
        
        echo json_encode($Data);
    }
    // view departemen view
    public function view_form()
    {
        $Kode=$this->uri->segment(4);
        $DataDepartemen = $this->departemen_model->get_departemen_by_code($Kode);
        if($DataDepartemen->num_rows() > 0)
        {
            //insert user activity
            $this->useractivity->run_acitivity('view '.$this->lang->line('subheader'),$Kode);
            $Data['DataDepartemen']= $DataDepartemen;
            $this->load->view('Departemen_vf/v_Departemen_view',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_found'));
        }
    }
    //edit form departemen
    public function edit_form()
    {
        if($this->mion_auth->is_allowed('edit_departemen')){
            $Kode=$this->uri->segment(4);
            $DataDepartemen = $this->departemen_model->get_departemen_by_code($Kode);
            if($DataDepartemen->num_rows() > 0)
            {
                $Data['DataDepartemen']= $DataDepartemen;
                $this->load->view('Departemen_vf/v_Departemen_edit',$Data);
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
    // edit departemen
    public function edit()
    {
        $this->template->unset_template();
        $Kode=$this->uri->segment(4);
        $DataDepartemen = $this->departemen_model->get_departemen_by_code($Kode);
        $Data=["success"=>false,"messages"=>array(),"data"=>array()];
        if($DataDepartemen->num_rows() > 0)
        {
            $this->form_validation->set_rules('nm_departemen', $this->lang->line('nm_departemen'), 'trim|required');
            $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
            
            if ($this->form_validation->run() == FALSE){
                foreach($_POST as $key => $value)
                {
                    $Data['messages'][$key]= form_error($key);
                    //$Data['data']= $DataDepartemen->row_array();
                }
            }else{
            
                $Input=['nm_departemen'=>$this->input->post('nm_departemen'),
                        'kd_perusahaan'=>$this->kd_perusahaan
                        ];
                    

                $this->departemen_model->update_departemen($Kode,$Input);
                $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_edit'));
                //insert user activity
                $this->useractivity->run_acitivity('edit '.$this->lang->line('subheader'),$Kode,$Input,$DataDepartemen->row_array());
                $Data["success"]=true;
            }

        }
            echo json_encode($Data);
    }
    //delete departemen
    public function delete(){
        if($this->mion_auth->is_allowed('delete_departemen')){
            $DataDelete=$this->uri->segment(4);
            //get history data
            $DataDepartemen = $this->departemen_model->get_departemen_by_code($DataDelete);
            //delete data
            $this->departemen_model->delete_departemen($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataDepartemen->row_array());
        }

    }
    
}


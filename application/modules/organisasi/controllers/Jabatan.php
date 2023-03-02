<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jabatan extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('organisasi/Jabatan',$siteLang);
            $this->load->model('jabatan_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/organisasi/Jabatan');
            $this->kd_perusahaan = $this->session->userdata('ses_perusahaan');
    }
    
    //list jabatan
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
        $this->template->add_section('viewjs', 'organisasi/Jabatan_vf/v_Jabatan_js');
        $this->load->view('Jabatan_vf/v_Jabatan',$Data);
    }
    //get list jabatan json
    public function get_list()
    {
                    $addsql = array();

                    $request = '';
                    $table = " 
                            jabatan INNER JOIN (select kd_jabatan, nm_jabatan from jabatan where jabatan.kd_perusahaan ='$this->kd_perusahaan')jb2 ON jb2.kd_jabatan = jabatan.kd_jabatan
                                LEFT JOIN level ON jabatan.kd_level = level.kd_level 
                            
                    ";
                    $primaryKey = 'jabatan.kd_jabatan';
                    $columns = array(
                            array( 
                                    'NO', 
                                    'dt' => 0 ,
                                    'searchable' => FALSE
                            ),
                            array(
                                    'db' => 'jabatan.kd_jabatan',
                                    'dt' => 1,
                            ),
                            array( 
                                    'db' => 'jabatan.nm_jabatan', 
                                    'dt' => 2,
                            ),
                            array( 
                                    'db' => 'level.nm_level', 
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
                            
                    if($this->mion_auth->is_allowed('edit_jabatan')) {
                            $a_link['Edit'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-edit"></i></a>';
                            $a_src['Edit'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupEdit';
                    }
                    if($this->mion_auth->is_allowed('delete_jabatan')) { 
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
                                    'action_lock'=>'kd_jabatan'
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
    // insert jabatan view
    public function insert_form()
    {   
        if($this->mion_auth->is_allowed('add_jabatan')){
            $Data=array();
            $DataLevel=$this->jabatan_model->get_level_all_jabatan($this->kd_perusahaan);
            $Data['ListLevel']=  get_value_array($DataLevel,'kd_level','nm_level',TRUE);

            $this->load->view('Jabatan_vf/v_Jabatan_input',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_access'));
        }
    }
    // insert jabatan
    public function save()
    {
        $Data=["success"=>false,"messages"=>array()];
        $this->form_validation->set_rules('nm_jabatan', $this->lang->line('nm_jabatan'), 'trim|required');
        $this->form_validation->set_rules('kd_level', $this->lang->line('kd_level'), 'trim|required');
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        if ($this->form_validation->run() == FALSE ){
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
            }
        }else{
            
            $Input=['nm_jabatan'=>$this->input->post('nm_jabatan'),
                    'kd_level'=>$this->input->post('kd_level'),
                    'kd_perusahaan'=>$this->kd_perusahaan
                    ];
            
            $id=$this->jabatan_model->insert_jabatan($Input);
            
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
            //insert user activity
            $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$id,$Input);
            $Data["success"]=true;
        }
        
        echo json_encode($Data);
    }
    // view jabatan view
    public function view_form()
    {
        $Kode=$this->uri->segment(4);
        $DataJabatan = $this->jabatan_model->get_jabatan_by_code($Kode);
        if($DataJabatan->num_rows() > 0)
        {
            //insert user activity
            $this->useractivity->run_acitivity('view '.$this->lang->line('subheader'),$Kode);
            $Data['DataJabatan']= $DataJabatan;
            $this->load->view('Jabatan_vf/v_Jabatan_view',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_found'));
        }
    }
    //edit form jabatan
    public function edit_form()
    {
        if($this->mion_auth->is_allowed('edit_jabatan')){
            $Kode=$this->uri->segment(4);
            $DataJabatan = $this->jabatan_model->get_jabatan_by_code($Kode);
            if($DataJabatan->num_rows() > 0)
            {
                $DataLevel=$this->jabatan_model->get_level_all_jabatan($this->kd_perusahaan);
                $Data['ListLevel']=  get_value_array($DataLevel,'kd_level','nm_level',TRUE);

                $Data['DataJabatan']= $DataJabatan;
                $this->load->view('Jabatan_vf/v_Jabatan_edit',$Data);
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
    // edit jabatan
    public function edit()
    {
        $this->template->unset_template();
        $Kode=$this->uri->segment(4);
        $DataJabatan = $this->jabatan_model->get_jabatan_by_code($Kode);
        $Data=["success"=>false,"messages"=>array(),"data"=>array()];
        if($DataJabatan->num_rows() > 0)
        {
            $this->form_validation->set_rules('nm_jabatan', $this->lang->line('nm_jabatan'), 'trim|required');
            $this->form_validation->set_rules('kd_level', $this->lang->line('kd_level'), 'trim|required');
            $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
            
            if ($this->form_validation->run() == FALSE){
                foreach($_POST as $key => $value)
                {
                    $Data['messages'][$key]= form_error($key);
                    //$Data['data']= $DataJabatan->row_array();
                }
            }else{
            
                $Input=['nm_jabatan'=>$this->input->post('nm_jabatan'),
                    'kd_level'=>$this->input->post('kd_level'),
                    'kd_perusahaan'=>$this->kd_perusahaan
                    ];
                    

                $this->jabatan_model->update_jabatan($Kode,$Input);
                $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_edit'));
                //insert user activity
                $this->useractivity->run_acitivity('edit '.$this->lang->line('subheader'),$Kode,$Input,$DataJabatan->row_array());
                $Data["success"]=true;
            }

        }
            echo json_encode($Data);
    }
    //delete jabatan
    public function delete(){
        if($this->mion_auth->is_allowed('delete_jabatan')){
            $DataDelete=$this->uri->segment(4);
            //get history data
            $DataJabatan = $this->jabatan_model->get_jabatan_by_code($DataDelete);
            //delete data
            $this->jabatan_model->delete_jabatan($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataJabatan->row_array());
        }

    }
   
}


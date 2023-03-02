<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('akses/Permission',$siteLang);
            $this->load->model('permission_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/akses/Permission');
    }
    
    //list permission
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
        $this->template->add_section('viewjs', 'akses/Permission_vf/v_Permission_js');
        $this->load->view('Permission_vf/v_Permission',$Data);
    }
    //get list permission json
    public function get_list()
    {
                    $addsql = array();

                    $request = '';
                    $table = '
                            permission LEFT JOIN
                        menu ON permission.kd_menu = menu.kd_menu
                    ';
                    $primaryKey = 'permission.kd_permission';
                    $columns = array(
                            array( 
                                    'NO', 
                                    'dt' => 0 ,
                                    'searchable' => FALSE
                            ),
                            array(
                                    'db' => 'permission.kd_permission',
                                    'dt' => 1,
                            ),
                            array( 
                                    'db' => 'permission.deskripsi', 
                                    'dt' => 2,
                            ),
                            array(
                                    'db' => 'menu.menu',
                                    'dt' => 3,
                            )

                    );

                    $a_condition = array();
                    $a_condition_type = array(); 
                    $a_link = array();
                    $a_src = array();
                    $a_src_change = array();

//                    $a_link['Detail'] = '<span class="dropdown">'
//                                        . '<a href="#" class="#link_class#" data-toggle="dropdown" aria-expanded="true" title="#link_title#"><i class="la la-ellipsis-h"></i></a>'
//                                        . '<div class="dropdown-menu dropdown-menu-right">'
//                                        . '<a class="dropdown-item" href="'.site_url('akses/Permission/edit/').'#action_lock#"><i class="la la-edit"></i> Edit Details</a>'
//                                        . '<a class="dropdown-item" href="'.site_url('akses/Permission/edit/').'#action_lock#"><i class="la la-leaf"></i> Update Status</a>'
//                                        . '<a class="dropdown-item" href="'.site_url('akses/Permission/edit/').'#action_lock#"><i class="la la-print"></i> Generate Report</a>'
//                                        . '</div>'
//                                        . '</span>';
//                    $a_src['Detail'] = 'btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill';
                    
                    $a_link['View'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-file-text"></i></a>';
                    $a_src['View'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupView';
                            
                    if($this->mion_auth->is_allowed('edit_permission')) {
                            $a_link['Edit'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-edit"></i></a>';
                            $a_src['Edit'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupEdit';
                    }
                    if($this->mion_auth->is_allowed('delete_permission')) { 
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
                                    'action_lock'=>'kd_permission'
                            );

                    // manual ordering at the first page load (server side)
                    if( $_GET['order'][0]['column'] == 0)
                    {
                            $_GET['order'][0]['column'] = '3';
                            $_GET['order'][0]['dir'] = 'asc';
                    }

                    //
                    echo json_encode(
                            SSP::simple( $_GET, $table, $primaryKey, $columns)
                    );
    }
    // insert permission view
    public function insert_form()
    {
        if($this->mion_auth->is_allowed('add_permission')) 
        {
            $DataMenu=$this->permission_model->get_menu_all_permission();
            $Data['ListMenu']=  get_value_array($DataMenu,'kd_menu','menu',TRUE);

            $this->load->view('Permission_vf/v_Permission_input',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_access'));
        }
    }
    // insert permission
    public function save()
    {
        $Data=["success"=>false,"messages"=>array()];
        $this->form_validation->set_rules('kd_permission', $this->lang->line('kd_permission'), 'trim|required|alpha_dash|is_unique[permission.kd_permission]');
        $this->form_validation->set_rules('deskripsi', $this->lang->line('deskripsi'), 'trim|required');
        $this->form_validation->set_rules('kd_menu', $this->lang->line('kd_menu'), 'trim|required');
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        if ($this->form_validation->run() == FALSE){
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
            }
        }else{
            $Input=['kd_permission'=>$this->input->post('kd_permission'),
                    'deskripsi'=>$this->input->post('deskripsi'),
                    'kd_menu'=>$this->input->post('kd_menu')
                    ];
            
            $id=$this->permission_model->insert_permission($Input);
            
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
            //insert user activity
            $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$id,$Input);
            $Data["success"]=true;
        }
        
        echo json_encode($Data);
    }
    // view permission view
    public function view_form()
    {
        $Kode=$this->uri->segment(4);
        $DataPermission = $this->permission_model->get_permission_by_code($Kode);
        if($DataPermission->num_rows() > 0)
        {
            $Data['DataPermission']= $DataPermission;
            //insert user activity
            $this->useractivity->run_acitivity('view '.$this->lang->line('subheader'));
            $this->load->view('Permission_vf/v_Permission_view',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_found'));
        }
    }
    //edit form permission
    public function edit_form()
    {
        if($this->mion_auth->is_allowed('edit_permission')) 
        {
            $Kode=$this->uri->segment(4);
            $DataPermission = $this->permission_model->get_permission_by_code($Kode);
            if($DataPermission->num_rows() > 0)
            {
                $DataMenu=$this->permission_model->get_menu_all_permission();
                $Data['ListMenu']=  get_value_array($DataMenu,'kd_menu','menu',TRUE);
                $Data['DataPermission']= $DataPermission;
                $this->load->view('Permission_vf/v_Permission_edit',$Data);
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
    // edit permission
    public function edit()
    {
        $this->template->unset_template();
        $Kode=$this->uri->segment(4);
        $DataPermission = $this->permission_model->get_permission_by_code($Kode);
        $Data=["success"=>false,"messages"=>array(),"data"=>array()];
        if($DataPermission->num_rows() > 0)
        {
            $this->form_validation->set_rules('kd_permission_baru', $this->lang->line('kd_permission'), 'trim|required|callback__CekKode['.$this->input->post('kd_permission').']');
        $this->form_validation->set_rules('deskripsi', $this->lang->line('deskripsi'), 'trim|required');
        $this->form_validation->set_rules('kd_menu', $this->lang->line('kd_menu'), 'trim|required');
            $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
            if ($this->form_validation->run() == FALSE){
                foreach($_POST as $key => $value)
                {
                    $Data['messages'][$key]= form_error($key);
                    $Data['data']= $DataPermission->row_array();
                }
            }else{
                
                $Input=['kd_permission'=>$this->input->post('kd_permission_baru'),
                    'deskripsi'=>$this->input->post('deskripsi'),
                    'kd_menu'=>$this->input->post('kd_menu')
                    ];

                $this->permission_model->update_permission($Kode,$Input);
                $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_edit'));
                //insert user activity
                $this->useractivity->run_acitivity('edit '.$this->lang->line('subheader'),$Kode,$Input,$DataPermission->row_array());
                $Data["success"]=true;
            }

        }
            echo json_encode($Data);
    }
    //cek exist kode permission
    public function _CekKode($Str='',$KodeLama=''){
        $Data=$this->permission_model->get_permission_by_code($Str)->num_rows();
        if($Str==$KodeLama){
            return TRUE;
        }else{
            if($Data>0){
                $this->form_validation->set_message('_CekKode', $this->lang->line('error_kode'));
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    //delete permission
    public function delete(){
        if($this->mion_auth->is_allowed('delete_permission')) 
        {
            $DataDelete=$this->uri->segment(4);
            //get data history
            $DataPermission = $this->permission_model->get_permission_by_code($DataDelete);

            //delete data
            $this->permission_model->delete_permission($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataPermission->row_array());
            //redirect('akses/Permission');
        }

    }
}


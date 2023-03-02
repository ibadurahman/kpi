<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserRole extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('akses/UserRole',$siteLang);
            $this->lang->load('ListMenu',$siteLang);
            $this->load->model('user_role_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/akses/UserRole');
    }
    
    //list user role
    public function index()
    {
        $Data["title_web"]=$this->lang->line('title_web');
        $Data["subheader"]=$this->lang->line('subheader');
        $Data["list_header"]=$this->lang->line('list_header');
        $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
        $Data['AlertInput']=$this->session->flashdata('AlertInput');
        
        $Data["groups"] = $this->mion_auth->groups()->result();
        
        $DataDetailPermission = $this->user_role_model->get_perms_groups_all();
        
        $ListDetail=array();
        foreach($DataDetailPermission->result() as $row)
        {
            $ListDetail[$row->id_groups][$row->kd_permission]['menu']=$this->lang->line('menu_'.$row->kd_menu);
            $ListDetail[$row->id_groups][$row->kd_permission]['deskripsi']=$row->deskripsi_permission;
        }
        
        $Data["ListPermission"]=$ListDetail;
        
        //insert user activity
        $this->useractivity->run_acitivity('index '.$this->lang->line('subheader'));
            
        $this->template->temp_default();
        $this->template->add_section('viewjs', 'akses/UserRole_vf/v_UserRole_js');
        $this->load->view('UserRole_vf/v_UserRole',$Data);
    }
   
    // insert permission view
    public function insert_form()
    {
        if($this->mion_auth->is_allowed('add_user_role')) 
        {
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader');
            $Data["input_header"]=$this->lang->line('input_header');
            $this->breadcrumbs->push($this->lang->line('input_header'), '/akses/UserRole/insert_form');
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['AlertInput']=$this->session->flashdata('AlertInput');

            $Data['ListPermission'] = $this->user_role_model->get_permission();

            $this->template->temp_default();
            $this->template->add_section('viewjs', 'akses/UserRole_vf/v_UserRole_js');
            $this->load->view('UserRole_vf/v_UserRole_input',$Data);
        }
        else
        {
            $Data['text_error']=$this->lang->line('not_access');
            $this->template->temp_default();
            $this->template->add_section('t_alert', 'alert_error',$Data);
        }
    }
    // insert permission
    public function save()
    {
        $Data=["success"=>false,"messages"=>array()];
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|alpha_dash');
        $this->form_validation->set_rules('description', $this->lang->line('description'), 'trim|required');
        //$this->form_validation->set_rules('kd_permission[]', $this->lang->line('list_permission'), 'trim|required');
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        if ($this->form_validation->run() == FALSE or empty($this->input->post('kd_permission'))){
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
                
            }
            if(empty($this->input->post('kd_permission')))
            {
                $Data['messages']['permission']= $this->lang->line('error_permission');
            }
        }else{
            $name=$this->input->post('name');
            $description=$this->input->post('description');
            $group_id = $this->mion_auth->create_group($name, $description);
            
            $kd_permission = $this->input->post('kd_permission');
            $Input=array();
            foreach($kd_permission as $key=>$val)
            {
                $kd_perms_group=$group_id.$val;
                $Input[]=['kd_perms_group'=>$kd_perms_group,
                        'kd_permission'=>$val,
                        'id_groups'=>$group_id
                        ];
            }
            
            $this->user_role_model->insert_perms_groups_batch($Input);
            
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
            //insert user activity
            $Datanput=[
                        'name'          => $name,
                        'description'   => $description,
                        'permission'    => $Input
                        ];
            $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$group_id,$Datanput);
            $Data["success"]=true;
        }
//        var_dump($Data);
//            die();
        echo json_encode($Data);
    }
    //edit form permission
    public function edit_form()
    {
        if($this->mion_auth->is_allowed('edit_user_role')) 
        {
            $Kode=$this->uri->segment(4);
            $Data["groups"] = $this->mion_auth->group($Kode);
            if($Data["groups"]->num_rows() > 0)
            {
                $Data["title_web"]=$this->lang->line('title_web');
                $Data["subheader"]=$this->lang->line('subheader');
                $Data["input_header"]=$this->lang->line('edit_header');
                $this->breadcrumbs->push($this->lang->line('edit_header'), '/akses/UserRole/edit_form/'.$Kode);
                $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
                $Data['AlertInput']=$this->session->flashdata('AlertInput');

                $Data['ListPermission'] = $this->user_role_model->get_permission();

                $DataPermGroup = $this->user_role_model->get_perms_groups_by_id_group($Kode);
                $List=array();
                foreach($DataPermGroup->result() as $row)
                {
                    $List[]=$row->kd_permission;
                }
                $Data['ListPermGroup'] = $List;
                $this->template->temp_default();
                $this->template->add_section('viewjs', 'akses/UserRole_vf/v_UserRole_js');
                $this->load->view('UserRole_vf/v_UserRole_edit',$Data);
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
    // edit permission
    public function edit()
    {
        $Kode=$this->uri->segment(4);
        $DataGroup = $this->mion_auth->group($Kode);
        $Data=["success"=>false,"messages"=>array(),"data"=>array()];
        if($DataGroup->num_rows() > 0)
        {
            $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required|alpha_dash');
            $this->form_validation->set_rules('description', $this->lang->line('description'), 'trim|required');
            //$this->form_validation->set_rules('kd_permission[]', $this->lang->line('list_permission'), 'trim|required');
            $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
            if ($this->form_validation->run() == FALSE or empty($this->input->post('kd_permission'))){
                foreach($_POST as $key => $value)
                {
                    $Data['messages'][$key]= form_error($key);

                }
                if(empty($this->input->post('kd_permission')))
                {
                    $Data['messages']['permission']= $this->lang->line('error_permission');
                }
            }else{
                
                $name=$this->input->post('name');
                $description=$this->input->post('description');
                $additional_data = array(
                    'description' => $description
                );
                $this->mion_auth->update_group($Kode, $name, $additional_data);

                $kd_permission = $this->input->post('kd_permission');
                
                $Input=array();
                foreach($kd_permission as $key=>$val)
                {
                    $kd_perms_group=$Kode.$val;
                    $Input[]=['kd_perms_group'=>$kd_perms_group,
                            'kd_permission'=>$val,
                            'id_groups'=>$Kode
                            ];
                }
                $this->user_role_model->delete_perms_groups_id_groups($Kode);
                $this->user_role_model->insert_perms_groups_batch($Input);
                $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_edit'));
                //insert user activity
                $Datanput=[
                            'name'          => $name,
                            'description'   => $description,
                            'permission'    => $Input
                            ];
                $this->useractivity->run_acitivity('edit '.$this->lang->line('subheader'),$Kode,$Datanput,$DataGroup->row_array());
                $Data["success"]=true;
            }

        }
            echo json_encode($Data);
    }
    //delete permission
    public function delete(){
        if($this->mion_auth->is_allowed('delete_user_role')) 
        {
            $DataDelete=$this->uri->segment(4);
            //get history data
            $DataGroup = $this->mion_auth->group($DataDelete);
            //delete data
            $this->mion_auth->delete_group($DataDelete);
            $this->user_role_model->delete_perms_groups_id_groups($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataGroup->row_array());
        }

    }
}


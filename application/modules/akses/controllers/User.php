<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('akses/User',$siteLang);
            $this->load->model('user_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/akses/User');
//            $this->Upload_Path = realpath(APPPATH."../assets/upload/foto_user");
            $this->Upload_Path = realpath(APPPATH."../assets/upload/foto");
            $this->kd_perusahaan = $this->session->userdata('ses_perusahaan');
    }
    
    //list user
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
        $this->template->add_section('viewjs', 'akses/User_vf/v_User_js');
        $this->load->view('User_vf/v_User',$Data);
    }
    //get list user json
    public function get_list()
    {
                    $addsql = array();

                    $request = '';
                    // $table = '
                    //         users LEFT JOIN pegawai on users.nip = pegawai.nip
                    // ';
                    $table = " 
                                (select users.*
                                    from users 
                                    LEFT JOIN pegawai on users.nip = pegawai.nip
                                    where pegawai.kd_perusahaan = '$this->kd_perusahaan'
                                 )as tbl_user

                        ";
                    $primaryKey = 'tbl_user.id';
                    $columns = array(
                            array( 
                                    'NO', 
                                    'dt' => 0 ,
                                    'searchable' => FALSE
                            ),
                            array(
                                    'db' => 'tbl_user.id',
                                    'dt' => 1,
                            ),
                            array(
                                    'db' => 'tbl_user.username',
                                    'dt' => 2,
                            ),
                            array( 
                                    'db' => 'tbl_user.email', 
                                    'dt' => 3,
                            ),
                            array(
                                    'db' => 'tbl_user.nip',
                                    'dt' => 4,
                            ),
                            array(
                                    'db' => 'tbl_user.first_name',
                                    'dt' => 5,
                            ),
                            array(
                                    'db' => 'tbl_user.company',
                                    'dt' => 6,
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
//                                        . '<a class="dropdown-item" href="'.site_url('akses/User/edit/').'#action_lock#"><i class="la la-edit"></i> Edit Details</a>'
//                                        . '<a class="dropdown-item" href="'.site_url('akses/User/edit/').'#action_lock#"><i class="la la-leaf"></i> Update Status</a>'
//                                        . '<a class="dropdown-item" href="'.site_url('akses/User/edit/').'#action_lock#"><i class="la la-print"></i> Generate Report</a>'
//                                        . '</div>'
//                                        . '</span>';
//                    $a_src['Detail'] = 'btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill';
                    
                    $a_link['View'] = '<a href="'. site_url("akses/User/view_form/").'#action_lock#" class="#link_class#" title="#link_title#" ><i class="la la-file-text"></i></a>';
                    $a_src['View'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupView';
                            
                    if($this->mion_auth->is_allowed('edit_user')) {
                            $a_link['Edit'] = '<a href="'. site_url("akses/User/edit_form/").'#action_lock#" class="#link_class#" title="#link_title#"><i class="la la-edit"></i></a>';
                            $a_src['Edit'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupEdit';
                    }
                    if($this->mion_auth->is_allowed('delete_user')) { 
                            $a_link['Delete'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-trash"></i></a>';
                            $a_src['Delete'] = 'm-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-data';
                    }
                    //add to ajax columns
                    $columns[] = array(
                                    'action',
                                    'searchable' => FALSE,
                                    'dt'=>7,
                                    'condition'=>$a_condition,
                                    'condition_type'=>$a_condition_type,
                                    'action_link'=>$a_link,
                                    'action_src'=>$a_src,
                                    'action_src_change'=>$a_src_change,
                                    'action_lock'=>'id'
                            );

                    // manual ordering at the first page load (server side)
                    if( $_GET['order'][0]['column'] == 0)
                    {
                            $_GET['order'][0]['column'] = '5';
                            $_GET['order'][0]['dir'] = 'asc';
                    }

                    //
                    echo json_encode(
                            SSP::simple( $_GET, $table, $primaryKey, $columns)
                    );
    }
    // insert user view
    public function insert_form()
    {
        if($this->mion_auth->is_allowed('add_user')) 
        {
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader');
            $Data["input_header"]=$this->lang->line('input_header');
            $this->breadcrumbs->push($this->lang->line('input_header'), '/akses/User/insert_form');
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['AlertInput']=$this->session->flashdata('AlertInput');

            $DataPegawai=$this->user_model->get_pegawai_all_user();
            $Data['ListPegawai']=  get_value_array($DataPegawai,'nip','nama',TRUE);

            $DataGroup = $this->mion_auth->groups();
            $Data['ListGroup']=  get_value_array($DataGroup,'id','name',TRUE);

            $this->template->temp_default();
            $this->template->add_section('viewjs', 'akses/User_vf/v_User_js');
            $this->load->view('User_vf/v_User_input',$Data);
            
        }
        else
        {
            $Data['text_error']=$this->lang->line('not_access');
            $this->template->temp_default();
            $this->template->add_section('t_alert', 'alert_error',$Data);
        }
    }
    // insert user
    public function save()
    {
        $Data=["success"=>false,"messages"=>array(),"kode"=>''];
        $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required|alpha_dash|is_unique[users.username]');
        // $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required|is_unique[users.username]');
        $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required');
        $this->form_validation->set_rules('cpassword', $this->lang->line('cpassword'), 'trim|required|matches[password]');
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('first_name', $this->lang->line('first_name'), 'trim|required');
        $this->form_validation->set_rules('group', $this->lang->line('group'), 'trim|required');
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        if ($this->form_validation->run() == FALSE){
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
            }
        }else{
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $email = $this->input->post('email');
            $nip=$this->input->post('nip');
            if (!empty($_FILES['foto']['name'])) {
                $config=array(
                            'allowed_types'   => 'jpg|jpeg|gif|png',
                            'upload_path'   => $this->Upload_Path,
                            'file_name'     => 'foto'.$nip.date("ymd").rand(10, 99),
                                'overwrite' => TRUE,
                            'max_size'      => 2000 // 2mb
                        );
                $this->load->library('upload',$config);
                if ( ! $this->upload->do_upload('foto')){
                    $Data['error'] = $this->upload->display_errors();
                }
                else
                {
                    $upload_data = $this->upload->data();
                }
            }
            if(isset($Data['error']))
            {
                
                if(isset($upload_data)){
                    $Path=$upload_data['full_path'];
                    unlink($Path);
                }
                if(isset($Data['error'])){
                    $Data['messages']['foto']= $Data['error'];
                }
            }
            else
            {
                $Foto='';
                if(isset($upload_data)){
                    $Foto=$upload_data['file_name'];
                    $Input = array(
                                    'foto' => $Foto,
                    );
                    $this->user_model->update_pegawai_user($nip,$Input);
                }
                
                $additional_data = array(
                            'first_name'    => $this->input->post('first_name'),
                            'last_name'     => $this->input->post('last_name'),
                            'company'       => $this->input->post('company'),
                            'nip'           => $this->input->post('nip'),
                            'image'         => $Foto,
                            );
                $group = array($this->input->post('group')); // Sets user to admin.

                $id=$this->mion_auth->register($username, $password, $email, $additional_data, $group);


                $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
                //insert user activity
                $DataInput = [
                            'username' => $username,
                            'email' => $email,
                            'first_name' => $this->input->post('first_name'),
                            'first_name' => $this->input->post('first_name'),
                            'last_name' => $this->input->post('last_name'),
                            'company' => $this->input->post('company'),
                            'nip' => $this->input->post('nip'),
                            ];
                $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$id,$DataInput);
                $Data["success"]=true;
                $Data["kode"]=$id;
            }
        }
        
        echo json_encode($Data);
    }
    // view user view
    public function view_form()
    {
        $Kode=$this->uri->segment(4);
        $DataUser = $this->user_model->get_user_by_code($Kode);
        if($DataUser->num_rows() > 0)
        {
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader');
            $Data["input_header"]=$this->lang->line('view_header');
            $this->breadcrumbs->push($this->lang->line('view_header'), '/akses/User/view_form/'.$Kode);
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['AlertInput']=$this->session->flashdata('AlertInput');
            
            $Data['DataUser']= $DataUser;
            $user_groups = $this->mion_auth->get_users_groups($Kode)->result();
            $Data['DataUserGroup']=$user_groups;
            
            //insert user activity
            $this->useractivity->run_acitivity('view '.$this->lang->line('subheader'),$Kode);
        
            $this->template->temp_default();
            $this->template->add_section('viewjs', 'akses/User_vf/v_User_js');
            $this->load->view('User_vf/v_User_view',$Data);
        }
        else
        {
            $Data['text_error']=$this->lang->line('not_found');
            $this->template->temp_default();
            $this->template->add_section('t_alert', 'alert_error',$Data);
        }
    }
    //edit form user
    public function edit_form()
    {
        if($this->mion_auth->is_allowed('edit_user')) 
        {
            $Kode=$this->uri->segment(4);
            $DataUser = $this->user_model->get_user_by_code($Kode);
            if($DataUser->num_rows() > 0)
            {
                $Data["title_web"]=$this->lang->line('title_web');
                $Data["subheader"]=$this->lang->line('subheader');
                $Data["input_header"]=$this->lang->line('view_header');
                $this->breadcrumbs->push($this->lang->line('view_header'), '/akses/User/edit_form/'.$Kode);
                $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
                $Data['AlertInput']=$this->session->flashdata('AlertInput');

                $DataPegawai=$this->user_model->get_pegawai_all_user();
                $Data['ListPegawai']=  get_value_array($DataPegawai,'nip','nama',TRUE);

                $DataGroup = $this->mion_auth->groups();
                $Data['ListGroup']=  get_value_array($DataGroup,'id','name',TRUE);
                $Data['DataUser']= $DataUser;

                $this->template->temp_default();
                $this->template->add_section('viewjs', 'akses/User_vf/v_User_js');
                $this->load->view('User_vf/v_User_edit',$Data);
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
    // edit user
    public function edit()
    {
        $this->template->unset_template();
        $Kode=$this->uri->segment(4);
        $DataUser = $this->user_model->get_user_by_code($Kode);
        $Data=["success"=>false,"messages"=>array(),"data"=>array(),"kode"=>$Kode];
        if($DataUser->num_rows() > 0)
        {
            
            
            $this->form_validation->set_rules('username', $this->lang->line('username'), 'trim|required|alpha_dash|callback__CekUsername['.$this->input->post('username_lama').']');
            $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required|valid_email|callback__CekEmail['.$this->input->post('email_lama').']');
            $this->form_validation->set_rules('first_name', $this->lang->line('first_name'), 'trim|required');
            $this->form_validation->set_rules('group', $this->lang->line('group'), 'trim|required');
            $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
            if ($this->form_validation->run() == FALSE){
                foreach($_POST as $key => $value)
                {
                    $Data['messages'][$key]= form_error($key);
                    $Data['data']= $DataUser->row_array();
                }
            }else{
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $email = $this->input->post('email');
                $nip=$this->input->post('nip');
                if (!empty($_FILES['foto']['name'])) {
                    $config=array(
                                'allowed_types'   => 'jpg|jpeg|gif|png',
                                'upload_path'   => $this->Upload_Path,
                                'file_name'     => 'foto'.$nip.date("ymd").rand(10, 99),
                                    'overwrite' => TRUE,
                                'max_size'      => 2000 // 2mb
                            );
                    $this->load->library('upload',$config);
                    if ( ! $this->upload->do_upload('foto')){
                        $Data['error'] = $this->upload->display_errors();
                    }
                    else
                    {
                        $upload_data = $this->upload->data();
                    }
                }
                if(isset($Data['error']))
                {
                    
                    if(isset($upload_data)){
                        $Path=$upload_data['full_path'];
                        unlink($Path);
                    }
                    if(isset($Data['error'])){
                        $Data['messages']['foto']= $Data['error'];
                    }
                }
                else
                {
                    $FotoLama=$this->input->post('foto_lama');
                    $Foto='';
                    $Input=array();
                    if(isset($upload_data)){
                        $Foto=$upload_data['file_name'];
                        $path=$this->Upload_Path.'/'.$FotoLama;
                        if($FotoLama!=""){
                            unlink($path);
                        }
                        $Input = array(
                                    'foto' => $Foto,
                        );
                        $this->user_model->update_pegawai_user($nip,$Input);
                    }else{
                        $Foto = $FotoLama;
                    }
                    $group_lama=$this->input->post('group_lama');
                    $group=$this->input->post('group');
                    $Input = array(
                                'username' => $this->input->post('username'),
                                'email' => $this->input->post('email'),
                                'first_name' => $this->input->post('first_name'),
                                'last_name' => $this->input->post('last_name'),
                                'company' => $this->input->post('company'),
                                'nip' => $this->input->post('nip'),
                                'image' => $Foto,
                                );
                    $this->mion_auth->update($Kode, $Input);
                    $this->mion_auth->remove_from_group($group_lama, $Kode);
                    $this->mion_auth->add_to_group($group,$Kode);
                    $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_edit'));
                    //insert user activity
                    $this->useractivity->run_acitivity('edit '.$this->lang->line('subheader'),$Kode,$Input,$DataUser->row_array());
                    $Data["success"]=true;
                }
            }

        }
            echo json_encode($Data);
    }
    //cek exist username
    public function _CekUsername($Str='',$KodeLama=''){
        $Data=$this->user_model->get_user_by_username($Str)->num_rows();
        if($Str==$KodeLama){
            return TRUE;
        }else{
            if($Data>0){
                $this->form_validation->set_message('_CekUsername', $this->lang->line('error_kode'));
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    //cek exist email
    public function _CekEmail($Str='',$KodeLama=''){
        $Data=$this->user_model->get_user_by_email($Str)->num_rows();
        if($Str==$KodeLama){
            return TRUE;
        }else{
            if($Data>0){
                $this->form_validation->set_message('_CekEmail', $this->lang->line('error_kode'));
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }
    //delete user
    public function delete(){
        if($this->mion_auth->is_allowed('delete_user')) 
        {
            $DataDelete=$this->uri->segment(4);
            //get data history
            $DataUser = $this->user_model->get_user_by_code($DataDelete);
            
            //delete data
            $this->mion_auth->delete_user($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));

            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataUser->row_array());
        }

    }
    //delete image
    public function delete_image(){
        if($this->mion_auth->is_allowed('delete_user')) 
        {
            $Kode=$this->uri->segment(4);
            //get data history
            $DataUser = $this->user_model->get_user_by_code($Kode);
            
            //delete image
            $FotoLama=$DataUser->row()->foto;
            $nip=$DataUser->row()->nip;
            $path=$this->Upload_Path.'/'.$FotoLama;
            if($FotoLama!=""){
                unlink($path);
                // update data pegawai foto
                $Input = array(
                                    'foto' => NULL,
                );
                $this->user_model->update_pegawai_user($nip,$Input);
                $Input2 = array(
                                'image' => NULL,
                                );
                    $this->mion_auth->update($Kode, $Input2);
                $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
                //insert user activity
                $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$Kode,array(),$DataUser->row_array());
            }
            

        }

    }
    public  function search_detail_pegawai_ajax(){
        $term=$_GET['term'];
        $query=$this->user_model->get_pegawai_search($term);
        foreach($query->result() as $row){
                $data[] =$row;
            }
            
            die(json_encode($data)); 
    }
    public  function get_detail_pegawai_ajax(){
        $term=$_GET['term'];
        $data=array();
        $query=$this->user_model->get_pegawai_by_code_user($term);
        foreach($query->result() as $row){
                $data[] =$row;
            }
            
            die(json_encode($data)); 
    }
    
    // insert change password
    public function change_password()
    {
        $Kode=$this->uri->segment(4);
        $Data=["success"=>false,"messages"=>array(),"kode"=>$Kode];
        $DataUser = $this->user_model->get_user_by_code($Kode);
        if($DataUser->num_rows() > 0)
        {
            $this->form_validation->set_rules('old_pass', $this->lang->line('old_pass'), 'trim|required');
            $this->form_validation->set_rules('new_pass', $this->lang->line('new_pass'), 'trim|required');
            $this->form_validation->set_rules('cnew_pass', $this->lang->line('cnew_pass'), 'trim|required|matches[new_pass]');
            $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
            if ($this->form_validation->run() == FALSE){
                foreach($_POST as $key => $value)
                {
                    $Data['messages'][$key]= form_error($key);
                }
            }else{
                $Row=$DataUser->row();
                $change = $this->mion_auth->change_password($Row->email, $this->input->post('old_pass'), $this->input->post('new_pass'));

                if ($change)
                {
                        //if the password was successfully changed
                        $this->session->set_flashdata('AlertInput', $this->lang->line('change_sukses'));
                        //insert user activity
                        $this->useractivity->run_acitivity('change password',$Kode);
                        $Data["success"]=true;
                }
                else
                {       
                    $Data['messages']['old_pass']='<div class="form-control-feedback text-error">'.$this->lang->line('old_pass_error').'</div>';
                }

               
            }
        }
        echo json_encode($Data);
    }
    
    // reset password
    public function reset_password()
    {
        $Kode=$this->uri->segment(4);
        $Data=["success"=>false,"messages"=>array(),"kode"=>$Kode];
        $DataUser = $this->user_model->get_user_by_code($Kode);
        if($DataUser->num_rows() > 0)
        {
            $this->form_validation->set_rules('reset_pass', $this->lang->line('reset_pass'), 'trim|required');
            $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
            if ($this->form_validation->run() == FALSE){
                foreach($_POST as $key => $value)
                {
                    $Data['messages'][$key]= form_error($key);
                }
            }else{
                $Row=$DataUser->row();
                $change = $this->mion_auth->reset_password($Row->email, $this->input->post('reset_pass'));

                if ($change)
                {
                        //if the password was successfully changed
                        $this->session->set_flashdata('AlertInput', $this->lang->line('reset_sukses'));
                        //insert user activity
                        $this->useractivity->run_acitivity('reset password',$Kode);
                        $Data["success"]=true;
                }
                else
                {       
                    $Data['messages']['reset_pass']='<div class="form-control-feedback text-error">'.$this->lang->line('old_pass_error').'</div>';
                }

               
            }
        }
        echo json_encode($Data);
    }
    // view user view
    public function activity_form()
    {
        if($this->mion_auth->is_allowed('activity_user')) 
        {
            $Kode=$this->uri->segment(4);
            $DataUser = $this->user_model->get_user_by_code($Kode);
            if($DataUser->num_rows() > 0)
            {
                $Data["title_web"]=$this->lang->line('title_web');
                $Data["subheader"]=$this->lang->line('subheader');
                $Data["activity_header"]=$this->lang->line('activity_header');
                $this->breadcrumbs->push($this->lang->line('view_header'), '/akses/User/view_form/'.$Kode);
                $this->breadcrumbs->push($this->lang->line('activity_header'), '/akses/User/activity_form/'.$Kode);
                $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
                $Data['AlertInput']=$this->session->flashdata('AlertInput');

                $Data['DataUser']= $DataUser;
                $user_groups = $this->mion_auth->get_users_groups($Kode)->result();
                $Data['DataUserGroup']=$user_groups;
                $Data['DataIdUser']= $Kode;

                //insert user activity
                $this->useractivity->run_acitivity('view activity',$Kode);

                $this->template->temp_default();
                $this->template->add_section('viewjs', 'akses/User_vf/v_User_js',$Data);
                $this->load->view('User_vf/v_User_Activity_view',$Data);
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
    // view departemen view
    public function list_acitivity()
    {
        $Kode=$this->uri->segment(4);
        $Start=$this->uri->segment(5);
        $End=$this->uri->segment(6);
        //echo date("Y-m-d H:i:s",1574357355);
        $DataActivity = $this->user_model->get_user_activity_by_code($Kode,$Start,$End);
        if($DataActivity->num_rows() > 0)
        {
            //insert user activity
           // $this->useractivity->run_acitivity('view '.$this->lang->line('subheader'),$Kode);
            $Data['DataActivity']= $DataActivity;
            $this->load->view('User_vf/v_Activity_list',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_found'));
        }
//        1574382555
//        1574355600
    }
}


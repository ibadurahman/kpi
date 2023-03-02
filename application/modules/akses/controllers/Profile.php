<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('akses/Profile',$siteLang);
            $this->load->model('user_model');
            $this->load->model('organisasi/pegawai_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/akses/Profile');
            $this->user_id = $this->session->userdata('user_id');
            $this->Upload_Path = realpath(APPPATH."../assets/upload/foto");
            $this->Upload_Path_user = realpath(APPPATH."../assets/upload/foto_user");
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
        // $Data['AlertInput']=$this->session->flashdata('NamaFotoProfile');
//        echo $this->session->userdata('login_foto');
//        die();
        $Kode=$this->user_id;
        $DataProfile = $this->user_model->get_user_by_code($Kode);
        if($DataProfile->num_rows() > 0)
        {
            $Data['DataIdProfile']= $Kode;
            $Data['DataProfile']= $DataProfile;
            $user_groups = $this->mion_auth->get_users_groups($Kode)->result();
            $Data['DataProfileGroup']=$user_groups;
            $Data['ListKelamin'] = $this->_list_kelamin();
            //insert user activity
            $this->useractivity->run_acitivity('view '.$this->lang->line('subheader'),$Kode);
        
            $this->template->temp_default();
            $this->template->add_section('viewjs', 'akses/Profile_vf/v_Profile_js');
            $this->load->view('Profile_vf/v_Profile',$Data);
            //die();
        }
        else
        {
            $Data['text_error']=$this->lang->line('not_found');
            $this->template->temp_default();
            $this->template->add_section('t_alert', 'alert_error',$Data);
        }
        //insert user activity
        $this->useractivity->run_acitivity('index '.$this->lang->line('subheader'));
        
    }
    //edit form user
    public function edit_form()
    {
//        if($this->mion_auth->is_allowed('edit_user')) 
//        {
            $Kode=$this->uri->segment(4);
            $DataProfile = $this->user_model->get_user_by_code($Kode);
            if($DataProfile->num_rows() > 0)
            {
                $Data["title_web"]=$this->lang->line('title_web');
                $Data["subheader"]=$this->lang->line('subheader');
                $Data["input_header"]=$this->lang->line('view_header');
                $this->breadcrumbs->push($this->lang->line('view_header'), '/akses/Profile/edit_form/'.$Kode);
                $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
                $Data['AlertInput']=$this->session->flashdata('AlertInput');

                $DataPegawai=$this->user_model->get_pegawai_all_user();
                $Data['ListPegawai']=  get_value_array($DataPegawai,'nip','nama',TRUE);
                $Data['ListKelamin'] = $this->_list_kelamin();

                $DataGroup = $this->mion_auth->groups();
                $Data['ListGroup']=  get_value_array($DataGroup,'id','name',TRUE);
                $Data['DataProfile']= $DataProfile;

                $this->template->temp_default();
                $this->template->add_section('viewjs', 'akses/Profile_vf/v_Profile_js');
                $this->load->view('Profile_vf/v_Profile_edit',$Data);
            }
            else
            {
                $Data['text_error']=$this->lang->line('not_found');
                $this->template->temp_default();
                $this->template->add_section('t_alert', 'alert_error',$Data);
            }
//        }
//        else
//        {
//            $Data['text_error']=$this->lang->line('not_access');
//            $this->template->temp_default();
//            $this->template->add_section('t_alert', 'alert_error',$Data);
//        }
    }
    // edit user
    public function edit()
    {
        $this->template->unset_template();
        $Kode=$this->uri->segment(4);
        $DataProfile = $this->user_model->get_user_by_code($Kode);
        $Data=["success"=>false,"messages"=>array(),"data"=>array(),"kode"=>$Kode];
        if($DataProfile->num_rows() > 0)
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
                    $Data['data']= $DataProfile->row_array();
                }
            }else{
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $email = $this->input->post('email');
                $nip = $this->input->post('nip');
                $path=$this->Upload_Path;
//                if($nip!=""){
//                    $path=$this->Upload_Path;
//                }else{
//                    $path=$this->Upload_Path_user;
//                }
                if (!empty($_FILES['foto']['name'])) {
                    $config=array(
                                'allowed_types'   => 'jpg|jpeg|gif|png',
                                'upload_path'   => $path,
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
                    $Input2=array();
                    if(isset($upload_data)){
                        $Foto=$upload_data['file_name'];
                        $path=$path.'/'.$FotoLama;
                        if($FotoLama!=""){
                            unlink($path);
                        }
                        $Input['image']=$Foto;
                        $Input2['foto']=$Foto;
                        $this->session->set_userdata("login_foto",$Foto);
                    }else{
                        $Foto = $FotoLama;
                    }
                    $Input['username']=$this->input->post('username');
                    $Input['email']=$this->input->post('email');
                    $Input['first_name']=$this->input->post('first_name');
                    $Input['last_name']=$this->input->post('last_name');
                    $Input['company']=$this->input->post('company');
                    $Input['nip']=$this->input->post('nip');
                    $this->mion_auth->update($Kode, $Input);
                    if($nip!=""){
                        
                        $Input2['nama']=$this->input->post('first_name');
                        $Input2['dob']=(convert_date($this->input->post('dob'))!="")?convert_date($this->input->post('dob')):NULL;
                        $Input2['jenis_kelamin']=$this->input->post('jenis_kelamin');
                        
                        $this->pegawai_model->update_pegawai($nip,$Input2);
                    }
//                    echo $this->session->userdata('login_foto');
//                    die();
                    $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_edit'));
                    //insert user activity
                    $this->useractivity->run_acitivity('edit '.$this->lang->line('subheader'),$Kode,$Input,$DataProfile->row_array());
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
            $DataProfile = $this->user_model->get_user_by_code($DataDelete);

            //delete data
            $this->mion_auth->delete_user($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));

            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataProfile->row_array());
        }

    }
    public  function search_detail_pegawai_ajax(){
        $nip=$this->input->post('nip');
        $query=$this->user_model->get_pegawai_by_code_user($nip);
        foreach($query->result() as $row){
                $data[] =$row;
            }
            
            die(json_encode($data)); 
    }
    
    // insert change password
    public function change_password()
    {
        $Kode=$this->user_id;
        $Data=["success"=>false,"messages"=>array(),"kode"=>$Kode];
        $DataProfile = $this->user_model->get_user_by_code($Kode);
        if($DataProfile->num_rows() > 0)
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
                $Row=$DataProfile->row();
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
    
    // view user view
    public function activity_form()
    {
//        if($this->mion_auth->is_allowed('activity_user')) 
//        {
            $Kode=$this->user_id;
            $DataProfile = $this->user_model->get_user_by_code($Kode);
            if($DataProfile->num_rows() > 0)
            {
                $Data["title_web"]=$this->lang->line('title_web');
                $Data["subheader"]=$this->lang->line('subheader');
                $Data["activity_header"]=$this->lang->line('activity_header');
                $this->breadcrumbs->push($this->lang->line('view_header'), '/akses/Profile/view_form/'.$Kode);
                $this->breadcrumbs->push($this->lang->line('activity_header'), '/akses/Profile/activity_form/'.$Kode);
                $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
                $Data['AlertInput']=$this->session->flashdata('AlertInput');

                $Data['DataProfile']= $DataProfile;
                $user_groups = $this->mion_auth->get_users_groups($Kode)->result();
                $Data['DataProfileGroup']=$user_groups;
                $Data['DataIdProfile']= $Kode;

                //insert user activity
                $this->useractivity->run_acitivity('view activity',$Kode);

                $this->template->temp_default();
                $this->template->add_section('viewjs', 'akses/Profile_vf/v_Profile_js',$Data);
                $this->load->view('Profile_vf/v_Profile_Activity_view',$Data);
            }
            else
            {
                $Data['text_error']=$this->lang->line('not_found');
                $this->template->temp_default();
                $this->template->add_section('t_alert', 'alert_error',$Data);
            }
//        }
//        else
//        {
//            $Data['text_error']=$this->lang->line('not_access');
//            $this->template->temp_default();
//            $this->template->add_section('t_alert', 'alert_error',$Data);
//        }
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
            $this->load->view('Profile_vf/v_Profile_Activity_list',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_found'));
        }
//        1574382555
//        1574355600
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
}


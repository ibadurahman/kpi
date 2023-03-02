<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perusahaan extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('organisasi/Perusahaan',$siteLang);
            $this->load->model('perusahaan_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/organisasi/Perusahaan');
            $this->kd_perusahaan = $this->session->userdata('ses_perusahaan');
        $this->Upload_Path = realpath(APPPATH."../assets/upload/logo");
    }
    
    //list perusahaan
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
        $this->template->add_section('viewjs', 'organisasi/Perusahaan_vf/v_Perusahaan_js');
        $this->load->view('Perusahaan_vf/v_Perusahaan',$Data);
    }
    //get list perusahaan json
    public function get_list()
    {
                    $addsql = array();

                    $request = '';
                    $table = '
                            perusahaan
                    ';
                    $custom_whare="";
                    if (!$this->mion_auth->is_admin()){
                        $custom_whare="perusahaan.kd_perusahaan ='$this->kd_perusahaan'";
                    }
                    $primaryKey = 'perusahaan.kd_perusahaan';
                    $columns = array(
                            array( 
                                    'NO', 
                                    'dt' => 0 ,
                                    'searchable' => FALSE
                            ),
                            array(
                                    'db' => 'perusahaan.kd_perusahaan',
                                    'dt' => 1,
                            ),
                            array( 
                                    'db' => 'perusahaan.nm_perusahaan', 
                                    'dt' => 2,
                            ),
                            array(
                                    'db' => 'perusahaan.alamat',
                                    'dt' => 3,
                            ),
                            array(
                                    'db' => 'perusahaan.telepon',
                                    'dt' => 4,
                            ),
                            array(
                                    'db' => 'perusahaan.fax',
                                    'dt' => 5,
                            )

                    );

                    $a_condition = array();
                    $a_condition_type = array(); 
                    $a_link = array();
                    $a_src = array();
                    $a_src_change = array();

                    $a_link['Detail'] = '<span class="dropdown">'
                                        . '<a href="#" class="#link_class#" data-toggle="dropdown" aria-expanded="true" title="#link_title#"><i class="la la-ellipsis-h"></i></a>'
                                        . '<div class="dropdown-menu dropdown-menu-right">';
                    $a_link['Detail'] .= '<a class="dropdown-item openPopupView" href="#" data-id="#action_lock#"><i class="la la-file-text"></i> View Details</a>';
                    if($this->mion_auth->is_allowed('edit_company')){
                        $a_link['Detail'] .= '<a class="dropdown-item openPopupEdit" href="#" data-id="#action_lock#"><i class="la la-edit"></i> Edit Details</a>';
                    }
                    if($this->mion_auth->is_allowed('delete_company')){
                        $a_link['Detail'] .= '<a class="dropdown-item delete-data" href="#" data-id="#action_lock#"><i class="la la-trash"></i> Delete</a>';
                    }
                    $a_link['Detail'] .= '</div>'
                                        . '</span>';
                    $a_src['Detail'] = 'btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill';
                    
                    $a_link['Select'] = '<a href="'. site_url("organisasi/Perusahaan/turn_on/").'#action_lock#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-power-off "></i></a>';
                    $a_src['Select'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill';
                            
                    //if($this->aauth->is_allowed('pembelian_edit')) {
//                            $a_link['Edit'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-edit"></i></a>';
//                            $a_src['Edit'] = 'm-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill openPopupEdit';
                   // }
                    //if($this->aauth->is_allowed('pembelian_delete')) { 
//                            $a_link['Delete'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-trash"></i></a>';
//                            $a_src['Delete'] = 'm-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill delete-data';
                    //}
                    //add to ajax columns
                    $columns[] = array(
                                    'action',
                                    'searchable' => FALSE,
                                    'dt'=>6,
                                    'condition'=>$a_condition,
                                    'condition_type'=>$a_condition_type,
                                    'action_link'=>$a_link,
                                    'action_src'=>$a_src,
                                    'action_src_change'=>$a_src_change,
                                    'action_lock'=>'kd_perusahaan'
                            );

                    // manual ordering at the first page load (server side)
                    if( $_GET['order'][0]['column'] == 0)
                    {
                            $_GET['order'][0]['column'] = '2';
                            $_GET['order'][0]['dir'] = 'asc';
                    }

                    //
                    echo json_encode(
                            SSP::simple( $_GET, $table, $primaryKey, $columns,$custom_whare)
                    );
    }
    // insert perusahaan view
    public function insert_form()
    {   
        if($this->mion_auth->is_allowed('add_company')){
            $Data=array();

            $this->load->view('Perusahaan_vf/v_Perusahaan_input',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_access'));
        }
    }
    // insert perusahaan
    public function save()
    {
        $Data=["success"=>false,"messages"=>array()];
        $this->form_validation->set_rules('nm_perusahaan', $this->lang->line('nm_perusahaan'), 'trim|required');
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        if (!empty($_FILES['logo']['name'])) {
//            if($this->input->post('KodeReward')){
//                $KodeReward=$this->input->post('KodeReward');
//            }
//            echo $this->Upload_Path;
//            die();
            $config=array(
                        'allowed_types'   => 'jpg|jpeg|gif|png',
                        'upload_path'   => $this->Upload_Path,
                        'file_name'     => 'Logo'.date("ymd").rand(10, 99),
                            'overwrite' => TRUE,
                        'max_size'      => 2000 // 2mb
                    );
            $this->load->library('upload',$config);
            if ( ! $this->upload->do_upload('logo')){
                $Data['error'] = $this->upload->display_errors();
            }
            else
            {
                $upload_data = $this->upload->data();
            }
        }
        if ($this->form_validation->run() == FALSE or isset($Data['error'])){
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
            }
//            echo $upload_data['full_path'];
//            die();
            if(isset($upload_data)){
                $Path=$upload_data['full_path'];
                unlink($Path);
            }
            if(isset($Data['error'])){
                $Data['messages']['logo']= $Data['error'];
            }
        }else{
            $Logo='';
            if(isset($upload_data)){
                $Logo=$upload_data['file_name'];
            }
            $Input=['nm_perusahaan'=>$this->input->post('nm_perusahaan'),
                    'alamat'=>$this->input->post('alamat'),
                    'telepon'=>$this->input->post('telepon'),
                    'fax'=>$this->input->post('fax'),
                    'logo'=>$Logo
                    ];
            
            $id=$this->perusahaan_model->insert_perusahaan($Input);
            
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
            //insert user activity
            $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$id,$Input);
            $Data["success"]=true;
        }
        
        echo json_encode($Data);
    }
    // view perusahaan view
    public function view_form()
    {
        if($this->mion_auth->is_allowed('view_company')){
            $Kode=$this->uri->segment(4);
            $DataPerusahaan = $this->perusahaan_model->get_perusahaan_by_code($Kode);
            if($DataPerusahaan->num_rows() > 0)
            {
                $Data['DataPerusahaan']= $DataPerusahaan;
                //insert user activity
                $this->useractivity->run_acitivity('view '.$this->lang->line('subheader'),$Kode);
                $this->load->view('Perusahaan_vf/v_Perusahaan_view',$Data);
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
    //edit form perusahaan
    public function edit_form()
    {
        if($this->mion_auth->is_allowed('edit_company')){
            $Kode=$this->uri->segment(4);
            $DataPerusahaan = $this->perusahaan_model->get_perusahaan_by_code($Kode);
            if($DataPerusahaan->num_rows() > 0)
            {
                $Data['DataPerusahaan']= $DataPerusahaan;
                $this->load->view('Perusahaan_vf/v_Perusahaan_edit',$Data);
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
    // edit perusahaan
    public function edit()
    {
        $this->template->unset_template();
        $Kode=$this->uri->segment(4);
        $DataPerusahaan = $this->perusahaan_model->get_perusahaan_by_code($Kode);
        $Data=["success"=>false,"messages"=>array(),"data"=>array()];
        if($DataPerusahaan->num_rows() > 0)
        {
            $this->form_validation->set_rules('nm_perusahaan', $this->lang->line('nm_perusahaan'), 'trim|required');
            $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
            if (!empty($_FILES['logo']['name'])) {
                $config=array(
                            'allowed_types'   => 'jpg|jpeg|gif|png',
                            'upload_path'   => $this->Upload_Path,
                            'file_name'     => 'Logo'.date("ymd").rand(10, 99),
                                'overwrite' => TRUE,
                            'max_size'      => 2000 // 2mb
                        );
                $this->load->library('upload',$config);
                if ( ! $this->upload->do_upload('logo')){
                    $Data['error'] = $this->upload->display_errors();
                }
                else
                {
                    $upload_data = $this->upload->data();
                }
            }
            if ($this->form_validation->run() == FALSE){
                foreach($_POST as $key => $value)
                {
                    $Data['messages'][$key]= form_error($key);
                    //$Data['data']= $DataPerusahaan->row_array();
                }
                if(isset($upload_data)){
                    $Path=$upload_data['full_path'];
                    unlink($Path);
                }
                if(isset($Data['error'])){
                    $Data['messages']['logo']= $Data['error'];
                }
            }else{
                $LogoLama=$this->input->post('logo_lama');
                $Logo='';
                $Input=array();
                if(isset($upload_data)){
                    $Logo=$upload_data['file_name'];
                    $path=$this->Upload_Path.'/'.$LogoLama;
                    unlink($path);
                    $Input['logo']=$Logo;
                }
                $Input['nm_perusahaan']=$this->input->post('nm_perusahaan');
                $Input['alamat']=$this->input->post('alamat');
                $Input['telepon']=$this->input->post('telepon');
                $Input['fax']=$this->input->post('fax');
                    

                $this->perusahaan_model->update_perusahaan($Kode,$Input);
                $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_edit'));
                //insert user activity
                $this->useractivity->run_acitivity('edit '.$this->lang->line('subheader'),$Kode,$Input,$DataPerusahaan->row_array());
                $Data["success"]=true;
            }

        }
            echo json_encode($Data);
    }
    //cek exist kode perusahaan
    public function _CekKode($Str='',$KodeLama=''){
        $Data=$this->perusahaan_model->get_perusahaan_by_code($Str)->num_rows();
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
    //delete perusahaan
    public function delete(){
        if($this->mion_auth->is_allowed('delete_company')){
            $DataDelete=$this->uri->segment(4);
            //get history data
            $DataPerusahaan = $this->perusahaan_model->get_perusahaan_by_code($DataDelete);
            //delete data
            $this->perusahaan_model->delete_perusahaan($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataPerusahaan->row_array());
        }

    }
    
    //set perusahaan aktif di aplikasi
    public function turn_on()
    {
        $DataDelete=$this->uri->segment(4);
        $this->mion_auth->set_cookies_perusahaan($DataDelete);
        redirect('dashboard/Home');
    }
}


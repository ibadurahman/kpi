<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('organisasi/Pegawai',$siteLang);
            $this->load->model('pegawai_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/organisasi/Pegawai');
            $this->kd_perusahaan = $this->session->userdata('ses_perusahaan');
            $this->Upload_Path = realpath(APPPATH."../assets/upload/foto");
    }
    
    //list pegawai
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
        $this->template->add_section('viewjs', 'organisasi/Pegawai_vf/v_Pegawai_js');
        $this->load->view('Pegawai_vf/v_Pegawai',$Data);
    }
    //get list pegawai json
    public function get_list()
    {
                    $addsql = array();
                    $request = '';
                    if($this->mion_auth->is_admin()){
                        $table = " 
                                (select pegawai.*,
                                                                            departemen.nm_departemen,
                                                                            jabatan.nm_jabatan,
                                                                            pg.nama as nm_report_to
                                                            from pegawai 
                                            LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen 
                                            LEFT JOIN jabatan ON pegawai.kd_jabatan = jabatan.kd_jabatan 
                                            LEFT JOIN pegawai pg ON pg.nip=pegawai.report_to
                                            where pegawai.kd_perusahaan = '$this->kd_perusahaan'
                                 )as tbl_pegawai

                        ";
                    }
                    else if ($this->mion_auth->in_group(['Manager','Direktur'])){
                        // echo "masuk";die;
                        $table = " 
                                (select @pv:=concat(@pv,',',tabel.nip) as kode,tabel.* 
                                    from ( select pegawai.*,
                                                                            departemen.nm_departemen,
                                                                            jabatan.nm_jabatan,
                                                                            pg.nama as nm_report_to
                                                            from pegawai 
                                            LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen 
                                            LEFT JOIN jabatan ON pegawai.kd_jabatan = jabatan.kd_jabatan 
                                            LEFT JOIN pegawai pg ON pg.nip=pegawai.report_to
                                            where pegawai.kd_perusahaan = '$this->kd_perusahaan'
                                            order by pegawai.nip asc) as tabel
                                    join
                                    (select @pv:=(select GROUP_CONCAT(nip) from pegawai where nip in ('".$this->session->userdata('login_nip')."')))tmp
                                    where FIND_IN_SET(tabel.report_to, @pv)
                                )as tbl_pegawai

                        ";
                    }else{
                        // $table = " 
                        //         (select @pv:=concat(@pv,',',tabel.nip) as kode,tabel.* 
                        //             from ( select pegawai.*,
                        //                                                     departemen.nm_departemen,
                        //                                                     jabatan.nm_jabatan,
                        //                                                     pg.nama as nm_report_to
                        //                                     from pegawai 
                        //                     LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen 
                        //                     LEFT JOIN jabatan ON pegawai.kd_jabatan = jabatan.kd_jabatan 
                        //                     LEFT JOIN pegawai pg ON pg.nip=pegawai.report_to
                        //                     where pegawai.kd_perusahaan = '$this->kd_perusahaan'
                        //                     order by pegawai.nip asc) as tabel
                        //             join
                        //             (select @pv:=(select GROUP_CONCAT(nip) from pegawai where nip in ('".$this->session->userdata('login_nip')."')))tmp
                        //             where FIND_IN_SET(tabel.report_to, @pv)
                        //         )as tbl_pegawai

                        // ";
                        $table = " 
                                    (select pegawai.*,
                                    departemen.nm_departemen,
                                    jabatan.nm_jabatan,
                                    pg.nama as nm_report_to
                                    from pegawai 
                                    LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen 
                                    LEFT JOIN jabatan ON pegawai.kd_jabatan = jabatan.kd_jabatan 
                                    LEFT JOIN pegawai pg ON pg.nip=pegawai.report_to
                                    where pegawai.kd_perusahaan = '$this->kd_perusahaan' and pegawai.report_to = '".$this->session->userdata('login_nip')."'
                                    )as tbl_pegawai

                        ";
                    }
                    $primaryKey = 'tbl_pegawai.nip';
                    $columns = array(
                            array( 
                                    'NO', 
                                    'dt' => 0 ,
                                    'searchable' => FALSE
                            ),
                            array(
                                    'db' => 'tbl_pegawai.nip',
                                    'dt' => 1,
                            ),
                            array( 
                                    'db' => 'tbl_pegawai.nama', 
                                    'dt' => 2,
                                    'formatter' => function( $d, $row ) {
                                                return ucwords(strtolower($d));
                                                
                                            }
                            ),
                            array( 
                                    'db' => 'tbl_pegawai.nm_departemen', 
                                    'dt' => 3,
                            ),
                            array( 
                                    'db' => 'tbl_pegawai.nm_jabatan', 
                                    'dt' => 4,
                            ),
                            array( 
                                    'db' => 'tbl_pegawai.nm_report_to', 
                                    'dt' => 5,
                                    'default_value'=>'',
                                    'formatter' => function( $d, $row ) {
                                                return ucwords(strtolower($d));
                                                
                                            }
                            ),
                            array( 
                                    'db' => 'tbl_pegawai.tgl_masuk', 
                                    'dt' => 6,
                                    'formatter' => function( $d, $row ) {
                                                return convert_date($d);
                                            }
                            ),
                            array( 
                                    'db' => 'tbl_pegawai.status', 
                                    'dt' => 7,
                            )

                    );

                    $a_condition = array();
                    $a_condition_type = array(); 
                    $a_link = array();
                    $a_src = array();
                    $a_src_change = array();

                    
                            $a_link['View'] = '<a href="'. site_url('organisasi/Pegawai/view_form/').'#action_lock#" class="#link_class#" title="#link_title#"><i class="la la-file-text"></i></a>';
                            $a_src['View'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupView';
                            
                    if($this->mion_auth->is_allowed('edit_pegawai')) {
                            $a_link['Edit'] = '<a href="'. site_url('organisasi/Pegawai/edit_form/').'#action_lock#" class="#link_class#" title="#link_title#"><i class="la la-edit"></i></a>';
                            $a_src['Edit'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupEdit';
                    }
                    if($this->mion_auth->is_allowed('delete_pegawai')) { 
                            $a_link['Delete'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-trash"></i></a>';
                            $a_src['Delete'] = 'm-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-data';
                    }
                    //add to ajax columns
                    $columns[] = array(
                                    'action',
                                    'searchable' => FALSE,
                                    'dt'=>8,
                                    'condition'=>$a_condition,
                                    'condition_type'=>$a_condition_type,
                                    'action_link'=>$a_link,
                                    'action_src'=>$a_src,
                                    'action_src_change'=>$a_src_change,
                                    'action_lock'=>'nip'
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
    // insert pegawai view
    public function insert_form()
    {   
        if($this->mion_auth->is_allowed('add_pegawai')){
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader');
            $Data["input_header"]=$this->lang->line('input_header');
            $this->breadcrumbs->push($this->lang->line('input_header'), '/organisasi/Pegawai/insert_form');
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['AlertInput']=$this->session->flashdata('AlertInput');

            $DataPerusahaan=$this->pegawai_model->get_perusahaan_all_pegawai($this->kd_perusahaan);
            $Data['ListPerusahaan']=  get_value_array($DataPerusahaan,'kd_perusahaan','nm_perusahaan',TRUE);

            $DataDepartemen=$this->pegawai_model->get_departemen_all_pegawai($this->kd_perusahaan);
            $Data['ListDepartemen']=  get_value_array($DataDepartemen,'kd_departemen','nm_departemen',TRUE);

            $DataJabatan=$this->pegawai_model->get_jabatan_all_pegawai($this->kd_perusahaan);
            $Data['ListJabatan']=  get_value_array($DataJabatan,'kd_jabatan','nm_jabatan',TRUE);

            $DataPegawai=$this->pegawai_model->get_pegawai_all($this->kd_perusahaan);
            $Data['ListPegawai']=  get_value_array($DataPegawai,'nip','nama',TRUE);

            $Data['ListKelamin'] = $this->_list_kelamin();

            $this->template->temp_default();
            $this->template->add_section('viewjs', 'organisasi/Pegawai_vf/v_Pegawai_js');
            $this->load->view('Pegawai_vf/v_Pegawai_input',$Data);
        }
        else
        {
            $Data['text_error']=$this->lang->line('not_access');
            $this->template->temp_default();
            $this->template->add_section('t_alert', 'alert_error',$Data);
        }
    }
    // insert pegawai
    public function save()
    {
        $Data=["success"=>false,"messages"=>array()];
        $this->form_validation->set_rules('nip', $this->lang->line('nip'), 'trim|required|alpha_dash|is_unique[pegawai.nip]');
        $this->form_validation->set_rules('nama', $this->lang->line('nama'), 'trim|required');
        $this->form_validation->set_rules('tgl_masuk', $this->lang->line('tgl_masuk'), 'trim|required');
        $this->form_validation->set_rules('dob', $this->lang->line('dob'), 'trim|required');
        $this->form_validation->set_rules('kd_departemen', $this->lang->line('kd_departemen'), 'trim|required');
        $this->form_validation->set_rules('kd_jabatan', $this->lang->line('kd_jabatan'), 'trim|required');
        $this->form_validation->set_rules('jenis_kelamin', $this->lang->line('jenis_kelamin'), 'trim|required');
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        
        if ($this->form_validation->run() == FALSE ){
//                echo form_error('jenis_kelamin');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
            }
            if(!isset($Data['messages']['jenis_kelamin']) and form_error('jenis_kelamin')!="")
            {
                $Data['messages']['jenis_kelamin']= form_error('jenis_kelamin');
            }
        }else{
                //echo "masuk";
            if (!empty($_FILES['foto']['name'])) {
                $config=array(
                            'allowed_types'   => 'jpg|jpeg|gif|png',
                            'upload_path'   => $this->Upload_Path,
                            'file_name'     => 'foto'.$this->input->post('nip').date("ymd").rand(10, 99),
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
                }
                $report_to=$this->input->post('report_to')!=""?$this->input->post('report_to'):NULL;
                $Input=['nip'=>$this->input->post('nip'),
                        'nama'=>$this->input->post('nama'),
                        'tgl_masuk'=>(convert_date($this->input->post('tgl_masuk'))!="")?convert_date($this->input->post('tgl_masuk')):NULL,
                        'tgl_keluar'=>(convert_date($this->input->post('tgl_keluar'))!="")?convert_date($this->input->post('tgl_keluar')):NULL,
                        'dob'=>(convert_date($this->input->post('dob'))!="")?convert_date($this->input->post('dob')):NULL,
                        'kd_departemen'=>$this->input->post('kd_departemen'),
                        'kd_jabatan'=>$this->input->post('kd_jabatan'),
                        'report_to'=>$report_to,
                        'jenis_kelamin'=>$this->input->post('jenis_kelamin'),
                        'foto'=>$Foto,
                        'kd_perusahaan'=>$this->kd_perusahaan
                        ];

                $id=$this->pegawai_model->insert_pegawai($Input);

                $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
                //insert user activity
                $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$this->input->post('nip'),$Input);
                $Data["success"]=true;
                $Data["status"]='input';
                $Data["nip"]=$this->input->post('nip');
            }
            
        }
        
        echo json_encode($Data);
    }
    // view pegawai view
    public function view_form()
    {
        $Bln=$this->uri->segment(6);
        $Thn=$this->uri->segment(5);
        $Kode=$this->uri->segment(4);
        if($Thn=="" and $Bln==""){
            $Bln=date("m");
        }
        $DataPegawai = $this->pegawai_model->get_pegawai_by_code($Kode);
        if($DataPegawai->num_rows() > 0)
        {
            $Data['DataBulan'] = ($Bln=="")?$Bln= '':$Bln;
            $Data['DataTahun'] = ($Thn=="")?$Thn=date("Y"):$Thn;
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader');
            $Data["input_header"]=$this->lang->line('view_header');
            $Data["result_header"]=$this->lang->line('result');
            $this->breadcrumbs->push($this->lang->line('view_header'), '/organisasi/Pegawai/view_form/'.$Kode);
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['AlertInput']=$this->session->flashdata('AlertInput');
            $Data['data_uri']= "organisasi/Pegawai/view_form/".$Kode;
            $Data['DataKpiPegawai'] = $this->pegawai_model->get_pegawai_kpi_by_nip($Kode,$Thn);
            $Data['HistoryKPI']=$this->pegawai_model->get_pegawai_kpi_header_by_nip($Kode,$Thn);
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
        
            $Data['DataPegawai']= $DataPegawai;
            $Data['ListKelamin'] = $this->_list_kelamin();
            $Data['ListStatus'] = $this->_list_status();
            
            
            
            if($Bln!=""){
                $DataResult=$this->pegawai_model->get_appraisal_nip_monthly($Kode,$Data['DataBulan'],$Data['DataTahun']);
                $Data['HistoryPegawai']=$this->pegawai_model->get_appraisal_history_nip($Kode,$Data['DataBulan'],$Data['DataTahun']);
                $Data['ChartPegawai']=$this->pegawai_model->get_appraisal_chart_monthly_nip($Kode,$Data['DataBulan'],$Data['DataTahun']);
            }else{
                $DataResult=$this->pegawai_model->get_appraisal_nip_yearly($Kode,$Data['DataTahun']);
                $Data['HistoryPegawai']=$this->pegawai_model->get_appraisal_history_nip_yearly($Kode,$Data['DataTahun']);
                $Data['ChartPegawai']=$this->pegawai_model->get_appraisal_chart_yearly_nip($Kode,$Data['DataTahun']);
            }
            
            $Data['GaugePegawai']=0;
            if($DataResult->num_rows()>0){
            $Data['GaugePegawai']=number_format($DataResult->row()->point,2);
            }
             //insert user activity
            $this->useractivity->run_acitivity('view '.$this->lang->line('subheader'),$Kode);
                    
            $this->template->temp_default();
            $this->template->add_section('viewjs', 'organisasi/Pegawai_vf/v_Pegawai_kpi_view_js',$Data);
            $this->template->add_section('w_subheader', 'organisasi/Pegawai_vf/v_Pegawai_widget_subheader',$Data);
            $this->load->view('Pegawai_vf/v_Pegawai_view',$Data);
        }
        else
        {
            $Data['text_error']=$this->lang->line('not_found');
            $this->template->temp_default();
            $this->template->add_section('t_alert', 'alert_error',$Data);
        }
    }
    //edit form pegawai
    public function edit_form()
    {
        if($this->mion_auth->is_allowed('edit_pegawai')){
            $Kode=$this->uri->segment(4);
            $DataPegawai = $this->pegawai_model->get_pegawai_by_code($Kode);
            if($DataPegawai->num_rows() > 0)
            {
                $Data["title_web"]=$this->lang->line('title_web');
                $Data["subheader"]=$this->lang->line('subheader');
                $Data["input_header"]=$this->lang->line('edit_header');
                $this->breadcrumbs->push($this->lang->line('edit_header'), '/organisasi/Pegawai/edit_form/'.$Kode);
                $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
                $Data['AlertInput']=$this->session->flashdata('AlertInput');

                $DataPerusahaan=$this->pegawai_model->get_perusahaan_all_pegawai($this->kd_perusahaan);
                $Data['ListPerusahaan']=  get_value_array($DataPerusahaan,'kd_perusahaan','nm_perusahaan',TRUE);

                $DataDepartemen=$this->pegawai_model->get_departemen_all_pegawai($this->kd_perusahaan);
                $Data['ListDepartemen']=  get_value_array($DataDepartemen,'kd_departemen','nm_departemen',TRUE);

                $DataJabatan=$this->pegawai_model->get_jabatan_all_pegawai($this->kd_perusahaan);
                $Data['ListJabatan']=  get_value_array($DataJabatan,'kd_jabatan','nm_jabatan',TRUE);

                $DataListPegawai=$this->pegawai_model->get_pegawai_all($this->kd_perusahaan);
                $Data['ListPegawai']=  get_value_array($DataListPegawai,'nip','nama',TRUE);

                $Data['ListKelamin'] = $this->_list_kelamin();
                $Data['ListStatus'] = $this->_list_status();

                $Data['DataPegawai']= $DataPegawai;

                $this->template->temp_default();
                $this->template->add_section('viewjs', 'organisasi/Pegawai_vf/v_Pegawai_js');
                $this->load->view('Pegawai_vf/v_Pegawai_edit',$Data);
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
    // edit pegawai
    public function edit()
    {
        $this->template->unset_template();
        $Kode=$this->uri->segment(4);
        $DataPegawai = $this->pegawai_model->get_pegawai_by_code($Kode);
        $Data=["success"=>false,"messages"=>array(),"data"=>array()];
        if($DataPegawai->num_rows() > 0)
        {
            $this->form_validation->set_rules('nip_baru', $this->lang->line('nip'), 'trim|required|alpha_dash|callback__CekKode['.$this->input->post('nip').']');
            $this->form_validation->set_rules('nama', $this->lang->line('nama'), 'trim|required');
            $this->form_validation->set_rules('tgl_masuk', $this->lang->line('tgl_masuk'), 'trim|required');
            $this->form_validation->set_rules('dob', $this->lang->line('dob'), 'trim|required');
            $this->form_validation->set_rules('kd_departemen', $this->lang->line('kd_departemen'), 'trim|required');
            $this->form_validation->set_rules('kd_jabatan', $this->lang->line('kd_jabatan'), 'trim|required');
            $this->form_validation->set_rules('jenis_kelamin', $this->lang->line('jenis_kelamin'), 'trim|required');
            $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
            
            
        
            if ($this->form_validation->run() == FALSE ){
                foreach($_POST as $key => $value)
                {
                    $Data['messages'][$key]= form_error($key);
                    //$Data['data']= $DataPegawai->row_array();
                }
            }else{
                if (!empty($_FILES['foto']['name'])) {
                    $config=array(
                                'allowed_types'   => 'jpg|jpeg|gif|png',
                                'upload_path'   => $this->Upload_Path,
                                'file_name'     => 'foto'.$this->input->post('nip').date("ymd").rand(10, 99),
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
                        unlink($path);
                        $Input['foto']=$Foto;
                    }
                    $Input['nip']=$this->input->post('nip_baru');
                    $Input['nama']=$this->input->post('nama');
                    $Input['tgl_masuk']=(convert_date($this->input->post('tgl_masuk'))!="")?convert_date($this->input->post('tgl_masuk')):NULL;
                    $Input['tgl_keluar']=(convert_date($this->input->post('tgl_keluar'))!="")?convert_date($this->input->post('tgl_keluar')):NULL;
                    $Input['dob']=(convert_date($this->input->post('dob'))!="")?convert_date($this->input->post('dob')):NULL;
                    $Input['kd_departemen']=$this->input->post('kd_departemen');
                    $Input['kd_jabatan']=$this->input->post('kd_jabatan');
                    $Input['kd_perusahaan']=$this->kd_perusahaan;
                    $Input['report_to']=$this->input->post('report_to');
                    $Input['status']=$this->input->post('status');
                    $Input['jenis_kelamin']=$this->input->post('jenis_kelamin');


                    $this->pegawai_model->update_pegawai($Kode,$Input);
                    $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_edit'));
                    //insert user activity
                    $this->useractivity->run_acitivity('edit '.$this->lang->line('subheader'),$Kode,$Input,$DataPegawai->row_array());
                    $Data["success"]=true;
                    $Data["status"]='edit';
                    $Data["nip"]=$this->input->post('nip_baru');
                }
                
            }

        }
            echo json_encode($Data);
    }
    //cek exist kode permission
    public function _CekKode($Str='',$KodeLama=''){
        $Data=$this->pegawai_model->get_pegawai_by_code($Str)->num_rows();
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
    //delete pegawai
    public function delete(){
        if($this->mion_auth->is_allowed('delete_pegawai')){
            $DataDelete=$this->uri->segment(4);
            //get history data
            $DataPegawai = $this->pegawai_model->get_pegawai_by_code($DataDelete);
            $this->pegawai_model->delete_pegawai($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataPegawai->row_array());
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
    
    // insert departemen_kpi view
    public function kpi_insert_form()
    {   
        if($this->mion_auth->is_allowed('add_pegawai_kpi')){
//            echo "tes";
//            die();
            $nip=$this->uri->segment(4);
            $tahun=$this->uri->segment(5);
            $Bln=$this->uri->segment(6);
            $tahun=($tahun=="")?date("Y"):$tahun;
            $Data['DataBulan'] = ($Bln=="")?$Bln= '':$Bln;
            $Data['DataTahun'] = $tahun;
            $Data['DataPegawai'] = $this->pegawai_model->get_pegawai_by_code($nip);
            if($Data['DataPegawai']->num_rows() > 0)
            {
                $DataRow=$Data['DataPegawai']->row();
                $Data["title_web"]=$this->lang->line('title_web');
                $Data["subheader"]=$this->lang->line('subheader');
                $Data["input_header"]=$this->lang->line('input_kpi_header');
                $this->breadcrumbs->push($this->lang->line('input_kpi_header'), '/organisasi/Pegawai/view_form/'.$nip."/".$tahun."/".$Bln);
                $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
                $Data['AlertInput']=$this->session->flashdata('AlertInput');
                
                $kd_departemen=$DataRow->kd_departemen;
                $Data['DataKPIDepartemen']=$this->pegawai_model->get_kpi_all_pegawai($this->kd_perusahaan);
                $Data['Tahun']=$tahun;
                //$Data['ListTahun']= ListTahunBerjalan($this->config->item('year_apps'));
                $Data['ListTahun']= [$tahun=>$tahun];
                $Data['ListBulan']= ListBulan();
                
                $this->template->temp_default();
                $this->template->add_section('viewjs', 'organisasi/Pegawai_vf/v_Pegawai_kpi_input_js');
                $this->load->view('Pegawai_vf/v_Pegawai_kpi_input',$Data);
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
     // insert save
    public function pegawai_kpi_save()
    {
        $nip=$this->uri->segment(4);
        $tahun=$this->uri->segment(5);
        $tahun=($tahun=="")?date("Y"):$tahun;
        $Data=["success"=>false,"messages"=>array(),'kode'=>$nip];
        
        $this->form_validation->set_rules('tahun', $this->lang->line('tahun_efektif'), 'trim|required');
        $this->form_validation->set_rules('bulan', $this->lang->line('bulan_efektif'), 'trim|required');
        $this->form_validation->set_rules('deskripsi', $this->lang->line('deskripsi'), 'trim|required');
        //$this->form_validation->set_rules('weightage_bd[]', $this->lang->line('weightage_bd'), 'trim|required');
        $this->form_validation->set_rules('weightage_kpi[]', $this->lang->line('weightage_kpi'), 'trim|required');
//        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        $errorKode=$this->_CekKodePegawaiKPI($nip,$this->input->post('bulan'),$this->input->post('tahun'));
        
        if ($this->form_validation->run() == FALSE or $errorKode==FALSE ){
//                echo form_error('weightage[]');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
                
            }
            if($errorKode==FALSE){
                $Data['messages']['kd_pk']= $this->lang->line('error_bulan_tahun_exist');
            }
        }else{
            $tahun=$this->input->post('tahun');
            $bulan=$this->input->post('bulan');
            $weightage_bd=$this->input->post('weightage_bd');
            $kd_measurement2=$this->input->post('kd_measurement3');
            $weightage_kpi=$this->input->post('weightage_kpi');
            $kd_departemen=$this->input->post('kd_departemen');
//            $this->pegawai_model->delete_pegawai_kpi_nip($nip,$tahun);
//            var_dump($kd_measurement2);
            $KodePK=$tahun.$bulan.$nip.$kd_departemen;
            $Input=['kd_pk'=>$KodePK,
                        'nip'=>$nip,
                        'kd_departemen'=>$kd_departemen,
                        'deskripsi'=>$this->input->post('deskripsi'),
                        'bulan'=>$bulan,
                        'tahun'=>$tahun,
                        'status'=>1,
                        'user_input'=>$this->session->userdata('identity'),
                        'tgl_input'=>date("Y-m-d H:i:s")
                        ];
            $id=$this->pegawai_model->insert_pegawai_kpi($Input);
            //insert user activity
            $this->useractivity->run_acitivity('insert '.$this->lang->line('input_header'),$KodePK,$Input);
            $no=1;    
            foreach($kd_measurement2 as $key=>$val)
            {
                $type=$this->input->post('type'.$val);
                $stat_cal=$this->input->post('stat_cal'.$val);
                $target_input=$this->input->post('target_input'.$val);
                $target_label=$this->input->post('target_label'.$val);

                $WKPIBD=$weightage_bd[$key];
                if($WKPIBD==""){
                    $WKPIBD=1;
                }
                $WKPI=$weightage_kpi[$key];
                if($WKPI==""){
                    $WKPI=1;
                }
                $jsonFormula="";
                $formula=[];
                for($i=1;$i<=4;$i++){
                    $formula_operator=$this->input->post('formula_operator'.$i.$val);
                    $formula_value=$this->input->post('formula_value'.$i.$val);
                    $formula_label=$this->input->post('formula_label'.$i.$val);
                    $formula_score=$this->input->post('formula_score'.$i.$val);
                    $formula[$i]=[
                        "operator"=>$formula_operator,
                        "value"=>$formula_value,
                        "label"=>$formula_label,
                        "score"=>$formula_score,
                    ];

                }
                $jsonFormula=json_encode($formula);
                //$this->departemen_kpi_model->delete_departemen_kpi($KodeDK);
                $Input=['kd_pkd'=>$KodePK.$no,
                        'kd_pk'=>$KodePK,
                        'kd_measurement'=>$val,
                        'weightage_bd'=>$WKPIBD,
                        'weightage_kpi'=>$WKPI,
                        'target'=>$target_input,
                        'target_label'=>$target_label,
                        'tipe_target'=>$type,
                        'status_calculate'=>$stat_cal,
                        'formula'=>$jsonFormula,
                        ];
                $id=$this->pegawai_model->insert_pegawai_kpi_d($Input);
                
                $no++;
            }
                    
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
            $Data["success"]=true;

        }
        
        echo json_encode($Data);
    }
    
    //cek exist bulan tahun Pegawai KPI
    public function _CekKodePegawaiKPI($nip,$bulan,$tahun){
        $Data=$this->pegawai_model->get_pegawai_kpi_header_by_bulan_tahun($nip,$bulan,$tahun)->num_rows();
            if($Data>0){
                $this->form_validation->set_message('_CekKode', $this->lang->line('error_kode'));
                return FALSE;
            }else{
                return TRUE;
            }
        
    }
    public function get_list_measurement(){
        $Thn=$this->uri->segment(5);
        $nip=$this->uri->segment(4);
        $measurement = $this->input->post('data');
        $DataPegawai = $this->pegawai_model->get_pegawai_by_code($nip);
        $kd_departemen="";
        if($DataPegawai->num_rows()>0)
        {
            $kd_departemen=$DataPegawai->row()->kd_departemen;
        }
        $Data=array();
//        $DataPegawaiKpi = $this->pegawai_model->get_pegawai_kpi_by_nip($nip,$Thn);
        $Data["DataMeasurement"]=$this->pegawai_model->get_measurement_search_multi_all_pegawai($measurement);
////        $Data["DataMeasurement"]=$this->pegawai_model->get_measurement_search_multi2($measurement,$kd_departemen,$Thn);
//        $Data['ListMeasurement']=array();
//        if($DataPegawaiKpi->num_rows() > 0)
//        {
//            foreach($DataPegawaiKpi->result() as $row)
//            {
//                $Data['ListMeasurement'][$row->kd_measurement]['kode'] = $row->kd_measurement; 
//                $Data['ListMeasurement'][$row->kd_measurement]['weightage_kpi'] = $row->weightage_kpi; 
//                $Data['ListMeasurement'][$row->kd_measurement]['weightage_bd'] = $row->weightage_bd; 
//                $Data['ListMeasurement'][$row->kd_measurement]['Tot_bobot_kpi'] = $row->Tot_bobot_kpi; 
//            }
//        }
//        var_dump($Data['ListMeasurement']);
//        die();
        $this->load->view('Pegawai_vf/v_Pegawai_kpi_input_list',$Data);
    }
    public function get_list_measurement_target(){
        $Thn=$this->uri->segment(5);
        $nip=$this->uri->segment(4);
        $measurement = $this->input->post('data');
        $Data["DataMeasurement"]=$this->pegawai_model->get_mesurement_target_pegawai($nip,$measurement,$Thn);
//        $Data["DataMeasurement"]=$this->pegawai_model->get_measurement_search_multi2($measurement,$kd_departemen,$Thn);
        
        $this->load->view('Pegawai_vf/v_Pegawai_kpi_target_list',$Data);
    }
    public function get_list_measurement_view(){
        $Thn=$this->uri->segment(5);
        $kd_departemen=$this->uri->segment(4);
        $Data["weightage_kpi"] = $this->input->post('weightage_kpi');
        $Data["weightage_bd"] = $this->input->post('weightage_bd');
        $kd_measurement = $this->input->post('kd_measurement');
//        var_dump($Data["weightage_bd"] );
//        die();
        // $Data["DataMeasurement"]=$this->pegawai_model->get_measurement_search_multi_pegawai($kd_departemen,$kd_measurement,$Thn);
        $Data["DataMeasurement"]=$this->pegawai_model->get_measurement_search_multi_all_pegawai($kd_measurement);
        $this->load->view('Pegawai_vf/v_Pegawai_kpi_view_list',$Data);
    }
    public function get_list_target_view(){
        $Thn=$this->uri->segment(5);
        $kd_departemen=$this->uri->segment(4);
        $target = $this->input->post('target');
        $kd_measurement = $this->input->post('kd_measurement');
        $Data['ListType']= ListType();
        $Data['ListStatCalculate']= ListStatCalculate();
        $Data['ListOperator']= ListOperator();
        $kode="MS200234";
        $arrTarget=json_decode($target,TRUE);
        $dataTarget=[];
        foreach($arrTarget as $val){
            if($val!=NULL){
                $key= key($val);
                $dataTarget[$key]=$val[$key]["data"];
            }
            
        }
        $Data['target']=$dataTarget;
        // echo $tes->$kode;
    //    var_dump( $dataTarget);
    //    var_dump($Data["target"] );
    //    die();
        // $Data["DataMeasurement"]=$this->pegawai_model->get_measurement_search_multi_pegawai($kd_departemen,$kd_measurement,$Thn);
        $Data["DataMeasurement"]=$this->pegawai_model->get_measurement_search_multi_all_pegawai($kd_measurement);
        $this->load->view('Pegawai_vf/v_Pegawai_kpi_view_target',$Data);
    }
    //delete pegawai_kpi
    public function pegawai_kpi_delete(){
        if($this->mion_auth->is_allowed('delete_pegawai_kpi')){
            $DataDelete=$this->uri->segment(6);
            $tahun=$this->uri->segment(5);
            $nip=$this->uri->segment(4);
            //get history data
            $DataPegawaiKpi = $this->pegawai_model->get_pegawai_kpi_by_kd_pk($DataDelete);
            $this->pegawai_model->delete_pegawai_kpi($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataPegawaiKpi->row_array());
        }

    }
    // copy bobot pegawai KPI
    public function copy_bobot()
    {
        $thn=$this->uri->segment(4);
        $nip=$this->uri->segment(5);
        $Data=["success"=>false,"messages"=>array(),'kode'=>$nip];
        $ThnLalu=$thn-1;
        $DataBobot=$this->pegawai_model->get_pegawai_kpi_by_nip($nip,$ThnLalu);
        if($DataBobot->num_rows() > 0)
        {
            $this->pegawai_model->insert_copy_bobot_pegawai_kpi($nip,$thn,$ThnLalu,$this->session->userdata('identity'),date("Y-m-d H:i:s"));
            //insert user activity
            $this->useractivity->run_acitivity('duplicate '.$this->lang->line('list_header_bobot')." ".$thn,$thn);
            $this->session->set_flashdata('AlertInput', $this->lang->line('success_duplicate'));
            $Data["success"]=true;
        }
        echo json_encode($Data);
    }
    // insert bobot kpi pegawai
    public function kpi_view_form()
    {   
        $kd_pk=$this->uri->segment(4);
        $Data['DataKpiPegawai'] = $this->pegawai_model->get_pegawai_kpi_by_kd_pk($kd_pk);
        if($Data['DataKpiPegawai']->num_rows()>0){
            
//            echo "masuk";
//            die();
            $this->load->view('Pegawai_vf/v_Pegawai_kpi_view',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_found'));
        }
    }
    // insert bobot bd kpi pegawai
    public function bobot_insert_form()
    {   
        $tahun=$this->uri->segment(4);
        $kd_measurement=$this->uri->segment(5);
        $kd_departemen=$this->uri->segment(6);
        $tahun=($tahun=="")?date("Y"):$tahun;
        if($this->mion_auth->is_allowed('add_pegawai_kpi_bobot') and $kd_measurement!=""){
            $Data=array();
            $Data['DataMeasurementPeg']=$this->pegawai_model->get_pegawai_kpi_by_kd_measurement($kd_measurement,$kd_departemen,$tahun);
            $Data['Tahun']=$tahun;
            $Data['ListTahun']= ListTahunBerjalan($this->config->item('year_apps'));
            
            $this->load->view('Pegawai_vf/v_Pegawai_kpi_Bobot_input',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_access'));
        }
    }
    
    // insert bobot kpi pegawai bd
    public function bobot_save()
    {
        $tahun=$this->uri->segment(4);
        $kd_measurement=$this->uri->segment(5);
        $kd_departemen=$this->uri->segment(6);
        $nip_data=$this->uri->segment(7);
        $tahun=($tahun=="")?date("Y"):$tahun;
        $Data=["success"=>false,"messages"=>array(),'kode'=>$nip_data];
        $this->form_validation->set_rules('tahun', $this->lang->line('tahun'), 'trim|required');
        
        $this->form_validation->set_rules('nip[]', $this->lang->line('kd_departemen'), 'trim|required');
        $this->form_validation->set_rules('weightage_bd[]', $this->lang->line('weightage_bd'), 'trim|required');
        
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        
        if ($this->form_validation->run() == FALSE ){
//                echo form_error('weightage[]');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                if($key=='weightage_bd'){
                    $Data['messages'][$key]= form_error('weightage_bd[]');
                }else if($key=='nip'){
                    $Data['messages'][$key]= form_error('nip[]');
                }else{
                    $Data['messages'][$key]= form_error('tahun');
                }
                
                
            }
        }else{
            $nip=$this->input->post('nip');
            $weightage_bd=$this->input->post('weightage_bd');
            $weightage_kpi=$this->input->post('weightage_kpi');
            $kd_pkd=$this->input->post('kd_pkd');
            $TotalBobot=$this->input->post('total_bobot');
//            $TotalBobot=0;
//            foreach($kd_bd as $key=>$val)
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
                //$no=1;
                //$this->pegawai_model->delete_pegawai_kpi_kd_measurement_departemen($kd_measurement,$kd_departemen,$tahun);
                foreach($nip as $key=>$val)
                {
                    $KodePK=$tahun.$val.$kd_departemen.$kd_measurement;
                    $WKPIBD=$weightage_bd[$key];
                    if($WKPIBD==""){
                        $WKPIBD=1;
                    }
                    $WKPI=$weightage_kpi[$key];
                    if($WKPI==""){
                        $WKPI=1;
                    }
                    //$this->departemen_kpi_model->delete_departemen_kpi($KodeDK);
                    $Input=[
                            'weightage_bd'=>$WKPIBD,
                            'weightage_kpi'=>$WKPI
                            ];
                    $id=$this->pegawai_model->update_pegawai_kpi_bobot($kd_pkd[$key],$Input);
                    //insert user activity
                    $this->useractivity->run_acitivity('insert '.$this->lang->line('weightage_bd'),$kd_pkd[$key],$Input);
                }

                    //$id=$this->business_driver_model->insert_business_driver($Input);

                    $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
                    $Data["success"]=true;

            }
        }
        
        echo json_encode($Data);
    }
    //edit form pegawai kpi
    public function kpi_edit_form()
    {
        if($this->mion_auth->is_allowed('edit_pegawai_kpi')){
            $nip=$this->uri->segment(4);
            $tahun=$this->uri->segment(5);
            $Bln=$this->uri->segment(6);
            $tahun=($tahun=="")?date("Y"):$tahun;
            $Data['DataBulan'] = ($Bln=="")?$Bln= '':$Bln;
            $Data['DataTahun'] = $tahun;
            $DataDepartemenKpi = $this->pegawai_model->get_pegawai_kpi_by_nip($nip,$tahun);
            if($DataDepartemenKpi->num_rows() > 0)
            {
                $Data["title_web"]=$this->lang->line('title_web');
                $Data["subheader"]=$this->lang->line('subheader');
                $Data["input_header"]=$this->lang->line('edit_header');
                $this->breadcrumbs->push($this->lang->line('edit_header'), '/organisasi/Pegawai/kpi_edit_form/'.$nip."/".$tahun);
                $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
                $Data['AlertInput']=$this->session->flashdata('AlertInput');
                
                $DataRow=$DataDepartemenKpi->row();
                $kd_departemen=$DataRow->kd_departemen;
                $Data['DataKPIDepartemen']=$this->pegawai_model->get_departemen_kpi_remaining_bobot_pegawai($kd_departemen,$tahun);
                $Data['Tahun']=$tahun;
                $Data['ListTahun']= ListTahunBerjalan($this->config->item('year_apps'));
                $Data['ListMeasurement']=array();
                if($DataDepartemenKpi->num_rows() > 0)
                {
                    foreach($DataDepartemenKpi->result() as $row)
                    {
                        $Data['ListMeasurement'][$row->kd_measurement] = $row->kd_measurement; 
                    }
                }
                $Data['DataDepartemenKpi']= $DataDepartemenKpi;

                $this->template->temp_default();
                $this->template->add_section('viewjs', 'organisasi/Pegawai_vf/v_Pegawai_kpi_input_js');
                $this->load->view('Pegawai_vf/v_Pegawai_kpi_edit',$Data);
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
    
    // insert target measurement
    public function target_insert_form()
    {   
        $Thn=$this->uri->segment(5);
        $nip=$this->uri->segment(4);
        $measurement = $this->input->post('data');
        $DataPegawai = $this->pegawai_model->get_pegawai_by_code($nip);
        $kd_departemen="";
        if($DataPegawai->num_rows()>0)
        {
            $kd_departemen=$DataPegawai->row()->kd_departemen;
        }
        $Data=array();
//        $DataPegawaiKpi = $this->pegawai_model->get_pegawai_kpi_by_nip($nip,$Thn);
        $Data["DataMeasurement"]=$this->pegawai_model->get_measurement_search_multi_all_pegawai($measurement);
        $Data['ListType']= ListType();
        $Data['ListStatCalculate']= ListStatCalculate();
        $Data['ListOperator']= ListOperator();

        $this->load->view('Pegawai_vf/v_Pegawai_target_input',$Data);
    }
    
     // insert target pegawai
    public function target_save()
    {
        $kd_pkd=$this->uri->segment(4);
        $nip=$this->uri->segment(5);
        $Data=["success"=>false,"messages"=>array(),"kode"=>$nip];
        $this->form_validation->set_rules('kd_measurement', $this->lang->line('nm_measurement'), 'trim|required');
//        $this->form_validation->set_rules('bulan', $this->lang->line('bulan_efektif'), 'trim|required');
//        $this->form_validation->set_rules('tahun', $this->lang->line('tahun_efektif'), 'trim|required');
//        $this->form_validation->set_rules('deskripsi', $this->lang->line('deskripsi'), 'trim|required');
        
        for($i=1;$i<=12;$i++)
        {
            $this->form_validation->set_rules('bulan_'.$i, getNamaBulan($i), 'trim|required');
        }
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        
        if ($this->form_validation->run() == FALSE ){
//                echo form_error('jenis_kelamin');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
            }
            //var_dump($Data['messages']);
        }else{
            $tahun=$this->input->post('tahun');
            $bulan=$this->input->post('bulan');
            $kd_measurement=$this->input->post('kd_measurement');
            $kd_departemen=$this->input->post('kd_departemen');
            $kd_pk=$this->input->post('kd_pk');
            $type=$this->input->post('type');
            $unit=$this->input->post('unit');
            $period=$this->input->post('period');
            $DataMeasurement=$this->pegawai_model->getDataMeasurement($kd_measurement);
            $Aggregation = ($DataMeasurement)?$DataMeasurement->aggregation:'';
            if($DataMeasurement)
            $TargetDetail=array();
            $KodePT=uniqid(substr($tahun, 2).$bulan.$nip.$kd_measurement."_");
            
            for($i=1;$i<=12;$i++)
            {
                $TargetDetail[$i]['kd_ptd']=$KodePT."-".$i;
                $TargetDetail[$i]['kd_pt']=$KodePT;
                $TargetDetail[$i]['bulan']=$i;
                $TargetDetail[$i]['target']=$this->input->post('bulan_'.$i);
            }

            $Input=['kd_pt'=>$KodePT,
                    'nip'=>$nip,
                    'tahun'=>$this->input->post('tahun'),
                    'bulan'=>$this->input->post('bulan'),
                    'kd_pk'=>$this->input->post('kd_pk'),
                    'kd_measurement'=>$kd_measurement,
                    'kd_departemen'=>$kd_departemen,
                    'target_setahun'=>0,
                    'target_setahun_aktual'=>0,
                    'type'=>$type,
                    'unit'=>$unit,
                    'period'=>$period,
                    'aggregation' => $Aggregation,
                    'status'=>1,
                    'user_input'=>$this->session->userdata('identity'),
                    'tgl_input'=>date("Y-m-d H:i:s")
                    ];

            $id=$this->pegawai_model->insert_pegawaii_target($Input);
            $this->pegawai_model->insert_pegawaii_target_d_batch($TargetDetail);
            
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
            //insert user activity
            $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$this->input->post('nip'),$Input);
            $Data["success"]=true;
            
            
        }
        
        echo json_encode($Data);
    }
    // insert target measurement
    public function target_view_form()
    {   
        if($this->mion_auth->is_allowed('view_pegawai_target')){
            $kd_pkd=$this->uri->segment(4);
            $Data['DataTargetPegawai'] = $this->pegawai_model->get_pegawai_target_by_kd_pkd($kd_pkd);
            if($Data['DataTargetPegawai']->num_rows()>0){

    //            echo "masuk";
    //            die();
                $Data['ListType']= ListType();
                $Data['ListUnit']= ListUnit();
                $Data['ListUnitSimbol']= ListUnitSimbol();
                $Data['ListPeriodAll']= ListPeriodAll();
                $Data['ListStatCalculate']= ListStatCalculate();
                $Data['ListOperator']= ListOperator();
                $this->load->view('Pegawai_vf/v_Pegawai_target_view',$Data);
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
    // edit target
    public function target_edit_form()
    {   
        if($this->mion_auth->is_allowed('edit_pegawai_target')){
            $kd_pkd=$this->uri->segment(4);
            $Data['DataTargetPegawai'] = $this->pegawai_model->get_pegawai_target_by_kd_pkd($kd_pkd);
            if($Data['DataTargetPegawai']->num_rows()>0){

    //            echo "masuk";
    //            die();
                $Data['ListType']= ListType();
                $Data['ListUnit']= ListUnit();
                $Data['ListUnitSimbol']= ListUnitSimbol();
                $Data['ListPeriodAll']= ListPeriodAll();
                $Data['ListStatCalculate']= ListStatCalculate();
                $Data['ListOperator']= ListOperator();
                $this->load->view('Pegawai_vf/v_Pegawai_target_edit',$Data);
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
    
     // edit target pegawai
    public function target_edit()
    {
        $kd_pkd=$this->uri->segment(4);
        $nip=$this->input->post('nip');
        $Data=["success"=>false,"messages"=>array(),"kode"=>$nip];
        $this->form_validation->set_rules('kd_measurement', $this->lang->line('nm_measurement'), 'trim|required');
        $this->form_validation->set_rules('type', $this->lang->line('type'), 'trim|required');
        $this->form_validation->set_rules('stat_cal', $this->lang->line('stat_cal'), 'trim|required');
        $this->form_validation->set_rules('target_input', $this->lang->line('target_input'), 'trim|required');
        $this->form_validation->set_rules('target_label', $this->lang->line('target_label'), 'trim|required');
        
        for($i=1;$i<=4;$i++)
        {
            $this->form_validation->set_rules('formula_operator'.$i, $this->lang->line('formula_operator'), 'trim|required');
            $this->form_validation->set_rules('formula_value'.$i, $this->lang->line('formula_value'), 'trim|required');
            $this->form_validation->set_rules('formula_label'.$i, $this->lang->line('formula_label'), 'trim|required');
            $this->form_validation->set_rules('formula_score'.$i, $this->lang->line('formula_score'), 'trim|required');
        }
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        
        if ($this->form_validation->run() == FALSE ){
//                echo form_error('jenis_kelamin');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
            }
            //var_dump($Data['messages']);
        }else{
            $kd_pkd=$this->input->post('kd_pkd');
            
            $jsonFormula="";
            $formula=[];
            for($i=1;$i<=4;$i++){
                $formula_operator=$this->input->post('formula_operator'.$i);
                $formula_value=$this->input->post('formula_value'.$i);
                $formula_label=$this->input->post('formula_label'.$i);
                $formula_score=$this->input->post('formula_score'.$i);
                $formula[$i]=[
                    "operator"=>$formula_operator,
                    "value"=>$formula_value,
                    "label"=>$formula_label,
                    "score"=>$formula_score,
                ];

            }
            $jsonFormula=json_encode($formula);
            $Input['kd_measurement']=$this->input->post('kd_measurement');
            $Input['tipe_target']=$this->input->post('type');
            $Input['status_calculate']=$this->input->post('stat_cal');
            $Input['target']=$this->input->post('target_input');
            $Input['target_label']=$this->input->post('target_label');
            $Input['formula']=$jsonFormula;

            $this->pegawai_model->update_pegawai_kpi_bobot($kd_pkd,$Input);

            
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
            //insert user activity
            $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$this->input->post('nip'),$Input);
            $Data["success"]=true;
            
            
        }
        
        echo json_encode($Data);
    }
}


<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ReportPegawai extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('report/ReportPegawai',$siteLang);
            $this->load->model('report_pegawai_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/report/ReportPegawai');
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
        
        $DataPerusahaan=$this->report_pegawai_model->get_perusahaan_all_report_pegawai($this->kd_perusahaan);
        $Data['ListPerusahaan']=  get_value_array($DataPerusahaan,'kd_perusahaan','nm_perusahaan',TRUE);

        $DataDepartemen=$this->report_pegawai_model->get_departemen_all_report_pegawai($this->kd_perusahaan);
        $Data['ListDepartemen']=  get_value_array($DataDepartemen,'kd_departemen','nm_departemen',TRUE);

        $DataJabatan=$this->report_pegawai_model->get_jabatan_all_report_pegawai($this->kd_perusahaan);
        $Data['ListJabatan']=  get_value_array($DataJabatan,'kd_jabatan','nm_jabatan',TRUE);

//        $DataPegawai=$this->pegawai_model->get_pegawai_all_report_pegawai();
//        $Data['ListPegawai']=  get_value_array($DataPegawai,'nip','nama',TRUE);

        $Data['ListKelamin'] = $this->_list_kelamin();
            
        //insert user activity
        $this->useractivity->run_acitivity('index '.$this->lang->line('subheader'));
        $this->template->temp_default();
        $this->template->add_section('viewjs', 'report/ReportPegawai_vf/v_ReportPegawai_js');
        $this->load->view('ReportPegawai_vf/v_ReportPegawai',$Data);
    }
    
    //get list pegawai json
    public function get_list()
    {
                    $data=decrypt_url($this->uri->segment(4));
                    $data_arr= explode("#", $data);
                    $keyword = "";
                    $kd_departemen = "";
                    $kd_jabatan = "";
                    $jenis_kelamin = "";
                    $tgl_masuk = "";
                    $tgl_keluar = "";
                    
                    if($data!="" and count($data_arr)>0){
                        
                        $keyword = $data_arr[0];
                        $kd_departemen = $data_arr[1];
                        $kd_jabatan = $data_arr[2];
                        $jenis_kelamin = $data_arr[3];
                        $tgl_masuk = $data_arr[4];
                        $tgl_keluar = $data_arr[5];
                    }
                    
                    $addsql = array();
                    if($keyword!=""){
                        $addsql[]="(tbl_ap.nip like '%$keyword%' or tbl_ap.nama like '%$keyword%')";
                    }
                    if($kd_departemen!=""){
                        $addsql[]=" tbl_ap.kd_departemen = '$kd_departemen' ";
                    }
                    if($kd_jabatan!=""){
                        $addsql[]=" tbl_ap.kd_jabatan = '$kd_jabatan' ";
                    }
                    if($jenis_kelamin!=""){
                        $addsql[]=" tbl_ap.jenis_kelamin = '$jenis_kelamin' ";
                    }
                    if($tgl_masuk!=""){
//                        var_dump($addsql);
//                        echo $tgl_masuk."---";
//                        die();
                        $tgl_masuk_arr= split_daterange($tgl_masuk);
                        $addsql[]=" tbl_ap.tgl_masuk between '$tgl_masuk_arr[0]' and '$tgl_masuk_arr[1]' ";
                    }
                    if($tgl_keluar!=""){
                        $tgl_keluar_arr= split_daterange($tgl_keluar);
                        $addsql[]=" tbl_ap.tgl_masuk between '$tgl_keluar_arr[0]' and '$tgl_keluar_arr[1]' ";
                    }
                    $sql= implode(" and ", $addsql);
                    if($sql!=""){
                        $sql=" and ".$sql;
                    }
//                    echo $sql;
//                    die();
                    $request = '';
                    $custom_whare="tbl_ap.kd_perusahaan ='$this->kd_perusahaan' ".$sql;
                    $table = " 
                            (select pegawai.*,departemen.nm_departemen,jabatan.nm_jabatan , pg.nama as nm_report_to from pegawai 
                                LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen 
                                LEFT JOIN jabatan ON pegawai.kd_jabatan = jabatan.kd_jabatan 
                                LEFT JOIN pegawai pg ON pg.nip=pegawai.report_to) as tbl_ap
                            
                    ";
                    if($this->mion_auth->is_admin()){
                        $table = " 
                            (select pegawai.*,departemen.nm_departemen,jabatan.nm_jabatan , pg.nama as nm_report_to from pegawai 
                                LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen 
                                LEFT JOIN jabatan ON pegawai.kd_jabatan = jabatan.kd_jabatan 
                                LEFT JOIN pegawai pg ON pg.nip=pegawai.report_to) as tbl_ap
                            
                    ";
                    }else{
                        $table = " 
                            (select pegawai.*,departemen.nm_departemen,jabatan.nm_jabatan , pg.nama as nm_report_to from pegawai 
                                LEFT JOIN departemen ON pegawai.kd_departemen = departemen.kd_departemen 
                                LEFT JOIN jabatan ON pegawai.kd_jabatan = jabatan.kd_jabatan 
                                LEFT JOIN pegawai pg ON pg.nip=pegawai.report_to
                                where pegawai.nip in (
	                            	select nip
						from(
						select @pv:=concat(@pv,',',tabel.nip) as kode,tabel.* 
						from ( 
								select pegawai.nip,pegawai.report_to
						      from pegawai 
								LEFT JOIN pegawai pg ON pg.nip=pegawai.report_to
						      where pegawai.kd_perusahaan = '".$this->kd_perusahaan."'
						      order by pegawai.nip asc
						) as tabel
						join
						(select @pv:=(select GROUP_CONCAT(nip) from pegawai where nip in ('".$this->session->userdata('login_nip')."')))tmp
						where FIND_IN_SET(tabel.report_to, @pv) or tabel.nip='".$this->session->userdata('login_nip')."'
						)as list_pegawai
					)
                            ) as tbl_ap
                            
                    ";
                    }
                    $primaryKey = 'tbl_ap.nip';
                    $columns = array(
                            array( 
                                    'NO', 
                                    'dt' => 0 ,
                                    'searchable' => FALSE
                            ),
                            array(
                                    'db' => 'tbl_ap.nip',
                                    'dt' => 1,
                            ),
                            array( 
                                    'db' => 'tbl_ap.nama', 
                                    'dt' => 2,
                                    'default_value'=>'',
                                    'formatter' => function( $d, $row ) {
                                                return ucwords(strtolower($d));
                                            }
                            ),
                            array( 
                                    'db' => 'tbl_ap.nm_departemen', 
                                    'dt' => 3,
                            ),
                            array( 
                                    'db' => 'tbl_ap.nm_jabatan', 
                                    'dt' => 4,
                            ),
                            array( 
                                    'db' => 'tbl_ap.nm_report_to', 
                                    'dt' => 5,
                                    'default_value'=>'',
                                    'formatter' => function( $d, $row ) {
                                                return ucwords(strtolower($d));
                                            }
                            ),
                            array( 
                                    'db' => 'tbl_ap.tgl_masuk', 
                                    'dt' => 6,
                                    'default_value'=>'',
                                    'formatter' => function( $d, $row ) {
                                                return convert_date($d);
                                            }
                            ),
                            array( 
                                    'db' => 'tbl_ap.status', 
                                    'dt' => 7,
                            )

                    );

//                    $a_condition = array();
//                    $a_condition_type = array(); 
//                    $a_link = array();
//                    $a_src = array();
//                    $a_src_change = array();
//
//                    
//                            $a_link['View'] = '<a href="'. site_url('organisasi/Pegawai/view_form/').'#action_lock#" class="#link_class#" title="#link_title#"><i class="la la-file-text"></i></a>';
//                            $a_src['View'] = 'm-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill openPopupView';
//                            
//                    if($this->mion_auth->is_allowed('edit_pegawai')) {
//                            $a_link['Edit'] = '<a href="'. site_url('organisasi/Pegawai/edit_form/').'#action_lock#" class="#link_class#" title="#link_title#"><i class="la la-edit"></i></a>';
//                            $a_src['Edit'] = 'm-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill openPopupEdit';
//                    }
//                    if($this->mion_auth->is_allowed('delete_pegawai')) { 
//                            $a_link['Delete'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-trash"></i></a>';
//                            $a_src['Delete'] = 'm-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill delete-data';
//                    }
//                    //add to ajax columns
//                    $columns[] = array(
//                                    'action',
//                                    'searchable' => FALSE,
//                                    'dt'=>8,
//                                    'condition'=>$a_condition,
//                                    'condition_type'=>$a_condition_type,
//                                    'action_link'=>$a_link,
//                                    'action_src'=>$a_src,
//                                    'action_src_change'=>$a_src_change,
//                                    'action_lock'=>'nip'
//                            );

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
    // insert pegawai
    public function search()
    {
        $Data=["success"=>false,"messages"=>array(),"data"=>''];
        $keyword = $this->input->post('keyword');
        $kd_departemen = $this->input->post('kd_departemen');
        $kd_jabatan = $this->input->post('kd_jabatan');
        $jenis_kelamin = $this->input->post('jenis_kelamin');
        $tgl_masuk = $this->input->post('tgl_masuk');
        $tgl_keluar = $this->input->post('tgl_keluar');
        
        $listData=encrypt_url($keyword."#".$kd_departemen."#".$kd_jabatan."#".$jenis_kelamin."#".$tgl_masuk."#".$tgl_keluar);
        $Data["success"]=true;
        $Data["data"]=$listData;
            
            
        
        
        echo json_encode($Data);
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


<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ReportAppraisal extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('report/ReportAppraisal',$siteLang);
            $this->load->model('report_pegawai_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/report/ReportAppraisal');
            $this->kd_perusahaan = $this->session->userdata('ses_perusahaan');
            $this->ses_dept = $this->session->userdata('ses_departemen');
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
        
//        $DataPerusahaan=$this->report_pegawai_model->get_perusahaan_all_report_pegawai($this->kd_perusahaan);
//        $Data['ListPerusahaan']=  get_value_array($DataPerusahaan,'kd_perusahaan','nm_perusahaan',TRUE);
        if($this->ses_dept!=""){
                $DataDepartemen=$this->report_pegawai_model->get_departemen_all_report_pegawai_kd_dept($this->kd_perusahaan,$this->ses_dept);
        }else{
                $DataDepartemen=$this->report_pegawai_model->get_departemen_all_report_pegawai($this->kd_perusahaan);
        }
        $Data['ListDepartemen']=  get_value_array($DataDepartemen,'kd_departemen','nm_departemen',TRUE);
        
        $LTahun=ListTahunBerjalan($this->config->item('year_apps'));
        unset($LTahun['']);
        krsort($LTahun);
        $Data['ListTahun']= $LTahun;
        $LBulan=ListBulan();
        //unset($LBulan['']);
        $Data['ListBulan']= $LBulan;
        $Data['ListReport']= $this->_list_report();
//        $DataJabatan=$this->report_pegawai_model->get_jabatan_all_report_pegawai($this->kd_perusahaan);
//        $Data['ListJabatan']=  get_value_array($DataJabatan,'kd_jabatan','nm_jabatan',TRUE);

//        $DataPegawai=$this->pegawai_model->get_pegawai_all_report_pegawai();
//        $Data['ListPegawai']=  get_value_array($DataPegawai,'nip','nama',TRUE);

//        $Data['ListKelamin'] = $this->_list_kelamin();
            
        //insert user activity
        $this->useractivity->run_acitivity('index '.$this->lang->line('subheader'));
        $this->template->temp_default();
        $this->template->add_section('viewjs', 'report/ReportAppraisal_vf/v_ReportAppraisal_js');
        $this->load->view('ReportAppraisal_vf/v_ReportAppraisal',$Data);
    }
    
    //get list pegawai json
    public function get_list()
    {
                    $data=decrypt_url($this->uri->segment(4));
                    $data_arr= explode("#", $data);
                    $kd_departemen = "";
                    $bulan = "";
                    $tahun = "";
                    
                    if($data!="" and count($data_arr)>0){
                        
                        $kd_departemen = $data_arr[0];
                        $bulan = $data_arr[1];
                        $tahun = $data_arr[2];
                    }
                    
                    $addsql = array();
                    if($kd_departemen!=""){
                        $addsql[]=" tbl_ap.kd_departemen = '$kd_departemen' ";
                    }
                    if($bulan!=""){
                        $addsql[]=" tbl_ap.bulan = '$bulan' ";
                    }
                    if($tahun!=""){
                        $addsql[]=" tbl_ap.tahun = '$tahun' ";
                    }
                    $sql= implode(" and ", $addsql);
                    if($sql!=""){
                        $sql=" and ".$sql;
                    }
//                    echo $sql;
//                    die();
                    $request = '';
                    $custom_whare="tbl_ap.kd_perusahaan ='$this->kd_perusahaan' ".$sql;
                    
                    if($this->mion_auth->is_admin()){
                        $table = " 
                            (select appraisal.kd_appraisal,
                                appraisal.nip,
                                pegawai.nama,
                                appraisal.tahun,
                                appraisal.bulan,
                                appraisal.point,
                                appraisal.kd_departemen,
                                departemen.nm_departemen,
                                departemen.kd_perusahaan,
                                appraisal.kd_jabatan,
                                jabatan.nm_jabatan
                            from appraisal
                            inner join pegawai on pegawai.nip = appraisal.nip
                            inner join departemen on departemen.kd_departemen = appraisal.kd_departemen
                            inner join jabatan on jabatan.kd_jabatan = appraisal.kd_jabatan
                          ) as tbl_ap
                            
                    ";
                    }else{
                        $table = " 
                            (select appraisal.kd_appraisal,
                                                    appraisal.nip,
                                                    pegawai.nama,
                                                    appraisal.tahun,
                                                    appraisal.bulan,
                                                    appraisal.point,
                                                    appraisal.kd_departemen,
                                                    departemen.nm_departemen,
                                                    departemen.kd_perusahaan,
                                                    appraisal.kd_jabatan,
                                                    jabatan.nm_jabatan
                            from appraisal
                            inner join pegawai on pegawai.nip = appraisal.nip
                            inner join departemen on departemen.kd_departemen = appraisal.kd_departemen
                            inner join jabatan on jabatan.kd_jabatan = appraisal.kd_jabatan
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
                    $primaryKey = 'tbl_ap.kd_appraisal';
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
                                    'db' => 'tbl_ap.bulan', 
                                    'dt' => 5,
                                    'formatter' => function( $d, $row ) {
                                                return getNamaBulan($d);
                                            }
                            ),
                            array( 
                                    'db' => 'tbl_ap.tahun', 
                                    'dt' => 6,
                            ),
                            array( 
                                    'db' => 'tbl_ap.point', 
                                    'dt' => 7
                            )

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
    //get list dept json
    public function get_list_dept()
    {
                    $data=decrypt_url($this->uri->segment(4));
                    $data_arr= explode("#", $data);
                    $kd_departemen = "";
                    $bulan = "";
                    $tahun = "";
                    
                    if($data!="" and count($data_arr)>0){
                        
                        $kd_departemen = $data_arr[0];
                        $bulan = $data_arr[1];
                        $tahun = $data_arr[2];
                    }
                    
                    $addsql = array();
                    if($kd_departemen!=""){
                        $addsql[]=" tbl_ap.kd_departemen = '$kd_departemen' ";
                    }
                    if($bulan!=""){
                        $addsql[]=" tbl_ap.bulan = '$bulan' ";
                    }
                    if($tahun!=""){
                        $addsql[]=" tbl_ap.tahun = '$tahun' ";
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
                            (select departemen_result.kd_departemen,
                                                    departemen.nm_departemen,
                                                    departemen.kd_perusahaan,
                                                    departemen_result.bulan,
                                                    departemen_result.tahun,
                                                    round((departemen_result.score_kpi),2) as score_point
                            from departemen_result
                            INNER JOIN departemen ON departemen_result.kd_departemen = departemen.kd_departemen
                            ) as tbl_ap
                            
                    ";
                    $primaryKey = 'tbl_ap.kd_departemen';
                    $columns = array(
                            array( 
                                    'NO', 
                                    'dt' => 0 ,
                                    'searchable' => FALSE
                            ),
                            array(
                                    'db' => 'tbl_ap.kd_departemen',
                                    'dt' => 1,
                            ),
                            array( 
                                    'db' => 'tbl_ap.nm_departemen', 
                                    'dt' => 2,
                            ),
                            array( 
                                    'db' => 'tbl_ap.bulan', 
                                    'dt' => 3,
                                    'formatter' => function( $d, $row ) {
                                                return getNamaBulan($d);
                                            }
                            ),
                            array( 
                                    'db' => 'tbl_ap.tahun', 
                                    'dt' => 4,
                            ),
                            array( 
                                    'db' => 'tbl_ap.score_point', 
                                    'dt' => 5
                            )

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
    public function get_list_rekap()
    {
                    $data=decrypt_url($this->uri->segment(4));
                    $data_arr= explode("#", $data);
                    $kd_departemen = "";
                    $bulan = "";
                    $tahun = "";
                    
                    if($data!="" and count($data_arr)>0){
                        
                        $kd_departemen = $data_arr[0];
                        $bulan = $data_arr[1];
                        $tahun = $data_arr[2];
                    }
                    
                    $addsql = array();
                    if($kd_departemen!=""){
                        $addsql[]=" tbl_ap.kd_departemen = '$kd_departemen' ";
                    }
                    if($bulan!=""){
                        $addsql[]=" tbl_ap.bulan = '$bulan' ";
                    }
                    if($tahun!=""){
                        $addsql[]=" tbl_ap.tahun = '$tahun' ";
                    }
                    $sql= implode(" and ", $addsql);
                    if($sql!=""){
                        $sql=" and ".$sql;
                    }
//                    echo $sql;
//                    die();
                    $request = '';
                    $custom_whare="tbl_ap.kd_perusahaan ='$this->kd_perusahaan' ".$sql;
                    
                    if($this->mion_auth->is_admin()){
                        $table = " 
                            (select appraisal.nip,
                            pegawai.nama,
                            appraisal.tahun,
                            appraisal.kd_departemen,
                            departemen.nm_departemen,
                            departemen.kd_perusahaan,
                            appraisal.kd_jabatan,
                            jabatan.nm_jabatan,
                            round(AVG(case when appraisal.bulan = 1 then appraisal.point ELSE 0 END),2)AS jan,
                            round(AVG(case when appraisal.bulan = 2 then appraisal.point ELSE 0 END),2)AS feb,
                            round(AVG(case when appraisal.bulan = 3 then appraisal.point ELSE 0 END),2)AS mar,
                            round(AVG(case when appraisal.bulan = 4 then appraisal.point ELSE 0 END),2)AS apr,
                            round(AVG(case when appraisal.bulan = 5 then appraisal.point ELSE 0 END),2)AS may,
                            round(AVG(case when appraisal.bulan = 6 then appraisal.point ELSE 0 END),2)AS jun,
                            round(AVG(case when appraisal.bulan = 7 then appraisal.point ELSE 0 END),2)AS jul,
                            round(AVG(case when appraisal.bulan = 8 then appraisal.point ELSE 0 END),2)AS aug,
                            round(AVG(case when appraisal.bulan = 9 then appraisal.point ELSE 0 END),2)AS sep,
                            round(AVG(case when appraisal.bulan = 10 then appraisal.point ELSE 0 END),2)AS oct,
                            round(AVG(case when appraisal.bulan = 11 then appraisal.point ELSE 0 END),2)AS nov,
                            round(AVG(case when appraisal.bulan = 12 then appraisal.point ELSE 0 END),2)AS `dec`
                       from appraisal
                       inner join pegawai on pegawai.nip = appraisal.nip
                       inner join departemen on departemen.kd_departemen = appraisal.kd_departemen
                       inner join jabatan on jabatan.kd_jabatan = appraisal.kd_jabatan
                       GROUP BY appraisal.nip,
                            pegawai.nama,
                            appraisal.tahun,
                            appraisal.kd_departemen,
                            departemen.nm_departemen,
                            departemen.kd_perusahaan,
                            appraisal.kd_jabatan,
                            jabatan.nm_jabatan
                          ) as tbl_ap
                            
                    ";
                    }else{
                        $table = " 
                            (select appraisal.nip,
                                        pegawai.nama,
                                        appraisal.tahun,
                                        appraisal.kd_departemen,
                                        departemen.nm_departemen,
                                        departemen.kd_perusahaan,
                                        appraisal.kd_jabatan,
                                        jabatan.nm_jabatan,
                                        round(AVG(case when appraisal.bulan = 1 then appraisal.point ELSE 0 END),2)AS jan,
                                        round(AVG(case when appraisal.bulan = 2 then appraisal.point ELSE 0 END),2)AS feb,
                                        round(AVG(case when appraisal.bulan = 3 then appraisal.point ELSE 0 END),2)AS mar,
                                        round(AVG(case when appraisal.bulan = 4 then appraisal.point ELSE 0 END),2)AS apr,
                                        round(AVG(case when appraisal.bulan = 5 then appraisal.point ELSE 0 END),2)AS may,
                                        round(AVG(case when appraisal.bulan = 6 then appraisal.point ELSE 0 END),2)AS jun,
                                        round(AVG(case when appraisal.bulan = 7 then appraisal.point ELSE 0 END),2)AS jul,
                                        round(AVG(case when appraisal.bulan = 8 then appraisal.point ELSE 0 END),2)AS aug,
                                        round(AVG(case when appraisal.bulan = 9 then appraisal.point ELSE 0 END),2)AS sep,
                                        round(AVG(case when appraisal.bulan = 10 then appraisal.point ELSE 0 END),2)AS oct,
                                        round(AVG(case when appraisal.bulan = 11 then appraisal.point ELSE 0 END),2)AS nov,
                                        round(AVG(case when appraisal.bulan = 12 then appraisal.point ELSE 0 END),2)AS `dec`
                                from appraisal
                                inner join pegawai on pegawai.nip = appraisal.nip
                                inner join departemen on departemen.kd_departemen = appraisal.kd_departemen
                                inner join jabatan on jabatan.kd_jabatan = appraisal.kd_jabatan
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
                                GROUP BY appraisal.nip,
                                        pegawai.nama,
                                        appraisal.tahun,
                                        appraisal.kd_departemen,
                                        departemen.nm_departemen,
                                        departemen.kd_perusahaan,
                                        appraisal.kd_jabatan,
                                        jabatan.nm_jabatan
                            
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
                                    'db' => 'tbl_ap.tahun', 
                                    'dt' => 5,
                            ),
                            array( 
                                    'db' => 'tbl_ap.jan', 
                                    'dt' => 6
                            ),
                            array( 
                                    'db' => 'tbl_ap.feb', 
                                    'dt' => 7
                            ),
                            array( 
                                    'db' => 'tbl_ap.mar', 
                                    'dt' => 8
                            ),
                            array( 
                                    'db' => 'tbl_ap.apr', 
                                    'dt' => 9
                            ),
                            array( 
                                    'db' => 'tbl_ap.may', 
                                    'dt' => 10
                            ),
                            array( 
                                    'db' => 'tbl_ap.jun', 
                                    'dt' => 11
                            ),
                            array( 
                                    'db' => 'tbl_ap.jul', 
                                    'dt' => 12
                            ),
                            array( 
                                    'db' => 'tbl_ap.aug', 
                                    'dt' => 13
                            ),
                            array( 
                                    'db' => 'tbl_ap.sep', 
                                    'dt' => 14
                            ),
                            array( 
                                    'db' => 'tbl_ap.oct', 
                                    'dt' => 15
                            ),
                            array( 
                                    'db' => 'tbl_ap.nov', 
                                    'dt' => 16
                            ),
                            array( 
                                    'db' => 'tbl_ap.dec', 
                                    'dt' => 17
                            )

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
    public function get_list_dept_rekap()
    {
                    $data=decrypt_url($this->uri->segment(4));
                    $data_arr= explode("#", $data);
                    $kd_departemen = "";
                    $bulan = "";
                    $tahun = "";
                    
                    if($data!="" and count($data_arr)>0){
                        
                        $kd_departemen = $data_arr[0];
                        $bulan = $data_arr[1];
                        $tahun = $data_arr[2];
                    }
                    
                    $addsql = array();
                    if($kd_departemen!=""){
                        $addsql[]=" tbl_ap.kd_departemen = '$kd_departemen' ";
                    }
                    if($bulan!=""){
                        $addsql[]=" tbl_ap.bulan = '$bulan' ";
                    }
                    if($tahun!=""){
                        $addsql[]=" tbl_ap.tahun = '$tahun' ";
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
                            (select departemen_result.kd_departemen,
                                        departemen.nm_departemen,
                                        departemen.kd_perusahaan,
                                        departemen_result.tahun,
                                        round(AVG(case when departemen_result.bulan = 1 then departemen_result.score_kpi ELSE 0 END),2)AS jan,
                                        round(AVG(case when departemen_result.bulan = 2 then departemen_result.score_kpi ELSE 0 END),2)AS feb,
                                        round(AVG(case when departemen_result.bulan = 3 then departemen_result.score_kpi ELSE 0 END),2)AS mar,
                                        round(AVG(case when departemen_result.bulan = 4 then departemen_result.score_kpi ELSE 0 END),2)AS apr,
                                        round(AVG(case when departemen_result.bulan = 5 then departemen_result.score_kpi ELSE 0 END),2)AS may,
                                        round(AVG(case when departemen_result.bulan = 6 then departemen_result.score_kpi ELSE 0 END),2)AS jun,
                                        round(AVG(case when departemen_result.bulan = 7 then departemen_result.score_kpi ELSE 0 END),2)AS jul,
                                        round(AVG(case when departemen_result.bulan = 8 then departemen_result.score_kpi ELSE 0 END),2)AS aug,
                                        round(AVG(case when departemen_result.bulan = 9 then departemen_result.score_kpi ELSE 0 END),2)AS sep,
                                        round(AVG(case when departemen_result.bulan = 10 then departemen_result.score_kpi ELSE 0 END),2)AS oct,
                                        round(AVG(case when departemen_result.bulan = 11 then departemen_result.score_kpi ELSE 0 END),2)AS nov,
                                        round(AVG(case when departemen_result.bulan = 12 then departemen_result.score_kpi ELSE 0 END),2)AS `dec`
                                from departemen_result
                                INNER JOIN departemen ON departemen_result.kd_departemen = departemen.kd_departemen
                                group by departemen_result.kd_departemen,
                                        departemen.nm_departemen,
                                        departemen.kd_perusahaan,
                                        departemen_result.tahun
                            ) as tbl_ap
                            
                    ";
                    $primaryKey = 'tbl_ap.kd_departemen';
                    $columns = array(
                            array( 
                                    'NO', 
                                    'dt' => 0 ,
                                    'searchable' => FALSE
                            ),
                            array(
                                    'db' => 'tbl_ap.kd_departemen',
                                    'dt' => 1,
                            ),
                            array( 
                                    'db' => 'tbl_ap.nm_departemen', 
                                    'dt' => 2,
                            ),
                            array( 
                                    'db' => 'tbl_ap.tahun', 
                                    'dt' => 3,
                            ),
                            array( 
                                    'db' => 'tbl_ap.jan', 
                                    'dt' => 4
                            ),
                            array( 
                                    'db' => 'tbl_ap.feb', 
                                    'dt' => 5
                            ),
                            array( 
                                    'db' => 'tbl_ap.mar', 
                                    'dt' => 6
                            ),
                            array( 
                                    'db' => 'tbl_ap.apr', 
                                    'dt' => 7
                            ),
                            array( 
                                    'db' => 'tbl_ap.may', 
                                    'dt' => 8
                            ),
                            array( 
                                    'db' => 'tbl_ap.jun', 
                                    'dt' => 9
                            ),
                            array( 
                                    'db' => 'tbl_ap.jul', 
                                    'dt' => 10
                            ),
                            array( 
                                    'db' => 'tbl_ap.aug', 
                                    'dt' => 11
                            ),
                            array( 
                                    'db' => 'tbl_ap.sep', 
                                    'dt' => 12
                            ),
                            array( 
                                    'db' => 'tbl_ap.oct', 
                                    'dt' => 13
                            ),
                            array( 
                                    'db' => 'tbl_ap.nov', 
                                    'dt' => 14
                            ),
                            array( 
                                    'db' => 'tbl_ap.dec', 
                                    'dt' => 15
                            )

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
    // insert pegawai
    public function search()
    {
        $Data=["success"=>false,"messages"=>array(),"data"=>'','tipe'=>''];
        $this->form_validation->set_rules('tahun', $this->lang->line('tahun'), 'trim|required');
        $this->form_validation->set_rules('report_type', $this->lang->line('report_type'), 'trim|required');
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        
        if ($this->form_validation->run() == FALSE ){
//                echo form_error('kd_bd');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
            }
        }else{
            $kd_departemen = $this->input->post('kd_departemen');
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
            $report_type = $this->input->post('report_type');

            $listData=encrypt_url($kd_departemen."#".$bulan."#".$tahun);
            $Data["success"]=true;
            $Data["data"]=$listData;
            $Data["tipe"]=$report_type;
            $Data["bulan"]=$bulan;
            
        }    
        
        
        echo json_encode($Data);
    }
    protected function _list_report($Status=""){
        $Data['']='';
        $Data['1']=$this->lang->line('report1');
        $Data['2']=$this->lang->line('report2');
        if($Status!=""){
            return $Data[$Status];
        }else{
            return $Data;
        }
    }
}


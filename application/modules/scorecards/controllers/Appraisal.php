<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appraisal extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('scorecards/Appraisal',$siteLang);
            $this->load->model('appraisal_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/scorecards/Appraisal');
            $this->kd_perusahaan = $this->session->userdata('ses_perusahaan');
            $this->ses_nip = $this->session->userdata('ses_nip');
    }
    
    //list appraisal
    public function index()
    {
        $Bln=$this->uri->segment(5);
        $Thn=$this->uri->segment(4);
        if($Thn=="" and $Bln==""){
            $Bln=date("m");
        }
        $Data['DataBulan'] = ($Bln=="")?$Bln= '':$Bln;
        $Data['DataTahun'] = ($Thn=="")?$Thn=date("Y"):$Thn;
        $Data["title_web"]=$this->lang->line('title_web');
        $Data["subheader"]=$this->lang->line('subheader');
        $Data["list_header"]=$this->lang->line('list_header');
        $Data["input_header"]=$this->lang->line('input_header');
        $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
        $Data['AlertInput']=$this->session->flashdata('AlertInput');
        $Data['data_uri']= "scorecards/Appraisal/index";
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
            
        
        //insert user activity
        $this->useractivity->run_acitivity('index '.$this->lang->line('subheader'));
            
        $this->template->temp_default();
        $this->template->add_section('viewjs', 'scorecards/Appraisal_vf/v_Appraisal_js',$Data);
            $this->template->add_section('w_subheader', 'scorecards/Appraisal_vf/v_Appraisal_widget_subheader',$Data);
        $this->load->view('Appraisal_vf/v_Appraisal',$Data);
        //die();
    }
    //get list appraisal json
    public function get_list()
    {
        $Bln=$this->uri->segment(5);
        $Thn=$this->uri->segment(4);
                    $addsql = array();

                    $request = '';
                    $custom_whare="tbl_ap.kd_perusahaan ='$this->kd_perusahaan' and tbl_ap.tahun ='$Thn' ";
                    if($Bln!=""){
                        $custom_whare.= "and tbl_ap.bulan ='$Bln'";
                    }
                    if($this->mion_auth->is_admin()){
//                        $table = " 
//                                (select pegawai.*,departemen.nm_departemen,jabatan.nm_jabatan,data_jml_kpi.jml_data_kpi,
//                                                                pg.nama as report_to_nama,'$Bln' as bulan,'$Thn' as tahun,
//                                                                data_appraisal.kd_appraisal, data_appraisal.status as stat_appraisal
//                                    from pegawai
//                                    left join departemen on departemen.kd_departemen=pegawai.kd_departemen
//                                    left join jabatan on jabatan.kd_jabatan=pegawai.kd_jabatan
//                                    left join pegawai pg on pg.nip=pegawai.report_to
//                                    left join (
//                                                 select kd_appraisal, status, nip from appraisal where bulan = '$Bln' and tahun = '$Thn' and (status = 1 or status is null)
//                                               ) as data_appraisal on pegawai.nip = data_appraisal.nip
//                                    left join (
//                                                 SELECT count(pegawai_kpi.kd_pk) as jml_data_kpi, nip FROM pegawai_kpi group by nip
//                                               ) as data_jml_kpi on pegawai.nip = data_jml_kpi.nip
//                                    where pegawai.nip not in (select nip from appraisal where bulan = '$Bln' and tahun = '$Thn' and (status = 2))
//                                    and pegawai.status = 1) as tbl_ap
//                        ";
                        $table = " 
                                (select pegawai.*,departemen.nm_departemen,jabatan.nm_jabatan,data_jml_kpi.jml_data_kpi,
                                                                pg.nama as report_to_nama,data_appraisal.bulan,data_appraisal.tahun,
                                                                data_appraisal.kd_appraisal, data_appraisal.status as stat_appraisal
                                    from pegawai
                                    left join departemen on departemen.kd_departemen=pegawai.kd_departemen
                                    left join jabatan on jabatan.kd_jabatan=pegawai.kd_jabatan
                                    left join pegawai pg on pg.nip=pegawai.report_to
                                    left join (
                                                 select tbl_appraisal.kd_appraisal,
									tbl_appraisal.status,
									tbl_bulan_pegawai.nip,
									case
										when tbl_appraisal.bulan is null then tbl_bulan_pegawai.bulan
										else tbl_appraisal.bulan
									end as bulan,
									case
										when tbl_appraisal.tahun is null then '$Thn'
										else tbl_appraisal.tahun
									end as tahun
						from (
							select tbl_bulan.bulan,pegawai.nip
							from(SELECT 1 bulan 
								UNION SELECT 2 
								UNION SELECT 3 
								UNION SELECT 4
								UNION SELECT 5
								UNION SELECT 6
								UNION SELECT 7
								UNION SELECT 8
								UNION SELECT 9
								UNION SELECT 10
								UNION SELECT 11
								UNION SELECT 12
							) as tbl_bulan,
							pegawai 
							where pegawai.kd_perusahaan = '$this->kd_perusahaan' and pegawai.`status` = 1
						) tbl_bulan_pegawai
						LEFT JOIN (
							select kd_appraisal, status, nip, bulan,tahun from appraisal where  tahun = '$Thn'
						)tbl_appraisal ON tbl_bulan_pegawai.bulan = tbl_appraisal.bulan and tbl_bulan_pegawai.nip = tbl_appraisal.nip
						where (tbl_appraisal.status = 1 or tbl_appraisal.status is null)
                                               ) as data_appraisal on pegawai.nip = data_appraisal.nip
                                    left join (
                                                 SELECT count(pegawai_kpi.kd_pk) as jml_data_kpi, nip FROM pegawai_kpi group by nip
                                               ) as data_jml_kpi on pegawai.nip = data_jml_kpi.nip
                                    where pegawai.status = 1) as tbl_ap
                        ";
                    }else{
//                        $table = " 
//                            (select pegawai.*,departemen.nm_departemen,jabatan.nm_jabatan,data_jml_kpi.jml_data_kpi,
//                                                            pg.nama as report_to_nama,'$Bln' as bulan,'$Thn' as tahun,
//                                                            data_appraisal.kd_appraisal, data_appraisal.status as stat_appraisal
//                                from pegawai
//                                left join departemen on departemen.kd_departemen=pegawai.kd_departemen
//                                left join jabatan on jabatan.kd_jabatan=pegawai.kd_jabatan
//                                left join pegawai pg on pg.nip=pegawai.report_to
//                                left join (
//                                             select kd_appraisal, status, nip from appraisal where bulan = '$Bln' and tahun = '$Thn' and (status = 1 or status is null)
//                                           ) as data_appraisal on pegawai.nip = data_appraisal.nip
//                                left join (
//                                             SELECT count(pegawai_kpi.kd_pk) as jml_data_kpi, nip FROM pegawai_kpi group by nip
//                                           ) as data_jml_kpi on pegawai.nip = data_jml_kpi.nip
//                                where pegawai.nip not in (select nip from appraisal where bulan = '$Bln' and tahun = '$Thn' and (status = 2))
//                                and pegawai.status = 1 and pegawai.report_to='".$this->session->userdata('login_nip')."') as tbl_ap
//                        ";
                        $table = " 
                                (select pegawai.*,departemen.nm_departemen,jabatan.nm_jabatan,data_jml_kpi.jml_data_kpi,
                                                                pg.nama as report_to_nama,data_appraisal.bulan,data_appraisal.tahun,
                                                                data_appraisal.kd_appraisal, data_appraisal.status as stat_appraisal
                                    from pegawai
                                    left join departemen on departemen.kd_departemen=pegawai.kd_departemen
                                    left join jabatan on jabatan.kd_jabatan=pegawai.kd_jabatan
                                    left join pegawai pg on pg.nip=pegawai.report_to
                                    left join (
                                                 select tbl_appraisal.kd_appraisal,
									tbl_appraisal.status,
									tbl_bulan_pegawai.nip,
									case
										when tbl_appraisal.bulan is null then tbl_bulan_pegawai.bulan
										else tbl_appraisal.bulan
									end as bulan,
									case
										when tbl_appraisal.tahun is null then '$Thn'
										else tbl_appraisal.tahun
									end as tahun
						from (
							select tbl_bulan.bulan,pegawai.nip
							from(SELECT 1 bulan 
								UNION SELECT 2 
								UNION SELECT 3 
								UNION SELECT 4
								UNION SELECT 5
								UNION SELECT 6
								UNION SELECT 7
								UNION SELECT 8
								UNION SELECT 9
								UNION SELECT 10
								UNION SELECT 11
								UNION SELECT 12
							) as tbl_bulan,
							pegawai 
							where pegawai.kd_perusahaan = '$this->kd_perusahaan' and pegawai.`status` = 1
						) tbl_bulan_pegawai
						LEFT JOIN (
							select kd_appraisal, status, nip, bulan,tahun from appraisal where  tahun = '$Thn'
						)tbl_appraisal ON tbl_bulan_pegawai.bulan = tbl_appraisal.bulan and tbl_bulan_pegawai.nip = tbl_appraisal.nip
						where (tbl_appraisal.status = 1 or tbl_appraisal.status is null)
                                               ) as data_appraisal on pegawai.nip = data_appraisal.nip
                                    left join (
                                                 SELECT count(pegawai_kpi.kd_pk) as jml_data_kpi, nip FROM pegawai_kpi group by nip
                                               ) as data_jml_kpi on pegawai.nip = data_jml_kpi.nip
                                    where pegawai.status = 1 and (pegawai.report_to='".$this->session->userdata('login_nip')."' or pegawai.nip='".$this->session->userdata('login_nip')."')) as tbl_ap
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
                                    'db' => 'tbl_ap.kd_appraisal',
                                    'dt' => 1,
                            ),
                            array(
                                    'db' => 'tbl_ap.nip',
                                    'dt' => 2,
                            ),
                            array( 
                                    'db' => 'tbl_ap.nama', 
                                    'dt' => 3,
                                    'default_value' => '',
                                    'formatter' => function( $d, $row ) {
                                                return ucwords(strtolower($d));
                                            }
                            ),
                            array( 
                                    'db' => 'tbl_ap.nm_departemen', 
                                    'dt' => 4,
                            ),
                            array( 
                                    'db' => 'tbl_ap.nm_jabatan', 
                                    'dt' => 5,
                            ),
                            array( 
                                    'db' => 'tbl_ap.report_to_nama', 
                                    'dt' => 6,
                                    'default_value' => '',
                                    'formatter' => function( $d, $row ) {
                                                return ucwords(strtolower($d));
                                            }
                            ),
                            array( 
                                    'db' => 'tbl_ap.bulan', 
                                    'dt' => 7,
                                    'default_value' => '',
                                    'formatter' => function( $d, $row ) {
                                                return getNamaBulan($d);
                                            }
                            ),
                            array( 
                                    'db' => 'tbl_ap.tahun', 
                                    'dt' => 8,
                            ),
                            array( 
                                    'db' => 'tbl_ap.stat_appraisal', 
                                    'dt' => 9,
                                    'default_value' => '',
                                    'formatter' => function( $d, $row ) {
                                                $stat="";
                                                switch ($d){
                                                    case 1: $stat="<span class='m-badge m-badge--success m-badge--wide'>input</span>";break;
                                                    case 2: $stat="<span class='m-badge m-badge--primary m-badge--wide'>Approved</span>";break;
                                                    default : $stat="";
                                                }
                                                return $stat;
                                            }
                            )

                    );

                    $a_condition = array();
                    $a_condition_type = array(); 
                    $a_link = array();
                    $a_src = array();
                    $a_src_change = array();

                            $a_condition['View'] = [9=>"1|2"];
                            $a_link['View'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock_2#"><i class="la la-file-text"></i></a>';
                            $a_src['View'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupView';
                            
                    if($this->mion_auth->is_allowed('add_appraisal')) {
                            $a_condition['input'] = [9=>""];
                            $a_link['input'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock#"><i class="la la-plus"></i></a>';
                            $a_src['input'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupAdd';
                    }        
                    if($this->mion_auth->is_allowed('edit_appraisal')) {
                            $a_condition['edit'] = [9=>"1"];
                            $a_link['edit'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock_2#"><i class="la la-edit"></i></a>';
                            $a_src['edit'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill openPopupEdit';
                    }
                    if($this->mion_auth->is_allowed('delete_appraisal')) { 
                            $a_condition['Delete'] = [9=>"1"];
                            $a_link['Delete'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock_2#"><i class="la la-trash"></i></a>';
                            $a_src['Delete'] = 'm-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-data';
                    }
                    if($this->mion_auth->is_allowed('approve_appraisal')) { 
                            $a_condition['approve'] = [9=>"1",2=>"!".$this->session->userdata('login_nip')];
                            $a_link['approve'] = '<a href="#" class="#link_class#" title="#link_title#" data-id="#action_lock_2#"><i class="la la-check"></i></a>';
                            $a_src['approve'] = 'm-portlet__nav-link btn m-btn m-btn--hover-success m-btn--icon m-btn--icon-only m-btn--pill data-approve';
                    }
                    //add to ajax columns
                    $columns[] = array(
                                    'action',
                                    'searchable' => FALSE,
                                    'dt'=>10,
                                    'condition'=>$a_condition,
                                    'condition_type'=>$a_condition_type,
                                    'action_link'=>$a_link,
                                    'action_src'=>$a_src,
                                    'action_src_change'=>$a_src_change,
                                    'action_lock'=>'nip',
                                    'action_lock_2'=>'kd_appraisal'
                            );

                    // manual ordering at the first page load (server side)
                    if( $_GET['order'][0]['column'] == 0)
                    {
                            $_GET['order'][0]['column'] = '7';
                            $_GET['order'][0]['dir'] = 'asc';
                            $_GET['order'][1]['column'] = '3';
                            $_GET['order'][1]['dir'] = 'asc';
                    }

                    //
                    echo json_encode(
                            SSP::simple( $_GET, $table, $primaryKey, $columns,$custom_whare)
                    );
    }
    // insert appraisal view
    public function insert_form()
    {   
        if($this->mion_auth->is_allowed('add_appraisal')){
            $Data=array();
            $nip=$this->uri->segment(4);
            $tahun=$this->uri->segment(5);
            $bulan=$this->uri->segment(6);
            $Data['DataKpiPegawai'] = $this->appraisal_model->get_pegawai_kpi_by_nip_appraisal($nip,$bulan,$tahun);
            if($Data['DataKpiPegawai']->num_rows()>0){
                $Data['DataBulan']=$bulan;
                $Data['DataTahun']=$tahun;
                $Data['ListType']= ListType();
                $Data['ListUnit']= ListUnit();
                $Data['ListUnitSimbol']= ListUnitSimbol();
                $kd_departemen=$Data['DataKpiPegawai']->row()->kd_departemen;
                $DataKpiDepartemen=$this->appraisal_model->get_departemen_kpi_by_kd_departemen_appraisal($kd_departemen,$tahun);
                $ListKPIDepartemen=array();
                foreach ($DataKpiDepartemen->result() as $row){
                    $ListKPIDepartemen[$row->kd_measurement]=$row->weightage_bd/$row->Tot_bobot_bd;
                    
                }
                $Data["ListKPIDepartemen"]=$ListKPIDepartemen;
//                $Data['ListPeriodAll']= ListPeriodAll();
                $this->load->view('Appraisal_vf/v_Appraisal_input',$Data);
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
    // insert appraisal
    public function save()
    {
            $nip=$this->uri->segment(4);
            $tahun=$this->uri->segment(5);
            $bulan=$this->uri->segment(6);
            
        $Data=["success"=>false,"messages"=>array()];
        $this->form_validation->set_rules('actual[]', $this->lang->line('actual'), 'trim|required');
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        if ($this->form_validation->run() == FALSE ){
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
            }
        }else{
            $bulan=$this->input->post('bulan');
            $tahun=$this->input->post('tahun');
            $actual=$this->input->post('actual');
            $weightage_kpi=$this->input->post('weightage_kpi');
            $weightage_bd=$this->input->post('weightage_bd');
            $weightage_bd_dept=$this->input->post('weightage_bd_dept');
            $kd_measurement=$this->input->post('kd_measurement');
            $target=$this->input->post('target');
            $unit=$this->input->post('unit');
            $period=$this->input->post('period');
            $type=$this->input->post('type');
            $status_calculate=$this->input->post('status_calculate');
            $target_label=$this->input->post('target_label');
            $formula=$this->input->post('formula');
            $kd_appraisal="AP".$tahun.$bulan.$nip;
            $Input=['kd_appraisal'=>$kd_appraisal,
                    'bulan'=>$bulan,
                    'tahun'=>$tahun,
                    'nip'=>$nip,
                    'nip_atasan'=>$this->input->post('report_to'),
                    'kd_jabatan'=>$this->input->post('kd_jabatan'),
                    'kd_departemen'=>$this->input->post('kd_departemen'),
                    'status'=>1,
                    'remark'=>$this->input->post('remark'),
                    'user_input'=>$this->session->userdata('identity'),
                    'tgl_input'=>date("Y-m-d H:i:s")
                    ];
            
            $AppraisalDetail=array();
            $i=1;
            $point=0;
            foreach($kd_measurement as $key=>$val){
                if($target[$key]==0)$target[$key]=1;
                if($status_calculate[$key]==1){
                    if($type[$key]=='min'){
                        if($target[$key]>0){
                            $result=round(($actual[$key]/$target[$key]),4);
                        }else{
                            $result = 0;
                        }
                    }else{
                        // if($actual[$key]>0){
                        //     $result=round(($target[$key]/$actual[$key]),4);
                        // }else{
                        //     $result = 0;
                        // }
                        $result=round(($target[$key]+($target[$key]-$actual[$key]))/$target[$key],4);
                    }
                    $result=$result*100;
                }else{
                    $result = $actual[$key];
                }
                // $point_result=round(($result*4),2);
                // if($point_result > 4){
                //     $point_result = 4.00;
                // }
                $arrFormula=json_decode($formula[$key]);
                // var_dump($formula[$key]);
                $point_result=0;
                foreach($arrFormula as $row){
                    if($point_result==0){
                        $point_result = CekOperator($row->operator,$result,$row->value,$row->score);
                    }else{
                        break;
                    }
                }
                // die();
                // $score_bd=round(($result*$weightage_bd[$key]*$weightage_bd_dept[$key]),4);
                // if($score_bd > $weightage_bd[$key]){
                //     $score_bd = $weightage_bd[$key];
                // }

                $score_kpi=round(($point_result*$weightage_kpi[$key]),4);
                    if($score_kpi > 4){
                        $score_kpi = 4.00;
                    }
                $point=$point+$score_kpi;
                
                $AppraisalDetail[$i]['kd_ad']=$kd_appraisal."-".$i;
                $AppraisalDetail[$i]['kd_appraisal']=$kd_appraisal;
                $AppraisalDetail[$i]['kd_measurement']=$val;
                //$AppraisalDetail[$i]['weightage_bd']=$weightage_bd[$key];
                $AppraisalDetail[$i]['weightage_kpi']=$weightage_kpi[$key];
                //$AppraisalDetail[$i]['weightage_bd_dept']=$weightage_bd_dept[$key];
                $AppraisalDetail[$i]['target']=$target[$key];
                // $AppraisalDetail[$i]['score_bd']=$score_bd;
                $AppraisalDetail[$i]['score_kpi']=$score_kpi;
                $AppraisalDetail[$i]['actual']=$actual[$key];
                $AppraisalDetail[$i]['result']=$result;
                $AppraisalDetail[$i]['point_result']=$point_result;
                $AppraisalDetail[$i]['type']=$type[$key];
                $AppraisalDetail[$i]['unit']=$unit[$key];
                $AppraisalDetail[$i]['period']=$period[$key];
                $AppraisalDetail[$i]['target_label']=$target_label[$key];
                $AppraisalDetail[$i]['status_calculate']=$status_calculate[$key];
                $AppraisalDetail[$i]['formula']=$formula[$key];
                
                // $DataMeasurement=$this->appraisal_model->getDataMeasurementInAppraisal($val);
                // $AppraisalDetail[$i]['aggregation']= ($DataMeasurement)?$DataMeasurement->aggregation:'';
                $i++;
            }
            $Input["point"]=$point;
            $id=$this->appraisal_model->insert_appraisal($Input);
            $this->appraisal_model->insert_appraisal_detail_batch($AppraisalDetail);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
            //insert user activity
            $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),$kd_appraisal,$Input);
            $Data["success"]=true;
        }
        
        echo json_encode($Data);
    }
    // view appraisal view
    public function view_form()
    {
        $Data=array();
        $kd_appraisal=$this->uri->segment(4);
        $Data['DataAppraisal'] = $this->appraisal_model->get_appraisal_detail($kd_appraisal);
        if($Data['DataAppraisal']->num_rows()>0){
//            $Data['DataBulan']=$bulan;
//            $Data['DataTahun']=$tahun;
            $Data['ListType']= ListType();
            $Data['ListUnit']= ListUnit();
            $Data['ListUnitSimbol']= ListUnitSimbol();
            $Data['ListOperator']= ListOperator();
            $Data['ListStatCalculate']= ListStatCalculate();
//            $Data['ListPeriodAll']= ListPeriodAll();
            $this->load->view('Appraisal_vf/v_Appraisal_view',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_found'));
        }
    }
    //edit form appraisal
    public function edit_form()
    {
        if($this->mion_auth->is_allowed('edit_appraisal')){
            $Data=array();
            $kd_appraisal=$this->uri->segment(4);
            $tahun=$this->uri->segment(5);
            $bulan=$this->uri->segment(6);
            $Data['DataAppraisal'] = $this->appraisal_model->get_appraisal_detail($kd_appraisal);
            if($Data['DataAppraisal']->num_rows()>0){
                $nip=$Data['DataAppraisal']->row()->nip;
                $Data['DataKpiPegawai'] = $this->appraisal_model->get_pegawai_kpi_by_nip_appraisal($nip,$bulan,$tahun);
                if($Data['DataKpiPegawai']->num_rows()>0){
                    $Data['DataBulan']=$bulan;
                    $Data['DataTahun']=$tahun;
                    $Data['ListType']= ListType();
                    $Data['ListUnit']= ListUnit();
                    $Data['ListUnitSimbol']= ListUnitSimbol();


                    $kd_departemen=$Data['DataKpiPegawai']->row()->kd_departemen;
                    $DataKpiDepartemen=$this->appraisal_model->get_departemen_kpi_by_kd_departemen_appraisal($kd_departemen,$tahun);
                    $ListKPIDepartemen=array();
                    foreach ($DataKpiDepartemen->result() as $row){
                        $ListKPIDepartemen[$row->kd_measurement]=$row->weightage_bd/$row->Tot_bobot_bd;
                    }
                    $ListKPIAppraisal=array();
                    $remark='';
                    foreach ($Data['DataAppraisal']->result() as $row){
                        $ListKPIAppraisal[$row->kd_measurement]=$row->actual;
                        $remark=$row->remark;
                    }
                    $Data["ListKPIDepartemen"]=$ListKPIDepartemen;
                    $Data["ListKPIAppraisal"]=$ListKPIAppraisal;
                    $Data['remark']=$remark;
    //                $Data['ListPeriodAll']= ListPeriodAll();
                    $this->load->view('Appraisal_vf/v_Appraisal_edit',$Data);
                }
                else
                {
                    echo getAlertError($this->lang->line('not_found'));
                }
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
    // edit appraisal
    public function edit()
    {
        $kd_appraisal=$this->uri->segment(4);
        $tahun=$this->uri->segment(5);
        $bulan=$this->uri->segment(6);
            
        $Data=["success"=>false,"messages"=>array()];
        $DataAppraisal = $this->appraisal_model->get_appraisal_detail($kd_appraisal);
        if($DataAppraisal->num_rows() > 0)
        {
            $this->form_validation->set_rules('actual[]', $this->lang->line('actual'), 'trim|required');
            $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');

            if ($this->form_validation->run() == FALSE ){
                foreach($_POST as $key => $value)
                {
                    $Data['messages'][$key]= form_error($key);
                }
            }else{
                $nip=$this->input->post('nip');
                $bulan=$this->input->post('bulan');
                $tahun=$this->input->post('tahun');
                $actual=$this->input->post('actual');
                $weightage_kpi=$this->input->post('weightage_kpi');
                $weightage_bd=$this->input->post('weightage_bd');
                $weightage_bd_dept=$this->input->post('weightage_bd_dept');
                $kd_measurement=$this->input->post('kd_measurement');
                $target=$this->input->post('target');
                $unit=$this->input->post('unit');
                $period=$this->input->post('period');
                $type=$this->input->post('type');
                $status_calculate=$this->input->post('status_calculate');
                $target_label=$this->input->post('target_label');
                $formula=$this->input->post('formula');
                
                $this->appraisal_model->delete_appraisal($kd_appraisal);
                $kd_appraisalNew="AP".$tahun.$bulan.$nip;
                $Input=['kd_appraisal'=>$kd_appraisalNew,
                        'bulan'=>$bulan,
                        'tahun'=>$tahun,
                        'nip'=>$nip,
                        'nip_atasan'=>$this->input->post('report_to'),
                        'kd_jabatan'=>$this->input->post('kd_jabatan'),
                        'kd_departemen'=>$this->input->post('kd_departemen'),
                        'status'=>1,
                        'remark'=>$this->input->post('remark'),
                        'user_input'=>$this->session->userdata('identity'),
                        'tgl_input'=>date("Y-m-d H:i:s")
                        ];

                $AppraisalDetail=array();
                $i=1;
                $point=0;
                foreach($kd_measurement as $key=>$val){
                    if($target[$key]==0)$target[$key]=1;
                    if($status_calculate[$key]==1){
                        if($type[$key]=='min'){
                            if($target[$key]>0){
                                $result=round(($actual[$key]/$target[$key]),4);
                            }else{
                                $result = 0;
                            }
                        }else{
                            // if($actual[$key]>0){
                            //     $result=round(($target[$key]/$actual[$key]),4);
                            // }else{
                            //     $result = 0;
                            // }
                            $result=round(($target[$key]+($target[$key]-$actual[$key]))/$target[$key],4);
                        }
                        $result=$result*100;
                    }else{
                        $result = $actual[$key];
                    }
                    
                    // $point_result=round(($result*4),2);
                    // if($point_result > 4){
                    //     $point_result = 4.00;
                    // }
                    $arrFormula=json_decode($formula[$key]);
                    // var_dump($formula[$key]);
                    $point_result=0;
                    foreach($arrFormula as $row){
                        if($point_result==0){
                            $point_result = CekOperator($row->operator,$result,$row->value,$row->score);
                        }else{
                            break;
                        }
                    }
                    // $score_bd=round(($result*$weightage_bd[$key]*$weightage_bd_dept[$key]),4);
                    // if($score_bd > $weightage_bd[$key]){
                    //     $score_bd = $weightage_bd[$key];
                    // }
//                    $score_kpi=round(($result*$weightage_kpi[$key]),4);
//                    if($score_kpi > $weightage_kpi[$key]){
//                        $score_kpi = $weightage_kpi[$key];
//                    }
                    $score_kpi=round(($point_result*$weightage_kpi[$key]),4);
                    if($score_kpi > 4){
                        $score_kpi = 4.00;
                    }
                    $point=$point+$score_kpi;
                    
                    $AppraisalDetail[$i]['kd_ad']=$kd_appraisalNew."-".$i;
                    $AppraisalDetail[$i]['kd_appraisal']=$kd_appraisalNew;
                    $AppraisalDetail[$i]['kd_measurement']=$val;
                    //$AppraisalDetail[$i]['weightage_bd']=$weightage_bd[$key];
                    $AppraisalDetail[$i]['weightage_kpi']=$weightage_kpi[$key];
                    //$AppraisalDetail[$i]['weightage_bd_dept']=$weightage_bd_dept[$key];
                    $AppraisalDetail[$i]['target']=$target[$key];
                    // $AppraisalDetail[$i]['score_bd']=$score_bd;
                    $AppraisalDetail[$i]['score_kpi']=$score_kpi;
                    $AppraisalDetail[$i]['actual']=$actual[$key];
                    $AppraisalDetail[$i]['result']=$result;
                    $AppraisalDetail[$i]['point_result']=$point_result;
                    $AppraisalDetail[$i]['type']=$type[$key];
                    $AppraisalDetail[$i]['unit']=$unit[$key];
                    $AppraisalDetail[$i]['period']=$period[$key];
                    $AppraisalDetail[$i]['target_label']=$target_label[$key];
                    $AppraisalDetail[$i]['status_calculate']=$status_calculate[$key];
                    $AppraisalDetail[$i]['formula']=$formula[$key];
                    // $DataMeasurement=$this->appraisal_model->getDataMeasurementInAppraisal($val);
                    // $AppraisalDetail[$i]['aggregation']= ($DataMeasurement)?$DataMeasurement->aggregation:'';
                    $i++;
                }
                $Input["point"]=$point;
//            var_dump($AppraisalDetail);
//            die();
                $id=$this->appraisal_model->insert_appraisal($Input);
                $this->appraisal_model->insert_appraisal_detail_batch($AppraisalDetail);
                
                $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_edit'));
                //insert user activity
                $this->useractivity->run_acitivity('edit '.$this->lang->line('subheader'),$kd_appraisalNew,$Input);
                $Data["success"]=true;
            }
        }
            echo json_encode($Data);
    }
    //delete appraisal
    public function delete(){
        if($this->mion_auth->is_allowed('delete_appraisal')){
            $DataDelete=$this->uri->segment(4);
            //get history data
            $DataAppraisal = $this->appraisal_model->get_appraisal_by_code($DataDelete);
            //delete data
            $this->appraisal_model->delete_appraisal($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataAppraisal->row_array());
        }

    }
    public function Proses_complete_form(){
        $Kode=$this->uri->segment(4);
        $Tahun=$this->uri->segment(5);
        $Bulan=$this->uri->segment(6);
//        var_dump($DataDelete);
        //$Data=["success"=>true,"messages"=>array()];
        $this->useractivity->run_acitivity('Process complete form '.$this->lang->line('subheader'),$Kode);
        $Input=['status'=>2,
                'approved_by'=>$this->session->userdata('login_nama'),
                'nip_approver'=>$this->session->userdata('login_nip')
            ];
        $this->appraisal_model ->update_appraisal($Kode,$Input);
        $this->appraisal_model ->proses_input_result($Bulan,$Tahun,$this->kd_perusahaan);
        //$this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
        //redirect('appraisal/Appraisal');
        //echo json_encode($Data);

    }
}


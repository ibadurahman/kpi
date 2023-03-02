<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DashboardPeg extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->_init();
                $siteLang = $this->session->userdata('site_lang');
                $this->lang->load('dashboard/Dashboard_peg',$siteLang);
                $this->load->model('ion_auth_model');
                $this->mion_auth->restrict('akses/Login');
                $this->kd_perusahaan = $this->session->userdata('ses_perusahaan');
	}

	private function _init()
	{
            $this->template->temp_default();
            //$this->breadcrumbs->push('Appraisal', '/appraisal/Appraisal');
	}

	public function index()
	{
            $this->load->model('dashboard_peg_model');
            $Bln=$this->uri->segment(6);
            $Thn=$this->uri->segment(5);
            $nip=$this->uri->segment(4);
            if($Thn=="" and $Bln==""){
                $Bln=date("m");
            }
            $this->ion_auth_model->login_remembered_user();
            $Data['DataBulan'] = ($Bln=="")?$Bln= '':$Bln;
            $Data['DataTahun'] = ($Thn=="")?date("Y"):$Thn;
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader');
            $Data['data_uri']= "dashboard/DashboardPeg/index/".$nip;
            
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
            
            $Data['ListKelamin'] = $this->_list_kelamin();
            $Data['ListStatus'] = $this->_list_status();
            $Data['ListType']= ListType();
            $Data['ListUnit']= ListUnit();
            $Data['ListUnitSimbol']= ListUnitSimbol();
            $Data['ListOperator']= ListOperator();
            $Data['ListStatCalculate']= ListStatCalculate();
            
            $Data['DataPegawai']=$this->dashboard_peg_model->get_profil_pegawai_dashboard($nip,$Data['DataTahun'],$Data['DataBulan']);
            $kd_dept='';
            if($Data['DataPegawai']->num_rows()>0){
                foreach($Data['DataPegawai']->result() as $row)
                {
                    $ScoreBln=$row->score_bulan;
                    $ScoreThn=$row->score_tahun;
                    $kd_dept=$row->kd_departemen;
                }
            }
            $this->breadcrumbs->push('Dashboard Department', '/dashboard/DashboardDept/index/'.$Data['DataTahun']."/".$Data['DataBulan']);
            $this->breadcrumbs->push('Department Detail', '/dashboard/DashboardDept/dept/'.$kd_dept."/".$Data['DataTahun']."/".$Data['DataBulan']);
            $this->breadcrumbs->push('Dashboard Employee', '/dashboard/DashboardPeg/index/'.$nip."/".$Data['DataTahun']."/".$Data['DataBulan']);
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            if($Bln!=""){
                $Data['line_chart']=$this->dashboard_peg_model->get_peg_kpi_rekap_setahun_linechart($nip,$Data['DataTahun'],$Data['DataBulan']);
                $Data['detail_kpi']=$this->dashboard_peg_model->get_peg_kpi_perbulan($nip,$Data['DataTahun'],$Data['DataBulan']);
                $Data['gauge_chart']= $ScoreBln;
            }else{
                $Data['line_chart']=$this->dashboard_peg_model->get_peg_kpi_rekap_pertahun_linechart($nip,$Data['DataTahun'],$Data['DataBulan']);
                $Data['detail_kpi_thn']=$this->dashboard_peg_model->get_peg_kpi_pertahun($nip,$Data['DataTahun']);
                $Data['gauge_chart']= $ScoreThn;
            }
            //insert user activity
            $this->useractivity->run_acitivity($this->lang->line('subheader'));
            $this->template->add_section('viewjs', 'dashboard/dashboard_peg_vf/v_dashboard_peg_js',$Data);
            $this->template->add_section('w_subheader', 'dashboard/dashboard_peg_vf/v_dashboard_peg_widget_subheader');
            $this->load->view('dashboard_peg_vf/v_dashboard_peg',$Data);
	}
        
	public function dept()
	{
            $this->load->model('dashboard_peg_model');
            $Bln=$this->uri->segment(6);
            $Thn=$this->uri->segment(5);
            $kd_dept=$this->uri->segment(4);
            if($Thn=="" and $Bln==""){
                $Bln=date("m");
            }
            $this->ion_auth_model->login_remembered_user();
            $Data['DataBulan'] = ($Bln=="")?$Bln= '':$Bln;
            $Data['DataTahun'] = ($Thn=="")?date("Y"):$Thn;
            $this->breadcrumbs->push('Dashboard Department', '/dashboard/DashboardPeg/index/'.$Data['DataTahun']."/".$Data['DataBulan']);
            $this->breadcrumbs->push('Department Detail', '/dashboard/DashboardPeg/dept/'.$kd_dept.'/'.$Data['DataTahun']."/".$Data['DataBulan']);
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader');
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['data_uri']= "dashboard/DashboardPeg/index";
            
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
            
            $Data['ListType']= ListType();
            $Data['ListUnit']= ListUnit();
            $Data['ListUnitSimbol']= ListUnitSimbol();
            
//            $DataPerusahaan= $this->dashboard_model->get_perusahaan_by_code_dashboard($this->kd_perusahaan);
//            $Data['logo']='';
//            if($DataPerusahaan->num_rows()>0){
//                $Data['logo']=$DataPerusahaan->row()->logo;
//            }
            if($Bln!=""){
                //$Data['radar_dept']=$this->dashboard_peg_model->get_dept_radar_chart_perbulan($this->kd_perusahaan,$Data['DataTahun'],$Data['DataBulan']);
                $Data['line_dept']=$this->dashboard_peg_model->get_dept_kpi_rekap_setahun_linechart($this->kd_perusahaan,$Data['DataTahun'],$kd_dept);
                $DeptKpiDetail=$this->dashboard_peg_model->get_dept_kpi_detail_perbulan($this->kd_perusahaan,$Data['DataTahun'],$Data['DataBulan'],$kd_dept);
                $DeptKpiPegawai=$this->dashboard_peg_model->get_pegawai_kpi_dept_perbulan($kd_dept,$Data['DataTahun'],$Data['DataBulan']);
            }else{
                //$Data['radar_perspective']=$this->dashboard_model->get_perspective_radar_chart_tahun($this->kd_perusahaan,$Data['DataTahun']);
                //$Data['line_perspective']=$this->dashboard_model->get_perspective_bar_chart_tahun($this->kd_perusahaan,$Data['DataTahun']);
            }
            $DeptTemp="";
            if($DeptKpiDetail->num_rows()>0){
                $i=0;
                $a=0;
                $Data['data_kpi']=$DeptKpiDetail;
                foreach($DeptKpiDetail->result() as $row){
                    if($DeptTemp !=$row->kd_departemen ){
                        $DeptTemp=$row->kd_departemen;
                        $Data['DetailKPIDept']['kd_departemen']= $row->kd_departemen;
                        $Data['DetailKPIDept']['nm_departemen']= $row->nm_departemen;
                        $Data['DetailKPIDept']['kpi']= $row->kpi_dept;
                        $i++;
                    }
                    $listBobot= explode(",", $row->weightage_kpi);
                    $ArrBobot=array();
                    //var_dump($listBobot);
                    foreach($listBobot as $val){
                        $cal=$val*100;
                        $ArrBobot[$val]=$cal."%";
                    }
                    $bobot= implode(", ", $ArrBobot);
                    $Data['DetailKPIDept']['detail'][$a]['nm_measurement']= $row->nm_measurement;
                    $Data['DetailKPIDept']['detail'][$a]['gross_kpi']= $row->gross_result;
                    $Data['DetailKPIDept']['detail'][$a]['bobot_kpi']= $bobot;
                    $Data['DetailKPIDept']['detail'][$a]['score_kpi']= $row->score_kpi;
                    $a++;
                }
                
            }
            if($DeptKpiPegawai->num_rows()>0){
                $i=0;
                $a=0;
                foreach($DeptKpiPegawai->result() as $row){
                    $Data['PegawaiKPIDept'][$row->kd_departemen][$row->kd_measurement][$row->nip]['nip']= $row->nip;
                    $Data['PegawaiKPIDept'][$row->kd_departemen][$row->kd_measurement][$row->nip]['nama']= $row->nama;
                    $Data['PegawaiKPIDept'][$row->kd_departemen][$row->kd_measurement][$row->nip]['jabatan']= $row->nm_jabatan;
                    $Data['PegawaiKPIDept'][$row->kd_departemen][$row->kd_measurement][$row->nip]['gross_kpi']= $row->gross_result;
                    $Data['PegawaiKPIDept'][$row->kd_departemen][$row->kd_measurement][$row->nip]['bobot_kpi']= $row->weightage_bd;
                    $Data['PegawaiKPIDept'][$row->kd_departemen][$row->kd_measurement][$row->nip]['score_kpi']= $row->score_result;
                    $a++;
                }
                
            }
            //insert user activity
            $this->useractivity->run_acitivity($this->lang->line('subheader'));
            $this->template->add_section('viewjs', 'dashboard/dashboard_dept_d_vf/v_dashboard_dept_d_js',$Data);
            $this->template->add_section('w_subheader', 'dashboard/dashboard_dept_d_vf/v_dashboard_dept_d_widget_subheader');
            $this->load->view('dashboard_dept_d_vf/v_dashboard_dept_d',$Data);
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
}

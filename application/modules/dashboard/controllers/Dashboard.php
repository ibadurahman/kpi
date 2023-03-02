<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->_init();
                $siteLang = $this->session->userdata('site_lang');
                $this->lang->load('dashboard/Dashboard',$siteLang);
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
            $this->load->model('dashboard_model');
            $Bln=$this->uri->segment(5);
            $Thn=$this->uri->segment(4);
            if($Thn=="" and $Bln==""){
                $Bln=date("m");
            }
            $this->ion_auth_model->login_remembered_user();
            $Data['DataBulan'] = ($Bln=="")?$Bln= '':$Bln;
            $Data['DataTahun'] = ($Thn=="")?date("Y"):$Thn;
            $this->breadcrumbs->push('Dashboard', '/dashboard/Dashboard/index/'.$Data['DataTahun']."/".$Data['DataBulan']);
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader');
            $Data["header_modal"]=$this->lang->line('select_perusahaan');
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['data_uri']= "dashboard/Dashboard/index";
            
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
            
            
            $DataPerusahaan= $this->dashboard_model->get_perusahaan_by_code_dashboard($this->kd_perusahaan);
            $Data['logo']='';
            if($DataPerusahaan->num_rows()>0){
                $Data['logo']=$DataPerusahaan->row()->logo;
            }
            if($Bln!=""){
                $Data['data_perspective']=$this->dashboard_model->dashboard_perspective_bulanan($this->kd_perusahaan,$Data['DataTahun'],$Data['DataBulan']);
                $Data['chart_company']=$this->dashboard_model->get_list_score_perusahaan_tahunan_chart($this->kd_perusahaan,$Data['DataTahun'],$Data['DataBulan']);
                $Data['radar_perspective']=$this->dashboard_model->get_perspective_radar_chart_bulan($this->kd_perusahaan,$Data['DataTahun'],$Data['DataBulan']);
                $Data['line_perspective']=$this->dashboard_model->get_perspective_bar_chart_bulan($this->kd_perusahaan,$Data['DataBulan'],$Data['DataTahun']);
            }else{
                $Data['data_perspective']=$this->dashboard_model->dashboard_perspective_tahunan($this->kd_perusahaan,$Data['DataTahun']);
                $Data['chart_company']=$this->dashboard_model->get_list_score_perusahaan_chart_pertahun($this->kd_perusahaan,$Data['DataTahun']);
                $Data['radar_perspective']=$this->dashboard_model->get_perspective_radar_chart_tahun($this->kd_perusahaan,$Data['DataTahun']);
                $Data['line_perspective']=$this->dashboard_model->get_perspective_bar_chart_tahun($this->kd_perusahaan,$Data['DataTahun']);
            }
            $ScorePerusahaan=0;
            if($Data['data_perspective']->num_rows()>0){
                
                foreach($Data['data_perspective']->result() as $row){
                    $ScorePerusahaan=$ScorePerusahaan+$row->point;
                }
            }
            $Data['score_perusahaan']=$ScorePerusahaan;
//            $Data['list_top10']=$this->dashboard_model->get_top_score($this->kd_perusahaan,$Data['DataBulan'],$Data['DataTahun']);
//            $Data['list_bottom10']=$this->dashboard_model->get_bottom_score($this->kd_perusahaan,$Data['DataBulan'],$Data['DataTahun']);
            
            //insert user activity
            $this->useractivity->run_acitivity($this->lang->line('subheader'));
            $this->template->add_section('viewjs', 'dashboard/dashboard_vf/v_dashboard_js',$Data);
            $this->template->add_section('w_subheader', 'dashboard/dashboard_vf/v_dashboard_widget_subheader');
            $this->load->view('dashboard_vf/v_dashboard',$Data);
	}
        public function DashboardPerspective()
	{
            $this->load->model('dashboard_perspective_model');
            $Bln=$this->uri->segment(6);
            $Thn=$this->uri->segment(5);
            $KdPerspective=$this->uri->segment(4);
            if($Thn=="" and $Bln==""){
                $Bln=date("m");
            }
            $this->ion_auth_model->login_remembered_user();
            $Data['DataBulan'] = ($Bln=="")?$Bln= '':$Bln;
            $Data['DataTahun'] = ($Thn=="")?date("Y"):$Thn;
            $this->breadcrumbs->push('Dashboard', '/dashboard/Dashboard/index/'.$Data['DataTahun']."/".$Data['DataBulan']);
            $this->breadcrumbs->push($this->lang->line('subheader')." Perspective", '/dashboard/Dashboard/DashboardPerspective/'.$KdPerspective."/".$Data['DataTahun']."/".$Data['DataBulan']);
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader')." Perspective";
            $Data["header_modal"]=$this->lang->line('select_perusahaan');
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['data_uri']= "dashboard/Dashboard/DashboardPerspective/".$KdPerspective;
            
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
            
            
            
            if($Bln!=""){
                $DataPerspective= $this->dashboard_perspective_model->get_perspective_by_code_bulanan($KdPerspective,$Data['DataTahun'],$Data['DataBulan']);
                $Data['data_bd']=$this->dashboard_perspective_model->dashboard_bd_bulanan($KdPerspective,$Data['DataTahun'],$Data['DataBulan']);
                $Data['chart_ps']=$this->dashboard_perspective_model->get_list_score_ps_rekap_setahun_chart($KdPerspective,$Data['DataTahun'],$Data['DataBulan']);
            }else{
                $DataPerspective= $this->dashboard_perspective_model->get_perspective_by_code_tahunan($KdPerspective,$Data['DataTahun']);
                $Data['data_bd']=$this->dashboard_perspective_model->dashboard_bd_tahunan($KdPerspective,$Data['DataTahun']);
                $Data['chart_ps']=$this->dashboard_perspective_model->get_list_score_ps_tahunan_chart($KdPerspective,$Data['DataTahun']);
            }
            $Data['nm_perspective']='';
            $Data['score_perspective']=0;
            if($DataPerspective->num_rows()>0){
                $Data['kd_perspective']=$DataPerspective->row()->kd_perspective;
                $Data['nm_perspective']=$DataPerspective->row()->nm_perspective;
                $Data['score_perspective']=$DataPerspective->row()->point_result;
            }
//            $Data['list_top10']=$this->dashboard_model->get_top_score($this->kd_perusahaan,$Data['DataBulan'],$Data['DataTahun']);
//            $Data['list_bottom10']=$this->dashboard_model->get_bottom_score($this->kd_perusahaan,$Data['DataBulan'],$Data['DataTahun']);
            
            //insert user activity
            $this->useractivity->run_acitivity($this->lang->line('subheader'));
            $this->template->add_section('viewjs', 'dashboard/dashboard_ps_vf/v_dashboard_ps_js',$Data);
            $this->template->add_section('w_subheader', 'dashboard/dashboard_ps_vf/v_dashboard_ps_widget_subheader');
            $this->load->view('dashboard_ps_vf/v_dashboard_ps',$Data);
	}
        public function DashboardBd()
	{
            $this->load->model('dashboard_bd_model');
            $Bln=$this->uri->segment(6);
            $Thn=$this->uri->segment(5);
            $Kode=decrypt_url($this->uri->segment(4));
            $Kode_arr= explode("|", $Kode);
            $KdPerspective=$Kode_arr[0];
            $KdBd=$Kode_arr[1];
            if($Thn=="" and $Bln==""){
                $Bln=date("m");
            }
            $this->ion_auth_model->login_remembered_user();
            $Data['DataBulan'] = ($Bln=="")?$Bln= '':$Bln;
            $Data['DataTahun'] = ($Thn=="")?date("Y"):$Thn;
            $this->breadcrumbs->push('Dashboard', '/dashboard/Dashboard/index/'.$Data['DataTahun']."/".$Data['DataBulan']);
            $this->breadcrumbs->push($this->lang->line('subheader')." Perspective", '/dashboard/Dashboard/DashboardPerspective/'.$KdPerspective."/".$Data['DataTahun']."/".$Data['DataBulan']);
            $this->breadcrumbs->push("Business Driver", '/dashboard/Dashboard/DashboardBd/'.$KdBd."/".$Data['DataTahun']."/".$Data['DataBulan']);
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader')." Business Driver";
            $Data["header_modal"]=$this->lang->line('select_perusahaan');
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['data_uri']= "dashboard/Dashboard/DashboardBd/". encrypt_url($Kode);
            
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
            
            
            if($Bln!=""){
                $DataBd= $this->dashboard_bd_model->get_bd_by_code_bulanan($KdBd,$Data['DataTahun'],$Data['DataBulan']);
                $Data['data_ms']=$this->dashboard_bd_model->dashboard_ms_bulanan($KdBd,$Data['DataTahun'],$Data['DataBulan']);
                $Data['chart_bd']=$this->dashboard_bd_model->get_list_score_bd_rekap_setahun_chart($KdBd,$Data['DataTahun'],$Data['DataBulan']);
            }else{
                $DataBd= $this->dashboard_bd_model->get_bd_by_code_tahunan($KdBd,$Data['DataTahun']);
                $Data['data_ms']=$this->dashboard_bd_model->dashboard_ms_tahunan($KdBd,$Data['DataTahun']);
                $Data['chart_bd']=$this->dashboard_bd_model->get_list_score_bd_tahunan_chart($KdBd,$Data['DataTahun']);
            }
            $Data['nm_bd']='';
            $Data['score_bd']=0;
            if($DataBd->num_rows()>0){
                $Data['kd_perspective']=$KdPerspective;
                $Data['kd_bd']=$DataBd->row()->kd_bd;
                $Data['nm_bd']=$DataBd->row()->nm_bd;
                $Data['score_bd']=$DataBd->row()->point_result;
            }
//            $Data['list_top10']=$this->dashboard_model->get_top_score($this->kd_perusahaan,$Data['DataBulan'],$Data['DataTahun']);
//            $Data['list_bottom10']=$this->dashboard_model->get_bottom_score($this->kd_perusahaan,$Data['DataBulan'],$Data['DataTahun']);
            
            //insert user activity
            $this->useractivity->run_acitivity($this->lang->line('subheader')." Business Driver");
            $this->template->add_section('viewjs', 'dashboard/dashboard_bd_vf/v_dashboard_bd_js',$Data);
            $this->template->add_section('w_subheader', 'dashboard/dashboard_bd_vf/v_dashboard_bd_widget_subheader');
            $this->load->view('dashboard_bd_vf/v_dashboard_bd',$Data);
	}
        public function DashboardMs()
	{
            $this->load->model('dashboard_ms_model');
            $Bln=$this->uri->segment(6);
            $Thn=$this->uri->segment(5);
            $Kode=decrypt_url($this->uri->segment(4));
            $Kode_arr= explode("|", $Kode);
            $KdPerspective=$Kode_arr[0];
            $KdBd=$Kode_arr[0]."|".$Kode_arr[1];
            $KdMs=$Kode_arr[2];
            if($Thn=="" and $Bln==""){
                $Bln=date("m");
            }
            $this->ion_auth_model->login_remembered_user();
            $Data['DataBulan'] = ($Bln=="")?$Bln= '':$Bln;
            $Data['DataTahun'] = ($Thn=="")?date("Y"):$Thn;
            $this->breadcrumbs->push('Dashboard', '/dashboard/Dashboard/index/'.$Data['DataTahun']."/".$Data['DataBulan']);
            $this->breadcrumbs->push($this->lang->line('subheader')." Perspective", '/dashboard/Dashboard/DashboardPerspective/'.$KdPerspective."/".$Data['DataTahun']."/".$Data['DataBulan']);
            $this->breadcrumbs->push("Business Driver", '/dashboard/Dashboard/DashboardBd/'.encrypt_url($KdBd)."/".$Data['DataTahun']."/".$Data['DataBulan']);
            $this->breadcrumbs->push("Measurement", '/dashboard/Dashboard/DashboardMs/'.encrypt_url($Kode)."/".$Data['DataTahun']."/".$Data['DataBulan']);
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader')." Measurement";
            //$Data["header_modal"]=$this->lang->line('select_perusahaan');
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['data_uri']= "dashboard/Dashboard/DashboardMs/". encrypt_url($Kode);
            
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
            
            
            if($Bln!=""){
                $DataMs= $this->dashboard_ms_model->get_ms_by_code_bulanan($KdMs,$Data['DataTahun'],$Data['DataBulan']);
                // $Data['data_dept']=$this->dashboard_ms_model->dashboard_dept_bulanan($KdMs,$Data['DataTahun'],$Data['DataBulan']);
                $Data['data_peg']=$this->dashboard_ms_model->dashboard_list_peg_bulanan($KdMs,$Data['DataTahun'],$Data['DataBulan']);
                $Data['chart_ms']=$this->dashboard_ms_model->get_list_score_ms_rekap_setahun_chart($KdMs,$Data['DataTahun'],$Data['DataBulan']);
            }else{
                $DataMs= $this->dashboard_ms_model->get_ms_by_code_tahunan($KdMs,$Data['DataTahun']);
                // $Data['data_dept']=$this->dashboard_ms_model->dashboard_dept_tahunan($KdMs,$Data['DataTahun']);
                $Data['data_peg']=$this->dashboard_ms_model->dashboard_list_peg_tahunan($KdMs,$Data['DataTahun']);
                $Data['chart_ms']=$this->dashboard_ms_model->get_list_score_ms_tahunan_chart($KdMs,$Data['DataTahun']);
            }
            $Data['nm_measurement']='';
            $Data['score_ms']=0;
            if($DataMs->num_rows()>0){
                $Data['kd_perspective']=$KdPerspective;
                $Data['kd_bd']=$Kode_arr[1];
                $Data['kd_measurement']=$DataMs->row()->kd_measurement;
                $Data['nm_measurement']=$DataMs->row()->nm_measurement;
                $Data['score_ms']=$DataMs->row()->point_result;
            }
//            $Data['list_top10']=$this->dashboard_model->get_top_score($this->kd_perusahaan,$Data['DataBulan'],$Data['DataTahun']);
//            $Data['list_bottom10']=$this->dashboard_model->get_bottom_score($this->kd_perusahaan,$Data['DataBulan'],$Data['DataTahun']);
            
            //insert user activity
            $this->useractivity->run_acitivity($this->lang->line('subheader')." Measurement");
            $this->template->add_section('viewjs', 'dashboard/dashboard_ms_vf/v_dashboard_ms_js',$Data);
            $this->template->add_section('w_subheader', 'dashboard/dashboard_ms_vf/v_dashboard_ms_widget_subheader');
            $this->load->view('dashboard_ms_vf/v_dashboard_ms',$Data);
	}
}

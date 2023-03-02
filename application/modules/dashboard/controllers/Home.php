<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->_init();
                $siteLang = $this->session->userdata('site_lang');
                $this->lang->load('dashboard/Home',$siteLang);
                $this->load->model('home_model');
                $this->load->model('ion_auth_model');
                $this->mion_auth->restrict('akses/Login');
                $this->kd_perusahaan = $this->session->userdata('ses_perusahaan');
	}

	private function _init()
	{
            $this->template->temp_default();
            $this->breadcrumbs->push('Home', '/dashboard/Home');
            //$this->breadcrumbs->push('Appraisal', '/appraisal/Appraisal');
	}

	public function index()
	{
            $Bln=$this->uri->segment(5);
            $Thn=$this->uri->segment(4);
            if($Thn=="" and $Bln==""){
                $Bln=date("m");
            }
            $DataGroup= $this->ion_auth_model->get_users_groups($this->session->userdata('user_id'));
            $IdGroup="";
            $NmGroup="";
            foreach($DataGroup->result() as $row){
                $IdGroup=$row->id;
                $NmGroup=$row->name;
            }
            if($IdGroup!=1 and $IdGroup!=6){
                redirect('dashboard/Home/index_peg');
            }
            $this->ion_auth_model->login_remembered_user();
            $Data['DataBulan'] = ($Bln=="")?$Bln= '':$Bln;
            $Data['DataTahun'] = ($Thn=="")?date("Y"):$Thn;
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader');
            $Data["header_modal"]=$this->lang->line('select_perusahaan');
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['data_uri']= "dashboard/Home/index";
            
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
            
            
            $DataPerusahaan= $this->home_model->get_perusahaan_by_code_home($this->kd_perusahaan);
            $Data['logo']='';
            if($DataPerusahaan->num_rows()>0){
                $Data['logo']=$DataPerusahaan->row()->logo;
            }
            $Data['tot_pegawai']=0;
            $Data['tot_pegawai_baru']=0;
            $Data['tot_pegawai_keluar']=0;
            $DataJmlPegawai= $this->home_model->get_jml_pegawai($this->kd_perusahaan,$Data['DataTahun']);
            if($DataJmlPegawai->num_rows()>0){
                $RowJmlPegawai=$DataJmlPegawai->row();
                $Data['tot_pegawai']=$RowJmlPegawai->total;
                $Data['tot_pegawai_baru']=$RowJmlPegawai->tot_masuk;
                $Data['tot_pegawai_keluar']=$RowJmlPegawai->tot_keluar;
            }
            
            
            $Data['list_top10']=$this->home_model->get_top_score($this->kd_perusahaan,$Data['DataBulan'],$Data['DataTahun']);
            $Data['list_bottom10']=$this->home_model->get_bottom_score($this->kd_perusahaan,$Data['DataBulan'],$Data['DataTahun']);
            if($Bln!=""){
                $Data['radar_perspective']=$this->home_model->get_perspective_result_chart($this->kd_perusahaan,$Data['DataTahun'],$Data['DataBulan']);
                $Data['line_perspective']=$this->home_model->get_perspective_result_chart_monthly($this->kd_perusahaan,$Data['DataBulan'],$Data['DataTahun']);
            }else{
                $Data['radar_perspective']=$this->home_model->get_perspective_result_radar_yearly($this->kd_perusahaan,$Data['DataTahun']);
                $Data['line_perspective']=$this->home_model->get_perspective_result_chart_yearly($this->kd_perusahaan,$Data['DataTahun']);
            }
			if($Data['DataBulan']==''){
				$BlnSebelumnya=0-1;
			}else{
				$BlnSebelumnya=$Data['DataBulan']-1;
			}
            $ThnSebelumnya=$Data['DataTahun'];
            if($BlnSebelumnya<=0){
                $BlnSebelumnya=12;
                $ThnSebelumnya=$ThnSebelumnya-1;
            }
            $this->_getReminder($BlnSebelumnya, $ThnSebelumnya);
            //insert user activity
            $this->useractivity->run_acitivity($this->lang->line('subheader'));
            $this->template->add_section('viewjs', 'dashboard/home_vf/v_home_js',$Data);
            $this->template->add_section('w_subheader', 'dashboard/home_vf/v_widget_subheader');
	$this->load->view('home_vf/v_home',$Data);
	}
    public function index_peg()
	{       
        $this->load->model('organisasi/pegawai_model');
        
        $Bln=$this->uri->segment(5);
        $Thn=$this->uri->segment(4);
        if($Thn=="" and $Bln==""){
            $Bln=date("m");
        }
        $LoginNIP=$this->session->userdata('login_nip');
        if($LoginNIP=="" or $LoginNIP=="AD001"){
            $LoginNIP='92';
        }
        $DataPegawai = $this->pegawai_model->get_pegawai_by_code($LoginNIP);
        if($DataPegawai->num_rows() > 0)
        {
            $this->ion_auth_model->login_remembered_user();
            $Data['DataBulan'] = ($Bln=="")?$Bln= '':$Bln;
            $Data['DataTahun'] = ($Thn=="")?date("Y"):$Thn;
            $Data["title_web"]=$this->lang->line('title_web');
            $Data["subheader"]=$this->lang->line('subheader');
            $Data["header_modal"]=$this->lang->line('select_perusahaan');
            $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
            $Data['data_uri']= "dashboard/Home/index_peg";
            
            $Data['DataKpiPegawai'] = $this->pegawai_model->get_pegawai_kpi_by_nip($LoginNIP,$Thn);
            $Data['HistoryKPI']=$this->pegawai_model->get_pegawai_kpi_header_by_nip($LoginNIP,$Thn);
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
            $Data['ListStatAppraisal'] = $this->_list_status_appraisal();
            $Data['ListSubordinate']=$this->home_model->get_subordinate($this->kd_perusahaan,$LoginNIP,$Data['DataTahun'],$Data['DataBulan']);
            $DataResult=$this->pegawai_model->get_appraisal_nip_monthly($LoginNIP,$Data['DataBulan'],$Data['DataTahun']);
            $Data['GaugePegawai']=0;
            if($DataResult->num_rows()>0){
                $Data['GaugePegawai']=number_format($DataResult->row()->point,2);
            }
            $Data['HistoryPegawai']=$this->pegawai_model->get_appraisal_history_nip($LoginNIP,$Data['DataBulan'],$Data['DataTahun']);
            $Data['ChartPegawai']=$this->pegawai_model->get_appraisal_chart_monthly_nip($LoginNIP,$Data['DataBulan'],$Data['DataTahun']);

			if($Data['DataBulan']==''){
				$BlnSebelumnya=0-1;
			}else{
				$BlnSebelumnya=$Data['DataBulan']-1;
			}
            $ThnSebelumnya=$Data['DataTahun'];
            if($BlnSebelumnya<=0){
                $BlnSebelumnya=12;
                $ThnSebelumnya=$ThnSebelumnya-1;
            }
            $this->_getReminder($BlnSebelumnya, $ThnSebelumnya);
            //insert user activity
            $this->useractivity->run_acitivity($this->lang->line('subheader'));
            $this->template->add_section('viewjs', 'dashboard/home_vf/v_home_pegawai_js',$Data);
            $this->template->add_section('w_subheader', 'dashboard/home_vf/v_widget_subheader');
	        $this->load->view('home_vf/v_home_pegawai',$Data);
        }
        else
        {
            $Data['text_error']=$this->lang->line('not_found');
            $this->template->temp_default();
            $this->template->add_section('t_alert', 'alert_error',$Data);
        }
	}    
         // pilih perusahaan
    public function pilih_perusahaan()
    {
        $this->template->unset_template();
        $Data=["success"=>false,"messages"=>array(),"kode"=>''];
        $this->form_validation->set_rules('kd_perusahaan', $this->lang->line('kd_perusahaan'), 'trim|required');
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        if ($this->form_validation->run() == FALSE ){
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
            }
        }else{
            $kode=$this->input->post('kd_perusahaan');
            $Data["success"]=true;
            $Data["kode"]=$kode;
        }
        
        echo json_encode($Data);
    }
    private function _getReminder($bln,$thn){
            $this->home_model->insert_notifikasi_appraisal($bln,$thn,$this->lang->line('notifikasi_appraisal'));
    }
    
    public function update_notifikasi(){
        $Data=["success"=>false,"messages"=>array(),"data"=>array()];
        $kd_notifikasi=$this->uri->segment(4);
        if($this->session->userdata('login_nip')!=""){
            $data_update=['status'=>1];
        }else{
            $data_update=['status_admin'=>1];
        }
        $DataDepartemen = $this->home_model->update_notifikasi_home($kd_notifikasi,$data_update);
        $Data["success"]=TRUE;
        
        return $Data;
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
    protected function _list_status_appraisal($Status=""){
        $Data['']='unprocessed';
        $Data['1']='need approval';
        $Data['2']='approved';
        if($Status!=""){
            return $Data[$Status];
        }else{
            return $Data;
        }
    }
}

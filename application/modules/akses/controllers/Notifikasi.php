<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifikasi extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('akses/Notifikasi',$siteLang);
            $this->load->model('notifikasi_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/akses/Notifikasi');
            $this->Upload_Path = realpath(APPPATH."../assets/upload/foto_notifikasi");
    }
    
    //list notifikasi
    public function index()
    {
        $Data["title_web"]=$this->lang->line('title_web');
        $Data["subheader"]=$this->lang->line('subheader');
        $Data["list_header"]=$this->lang->line('list_header');
        $Data['breadcrumbs']=$this->breadcrumbs->show_custom();
        $Data['AlertInput']=$this->session->flashdata('AlertInput');
        if($this->session->userdata('login_nip')!=""){
            $data_update=['status'=>1];
            $this->notifikasi_model->update_notifikasi_nip($this->session->userdata('login_nip'),$data_update);
        }else{
            $this->notifikasi_model->update_notifikasi_admin();
        }
        
        //insert notifikasi activity
        $this->useractivity->run_acitivity('view notifikasi',$this->session->userdata('login_nip'));

        $this->template->temp_default();
        $this->template->add_section('viewjs', 'akses/Notifikasi_vf/v_Notifikasi_js');
        $this->load->view('Notifikasi_vf/v_Notifikasi',$Data);
           
    }
    // view departemen view
    public function list_notifikasi()
    {
        $Start=$this->uri->segment(4);
        $End=$this->uri->segment(5);
        //echo date("Y-m-d H:i:s",1574357355);
        $DataNotifikasi = $this->notifikasi_model->get_notifikasi_Tgl($Start,$End,$this->session->userdata('login_nip'));
        if($DataNotifikasi->num_rows() > 0)
        {
            //insert notifikasi activity
           // $this->notifikasiactivity->run_acitivity('view '.$this->lang->line('subheader'),$Kode);
            $Data['DataNotifikasi']= $DataNotifikasi;
            $this->load->view('Notifikasi_vf/v_Notifikasi_list',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_found'));
        }
//        1574382555
//        1574355600
    }
}


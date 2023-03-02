<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ReportIndividual extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('report/ReportIndividual',$siteLang);
            $this->load->model('report_individual_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/report/ReportIndividual');
            $this->kd_perusahaan = $this->session->userdata('ses_perusahaan');
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
        
        
        $LTahun=ListTahunBerjalan($this->config->item('year_apps'));
        unset($LTahun['']);
        krsort($LTahun);
        $Data['ListTahun']= $LTahun;
        $LBulan=ListBulan();
        //unset($LBulan['']);
        $Data['ListBulan']= $LBulan;
            
        //insert user activity
        $this->useractivity->run_acitivity('index '.$this->lang->line('subheader'));
        $this->template->temp_default();
        $this->template->add_section('viewjs', 'report/ReportIndividual_vf/v_ReportIndividual_js');
        $this->template->add_section('viewcss', 'report/ReportIndividual_vf/v_ReportIndividual_css');
        $this->load->view('ReportIndividual_vf/v_ReportIndividual',$Data);
    }
    
    // insert pegawai
    public function search()
    {
        $Data=["success"=>false,"messages"=>array(),"data"=>''];
        $this->form_validation->set_rules('tahun', $this->lang->line('tahun'), 'trim|required');
        $this->form_validation->set_rules('bulan', $this->lang->line('bulan'), 'trim|required');
        $this->form_validation->set_rules('nip', $this->lang->line('nama'), 'trim|required');
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        
        if ($this->form_validation->run() == FALSE ){
//                echo form_error('nip');
//                var_dump($_POST);
            foreach($_POST as $key => $value)
            {
                $Data['messages'][$key]= form_error($key);
                if($this->input->post('nip')==""){
                    $Data['messages']['nip']= form_error("nip");
                }
            }
//            var_dump($Data);
        }else{
            $nip = $this->input->post('nip');
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');

            $listData= encrypt_url($nip."#".$bulan."#".$tahun);
            $Data["success"]=true;
            $Data["data"]=$listData;
            
        }    
        
        
        echo json_encode($Data);
    }
    // view appraisal view
    public function view_form()
    {
        $Data=array();
        $data= decrypt_url($this->uri->segment(4));
        $data_arr= explode("#", $data);
        $Data['DataAppraisal'] = $this->report_individual_model->get_appraisal_detail_report_individual($data_arr[0],$data_arr[1],$data_arr[2]);
        if($Data['DataAppraisal']->num_rows()>0){
            
            $Data['ListType']= ListType();
            $Data['ListUnit']= ListUnit();
            $Data['ListUnitSimbol']= ListUnitSimbol();
            $Data['ListOperator']= ListOperator();
            $Data['ListStatCalculate']= ListStatCalculate();
            $this->load->view('ReportIndividual_vf/v_ReportIndividual_view',$Data);
        }
        else
        {
            echo getAlertError($this->lang->line('not_found'));
        }
    }
    public  function SearchAutocompletePegawai(){
        $keyword = $_GET['term'];
        //$page = $_GET['page'];
//            $query=$this->member_model->get_All_Member('','',$DataSearch);
            $query=$this->report_individual_model->get_pegawai_search($this->kd_perusahaan,$keyword,$this->mion_auth->is_admin());
            if($query->num_rows()>0){
            foreach($query->result() as $row){
                $data[] =$row;
            }
            
            die(json_encode($data)); 
            }
    }
    
    public function cetak_kpi_pegawai_Pdf(){
//        ini_set('max_execution_time', 500); //300 seconds = 5 minutes
//        ini_set('memory_limit', '512m');
        
        $this->load->library('pdf');
        
        $data= decrypt_url($this->uri->segment(4));
        $data_arr= explode("#", $data);
        $DataAppraisal = $this->report_individual_model->get_appraisal_detail_report_individual($data_arr[0],$data_arr[1],$data_arr[2]);
        $Data['DataAppraisal']=$DataAppraisal;
            $Data['ListType']= ListType();
            $Data['ListUnit']= ListUnit();
            $Data['ListUnitSimbol']= ListUnitSimbol();
            $Data['ListOperator']= ListOperator();
            $Data['ListStatCalculate']= ListStatCalculate();
        if($DataAppraisal->num_rows()>0){
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor($this->session->userdata('identity'));
            $pdf->SetTitle($this->lang->line('cetak_title'));
            $pdf->SetSubject($this->lang->line('cetak_title'));
            // remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(10, 10, 5);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            // set font
            $pdf->SetFont('dejavusans', '', 9);
            $pdf->AddPage('P');



            $DataHtml=$this->load->view('ReportIndividual_vf/v_ReportIndividual_print',$Data,TRUE);
           
            $pdf->writeHTML($DataHtml, true, false, true, false, '');
            
            // reset pointer to the last page
            $pdf->lastPage();

            //Close and output PDF document
            $pdf->Output($this->lang->line('cetak_title').'.pdf', 'I');
        }else{
            echo "Data Tidak Tersedia";
        }
    }
}


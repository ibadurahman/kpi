<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ReportMeasurement extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('report/ReportMeasurement',$siteLang);
            $this->load->model('report_measurement_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/report/ReportMeasurement');
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
        
        $this->form_validation->set_rules('tahun', $this->lang->line('tahun'), 'trim|required');
        $this->form_validation->set_rules('bulan', $this->lang->line('bulan'), 'trim|required');
        $this->form_validation->set_rules('report_type', $this->lang->line('report_type'), 'trim|required');
        $this->form_validation->set_error_delimiters(' <div class="form-control-feedback text-error">', '</div>');
        
        
        if ($this->form_validation->run() == FALSE ){
//        $DataPerusahaan=$this->report_pegawai_model->get_perusahaan_all_report_pegawai($this->kd_perusahaan);
//        $Data['ListPerusahaan']=  get_value_array($DataPerusahaan,'kd_perusahaan','nm_perusahaan',TRUE);

            $DataDepartemen=$this->report_measurement_model->get_departemen_all_report_measurement($this->kd_perusahaan);
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
            $this->template->add_section('viewjs', 'report/ReportMeasurement_vf/v_ReportMeasurement_js');
            $this->load->view('ReportMeasurement_vf/v_ReportMeasurement',$Data);
        }else{
            $kd_departemen = $this->input->post('kd_departemen');
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
            $report_type = $this->input->post('report_type');
            $nip = $this->input->post('nip');
            
//            echo $report_type;
//            die();
            if($report_type==1){
                $this->get_report_measurement_employee($bulan,$tahun,$nip,$kd_departemen);
            }else if($report_type==2){
                $this->get_report_measurement_departemen($bulan,$tahun,$kd_departemen);
            }else if($report_type==3){
                $this->get_report_measurement_departemen_detail($bulan,$tahun,$kd_departemen);
            }else if($report_type==4){
                $this->get_report_measurement_company($bulan,$tahun);
            }else if($report_type==5){
                $this->get_report_measurement_company_detail($bulan,$tahun,$kd_departemen);
            }
        }
    }
    
    public function get_report_measurement_employee($bulan,$tahun,$nip,$kd_departemen){
        //load our new PHPExcel library
        $this->load->library('excel');
        //die();
        $ListUnit= ListUnit();
        $ListUnitSimbol= ListUnitSimbol();
        $ListPeriodAll= ListPeriodAll();
        $ListType= ListType();
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($this->lang->line('subheader'));
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', $this->lang->line('subheader'));
        $this->excel->getActiveSheet()->setCellValue('A2', getNamaBulan($bulan)." ".$tahun);
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        //merge cell A1 until D1
        $this->excel->getActiveSheet()->mergeCells('A1:O1');
        $this->excel->getActiveSheet()->mergeCells('A2:O2');
        //set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,4, 'No')
                              ->setCellValueByColumnAndRow(1,4, $this->lang->line('nip'))
                              ->setCellValueByColumnAndRow(2,4, $this->lang->line('nama'))
                              ->setCellValueByColumnAndRow(3,4, $this->lang->line('nm_departemen'))
                              ->setCellValueByColumnAndRow(4,4, $this->lang->line('kd_jabatan'))
                              ->setCellValueByColumnAndRow(5,4, $this->lang->line('report_to'))
                              ->setCellValueByColumnAndRow(6,4, $this->lang->line('bulan'))
                              ->setCellValueByColumnAndRow(7,4, $this->lang->line('tahun'))
                              ->setCellValueByColumnAndRow(8,4, $this->lang->line('nm_measurement'))
                              ->setCellValueByColumnAndRow(9,4, $this->lang->line('period'))
                              ->setCellValueByColumnAndRow(10,4, $this->lang->line('unit'))
                              ->setCellValueByColumnAndRow(11,4, $this->lang->line('type'))
                              ->setCellValueByColumnAndRow(12,4, $this->lang->line('target'))
                              ->setCellValueByColumnAndRow(13,4, $this->lang->line('actual'))
                              ->setCellValueByColumnAndRow(14,4, $this->lang->line('result')."(%)");
 
        $All_data=$this->report_measurement_model->get_pegawai_measurement_aktual($this->kd_perusahaan,$bulan,$tahun,$nip,$kd_departemen);
        $No=5;
        $NoUrut=1;
        $nip_temp='';
        foreach ($All_data->result() as $row){
            $result=round(($row->result*100),2);
            if($row->nip!=$nip_temp){
                $nip_temp=$row->nip;
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$No, $NoUrut);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$No,$row->nip);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2,$No,$row->nama);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3,$No,$row->nm_departemen);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4,$No,$row->nm_jabatan);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5,$No,$row->nm_atasan);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6,$No,getNamaBulan($row->bulan));
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7,$No,$row->tahun);
                $NoUrut++;
            }
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8,$No,$row->nm_measurement);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9,$No,$ListPeriodAll[$row->period]);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(10,$No,$ListUnit[$row->unit]);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(11,$No,$ListType[$row->type]);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(12,$No,$row->target);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(13,$No,$row->actual);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(14,$No,$result);
            $No++;
        }
        
        $filename='MeasurementReport'.'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        ob_end_clean();	
        $objWriter->save('php://output');
    }
    public function get_report_measurement_departemen($bulan,$tahun,$kd_departemen){
        //load our new PHPExcel library
        $this->load->library('excel');
        
        $ListUnit= ListUnit();
        $ListUnitSimbol= ListUnitSimbol();
        $ListPeriodAll= ListPeriodAll();
        $ListType= ListType();
        $All_data=$this->report_measurement_model->get_departemen_measurement_aktual($this->kd_perusahaan,$bulan,$tahun,$kd_departemen);
        $NmDept="ALL";
        if($kd_departemen!=""){
           $NmDept= $All_data->row()->nm_departemen;
        }
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($this->lang->line('subheader'));
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', $this->lang->line('subheader'));
        $this->excel->getActiveSheet()->setCellValue('A2', $NmDept." ".$this->lang->line('title_dept'));
        $this->excel->getActiveSheet()->setCellValue('A3', getNamaBulan($bulan)." ".$tahun);
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
        $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(20);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        //merge cell A1 until D1
        $this->excel->getActiveSheet()->mergeCells('A1:K1');
        $this->excel->getActiveSheet()->mergeCells('A2:K2');
        $this->excel->getActiveSheet()->mergeCells('A3:K3');
        //set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,5, 'No')
                              ->setCellValueByColumnAndRow(1,5, $this->lang->line('nm_departemen'))
                              ->setCellValueByColumnAndRow(2,5, $this->lang->line('bulan'))
                              ->setCellValueByColumnAndRow(3,5, $this->lang->line('tahun'))
                              ->setCellValueByColumnAndRow(4,5, $this->lang->line('nm_measurement'))
                              ->setCellValueByColumnAndRow(5,5, $this->lang->line('period'))
                              ->setCellValueByColumnAndRow(6,5, $this->lang->line('unit'))
                              ->setCellValueByColumnAndRow(7,5, $this->lang->line('type'))
                              ->setCellValueByColumnAndRow(8,5, $this->lang->line('target'))
                              ->setCellValueByColumnAndRow(9,5, $this->lang->line('actual'))
                              ->setCellValueByColumnAndRow(10,5, $this->lang->line('result')."(%)");
 
        
        $No=6;
        $NoUrut=1;
        $d_temp='';
        foreach ($All_data->result() as $row){
            $result=round(($row->result*100),2);
            if($row->kd_departemen!=$d_temp){
                $d_temp=$row->kd_departemen;
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$No, $NoUrut);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$No,$row->nm_departemen);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2,$No,getNamaBulan($row->bulan));
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3,$No,$row->tahun);
                $NoUrut++;
            }
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4,$No,$row->nm_measurement);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5,$No,$ListPeriodAll[$row->period]);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6,$No,$ListUnit[$row->unit]);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7,$No,$ListType[$row->type]);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8,$No,$row->target);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9,$No,$row->actual);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(10,$No,$result);
            $No++;
        }
        
        $filename='MeasurementReport'.'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        ob_end_clean();	
        $objWriter->save('php://output');
    }
    public function get_report_measurement_departemen_detail($bulan,$tahun,$kd_departemen){
        //load our new PHPExcel library
        $this->load->library('excel');
        
        $ListUnit= ListUnit();
        $ListUnitSimbol= ListUnitSimbol();
        $ListPeriodAll= ListPeriodAll();
        $ListType= ListType();
        $nip="";
        $All_data=$this->report_measurement_model->get_departemen_measurement_aktual($this->kd_perusahaan,$bulan,$tahun,$kd_departemen);
        $peg_result=$this->report_measurement_model->get_pegawai_measurement_aktual_arr($this->kd_perusahaan,$bulan,$tahun,$nip,$kd_departemen);
        $NmDept="ALL";
        if($kd_departemen!=""){
           $NmDept= $All_data->row()->nm_departemen;
        }
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($this->lang->line('subheader'));
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', $this->lang->line('subheader'));
        $this->excel->getActiveSheet()->setCellValue('A2', $NmDept." ".$this->lang->line('title_dept')." Detail");
        $this->excel->getActiveSheet()->setCellValue('A3', getNamaBulan($bulan)." ".$tahun);
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
        $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(20);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        //merge cell A1 until D1
        $this->excel->getActiveSheet()->mergeCells('A1:K1');
        $this->excel->getActiveSheet()->mergeCells('A2:K2');
        $this->excel->getActiveSheet()->mergeCells('A3:K3');
        //set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,5, 'No')
                              ->setCellValueByColumnAndRow(1,5, $this->lang->line('nm_departemen'))
                              ->setCellValueByColumnAndRow(2,5, $this->lang->line('bulan'))
                              ->setCellValueByColumnAndRow(3,5, $this->lang->line('tahun'))
                              ->setCellValueByColumnAndRow(4,5, $this->lang->line('nm_measurement'))
                              ->setCellValueByColumnAndRow(5,5, $this->lang->line('period'))
                              ->setCellValueByColumnAndRow(6,5, $this->lang->line('unit'))
                              ->setCellValueByColumnAndRow(7,5, $this->lang->line('type'))
                              ->setCellValueByColumnAndRow(8,5, $this->lang->line('nip'))
                              ->setCellValueByColumnAndRow(9,5, $this->lang->line('nama'))
                              ->setCellValueByColumnAndRow(10,5, $this->lang->line('target'))
                              ->setCellValueByColumnAndRow(11,5, $this->lang->line('actual'))
                              ->setCellValueByColumnAndRow(12,5, $this->lang->line('result')."(%)");
 
        
        $No=6;
        $NoUrut=1;
        $d_temp='';
        foreach ($All_data->result() as $row){
            $result=round(($row->result*100),2);
            if($row->kd_departemen!=$d_temp){
                $d_temp=$row->kd_departemen;
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$No, $NoUrut);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$No,$row->nm_departemen);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2,$No,getNamaBulan($row->bulan));
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3,$No,$row->tahun);
                $NoUrut++;
            }
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4,$No,$row->nm_measurement);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5,$No,$ListPeriodAll[$row->period]);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6,$No,$ListUnit[$row->unit]);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7,$No,$ListType[$row->type]);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(10,$No,$row->target);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(11,$No,$row->actual);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(12,$No,$result);
            $No++;
            if(isset($peg_result[$row->kd_measurement][$row->kd_departemen])){
                foreach($peg_result[$row->kd_measurement][$row->kd_departemen] as $key=>$val){
                    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8,$No,$val['nip']);
                    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9,$No,$val['nama']);
                    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(10,$No,$val['target']);
                    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(11,$No,$val['actual']);
                    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(12,$No,$val['result']);
                    $No++;
                }
            }
        }
        
        $filename='MeasurementReport'.'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        ob_end_clean();	
        $objWriter->save('php://output');
    }
    public function get_report_measurement_company($bulan,$tahun){
        //load our new PHPExcel library
        $this->load->library('excel');
        
        $ListUnit= ListUnit();
        $ListUnitSimbol= ListUnitSimbol();
        $ListPeriodAll= ListPeriodAll();
        $ListType= ListType();
        $All_data=$this->report_measurement_model->get_measurement_aktual($this->kd_perusahaan,$bulan,$tahun);
        $nm_perusahaan="";
        if($All_data->num_rows()>0){
            $nm_perusahaan=$All_data->row()->nm_perusahaan;
        }
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($this->lang->line('subheader'));
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', $this->lang->line('subheader'));
        $this->excel->getActiveSheet()->setCellValue('A2', $nm_perusahaan);
        $this->excel->getActiveSheet()->setCellValue('A3', getNamaBulan($bulan)." ".$tahun);
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
        $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(20);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        //merge cell A1 until D1
        $this->excel->getActiveSheet()->mergeCells('A1:K1');
        $this->excel->getActiveSheet()->mergeCells('A2:K2');
        $this->excel->getActiveSheet()->mergeCells('A3:K3');
        //set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,5, 'No')
                              ->setCellValueByColumnAndRow(1,5, $this->lang->line('nm_bd'))
                              ->setCellValueByColumnAndRow(2,5, $this->lang->line('nm_measurement'))
                              ->setCellValueByColumnAndRow(3,5, $this->lang->line('bulan'))
                              ->setCellValueByColumnAndRow(4,5, $this->lang->line('tahun'))
                              ->setCellValueByColumnAndRow(5,5, $this->lang->line('period'))
                              ->setCellValueByColumnAndRow(6,5, $this->lang->line('unit'))
                              ->setCellValueByColumnAndRow(7,5, $this->lang->line('type'))
                              ->setCellValueByColumnAndRow(8,5, $this->lang->line('target'))
                              ->setCellValueByColumnAndRow(9,5, $this->lang->line('actual'))
                              ->setCellValueByColumnAndRow(10,5, $this->lang->line('result')."(%)");
 
        
        $No=6;
        $NoUrut=1;
        $d_temp='';
        $d_temp2='';
        foreach ($All_data->result() as $row){
            $result=round(($row->result*100),2);
            if($row->kd_bd!=$d_temp){
                $d_temp=$row->kd_bd;
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$No, $NoUrut);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$No,$row->nm_bd);
                $NoUrut++;
            }
            if($row->kd_measurement!=$d_temp2){
                $d_temp2=$row->kd_measurement;
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2,$No,$row->nm_measurement);
            }
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3,$No,getNamaBulan($row->bulan));
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4,$No,$row->tahun);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5,$No,$ListPeriodAll[$row->period]);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6,$No,$ListUnit[$row->unit]);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7,$No,$ListType[$row->type]);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8,$No,$row->target);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9,$No,$row->actual);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(10,$No,$result);
            $No++;
        }
        
        $filename='MeasurementReport'.'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        ob_end_clean();	
        $objWriter->save('php://output');
    }
    
    public function get_report_measurement_company_detail($bulan,$tahun,$kd_departemen){
        //load our new PHPExcel library
        $this->load->library('excel');
        
        $ListUnit= ListUnit();
        $ListUnitSimbol= ListUnitSimbol();
        $ListPeriodAll= ListPeriodAll();
        $ListType= ListType();
        $nip="";
        $All_data=$this->report_measurement_model->get_measurement_aktual($this->kd_perusahaan,$bulan,$tahun);
        $dept_result=$this->report_measurement_model->get_departemen_measurement_aktual_arr($this->kd_perusahaan,$bulan,$tahun,$kd_departemen);
        $nm_perusahaan="";
        if($All_data->num_rows()>0){
            $nm_perusahaan=$All_data->row()->nm_perusahaan;
        }
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($this->lang->line('subheader'));
        //set cell A1 content with some text
        $this->excel->getActiveSheet()->setCellValue('A1', $this->lang->line('subheader'));
        $this->excel->getActiveSheet()->setCellValue('A2', $nm_perusahaan);
        $this->excel->getActiveSheet()->setCellValue('A3', getNamaBulan($bulan)." ".$tahun);
        //change the font size
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
        $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(20);
        //make the font become bold
        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
        $this->excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
        //merge cell A1 until D1
        $this->excel->getActiveSheet()->mergeCells('A1:K1');
        $this->excel->getActiveSheet()->mergeCells('A2:K2');
        $this->excel->getActiveSheet()->mergeCells('A3:K3');
        //set aligment to center for that merged cell (A1 to D1)
        $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,5, 'No')
                              ->setCellValueByColumnAndRow(1,5, $this->lang->line('nm_bd'))
                              ->setCellValueByColumnAndRow(2,5, $this->lang->line('nm_measurement'))
                              ->setCellValueByColumnAndRow(3,5, $this->lang->line('bulan'))
                              ->setCellValueByColumnAndRow(4,5, $this->lang->line('tahun'))
                              ->setCellValueByColumnAndRow(5,5, $this->lang->line('period'))
                              ->setCellValueByColumnAndRow(6,5, $this->lang->line('unit'))
                              ->setCellValueByColumnAndRow(7,5, $this->lang->line('type'))
                              ->setCellValueByColumnAndRow(8,5, $this->lang->line('nm_departemen'))
                              ->setCellValueByColumnAndRow(9,5, $this->lang->line('target'))
                              ->setCellValueByColumnAndRow(10,5, $this->lang->line('actual'))
                              ->setCellValueByColumnAndRow(11,5, $this->lang->line('result')."(%)");
 
        
        $No=6;
        $NoUrut=1;
        $d_temp='';
        $d_temp2='';
        foreach ($All_data->result() as $row){
            $result=round(($row->result*100),2);
            if($row->kd_bd!=$d_temp){
                $d_temp=$row->kd_bd;
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$No, $NoUrut);
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1,$No,$row->nm_bd);
                $NoUrut++;
            }
            if($row->kd_measurement!=$d_temp2){
                $d_temp2=$row->kd_measurement;
                $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2,$No,$row->nm_measurement);
            }
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3,$No,getNamaBulan($row->bulan));
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4,$No,$row->tahun);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5,$No,$ListPeriodAll[$row->period]);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6,$No,$ListUnit[$row->unit]);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7,$No,$ListType[$row->type]);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9,$No,$row->target);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(10,$No,$row->actual);
            $this->excel->getActiveSheet()->setCellValueByColumnAndRow(11,$No,$result);
            $No++;
            if(isset($dept_result[$row->kd_measurement])){
                foreach($dept_result[$row->kd_measurement] as $key=>$val){
                    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8,$No,$val['nm_departemen']);
                    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9,$No,$val['target']);
                    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(10,$No,$val['actual']);
                    $this->excel->getActiveSheet()->setCellValueByColumnAndRow(11,$No,$val['result']);
                    $No++;
                }
            }
        }
        
        $filename='MeasurementReport'.'.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

        //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        //if you want to save it as .XLSX Excel 2007 format
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        //force user to download the Excel file without writing it to server's HD
        ob_end_clean();	
        $objWriter->save('php://output');
    }
    protected function _list_report($Status=""){
        $Data['']='';
        $Data['1']=$this->lang->line('report1');
        $Data['2']=$this->lang->line('report2');
        $Data['3']=$this->lang->line('report3');
        $Data['4']=$this->lang->line('report4');
        $Data['5']=$this->lang->line('report5');
        if($Status!=""){
            return $Data[$Status];
        }else{
            return $Data;
        }
    }
    public  function SearchAutocompletePegawai(){
        $keyword = $_GET['term'];
        //$page = $_GET['page'];
//            $query=$this->member_model->get_All_Member('','',$DataSearch);
            $query=$this->report_measurement_model->get_pegawai_search_report_measurement($this->kd_perusahaan,$keyword);
            if($query->num_rows()>0){
            foreach($query->result() as $row){
                $data[] =$row;
            }
            
            die(json_encode($data)); 
            }
    }
}


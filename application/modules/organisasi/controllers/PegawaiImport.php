<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PegawaiImport extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();

            $this->mion_auth->restrict('akses/Login');
            //$this->template->set_js([base_url("assets/metronic/assets/demo/default/custom/components/base/treeview.js")]);
            $siteLang = $this->session->userdata('site_lang');
            $this->lang->load('organisasi/PegawaiImport',$siteLang);
            $this->load->model('pegawai_import_model');
            $this->breadcrumbs->push($this->lang->line('subheader'), '/organisasi/PegawaiImport');
            $this->kd_perusahaan = $this->session->userdata('ses_perusahaan');
            $this->Upload_Path = realpath(APPPATH."../assets/upload/pegawai_import");
    }
    
    //list appraisal
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
        $this->template->add_section('viewjs', 'organisasi/PegawaiImport_vf/v_PegawaiImport_js',$Data);
        $this->load->view('PegawaiImport_vf/v_PegawaiImport',$Data);
        //die();
    }
    public function Pegawai_Format_Import_Excel(){
        //load our new PHPExcel library
        $this->load->library('excel');
        
        //activate worksheet number 1
        $this->excel->setActiveSheetIndex(0);
        //name the worksheet
        $this->excel->getActiveSheet()->setTitle($this->lang->line('subheader'));
        //set cell A1 content with some text
        //$this->excel->getActiveSheet()->setCellValue('A1', $this->lang->line('lap_title'));
        //change the font size
        //$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        //make the font become bold
        //$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        //merge cell A1 until D1
        //$this->excel->getActiveSheet()->mergeCells('A1:D1');
        //set aligment to center for that merged cell (A1 to D1)
        //$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,1, 'No')
                              ->setCellValueByColumnAndRow(1,1, $this->lang->line('nip'))
                              ->setCellValueByColumnAndRow(2,1, $this->lang->line('nama'))
                              ->setCellValueByColumnAndRow(3,1, $this->lang->line('tgl_masuk'))
                              ->setCellValueByColumnAndRow(4,1, $this->lang->line('dob'))
                              ->setCellValueByColumnAndRow(5,1, $this->lang->line('tgl_keluar'))
                              ->setCellValueByColumnAndRow(6,1, $this->lang->line('kd_perusahaan'))
                              ->setCellValueByColumnAndRow(7,1, $this->lang->line('kd_departemen'))
                              ->setCellValueByColumnAndRow(8,1, $this->lang->line('kd_jabatan'))
                              ->setCellValueByColumnAndRow(9,1, $this->lang->line('report_to'))
                              ->setCellValueByColumnAndRow(10,1, $this->lang->line('status'))
                              ->setCellValueByColumnAndRow(11,1, $this->lang->line('jenis_kelamin'));
        
//        $this->excel->getActiveSheet()->mergeCellsByColumnAndRow(0, 1, 0, 2);
//        $this->excel->getActiveSheet()->mergeCellsByColumnAndRow(1, 1, 1, 2);
//        $this->excel->getActiveSheet()->mergeCellsByColumnAndRow(2, 1, 2, 2);
        $NoUrutKomponen=18;
        $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,2, '1')
                              ->setCellValueByColumnAndRow(1,2, '55572001002')
                              ->setCellValueByColumnAndRow(2,2, 'Andre')
                              ->setCellValueByColumnAndRow(3,2, '2019-02-01 (format: yyyy-mm-dd)')
                              ->setCellValueByColumnAndRow(4,2, '1999-02-01 (format: yyyy-mm-dd)')
                              ->setCellValueByColumnAndRow(5,2, '2020-02-01 (format: yyyy-mm-dd)')
                              ->setCellValueByColumnAndRow(6,2, $this->kd_perusahaan." (note: code from company sheet)")
                              ->setCellValueByColumnAndRow(7,2, '1 (note: code from departement sheet)')
                              ->setCellValueByColumnAndRow(8,2, '1 (note: code from role job sheet)')
                              ->setCellValueByColumnAndRow(9,2, '55572001002 (note: employee ID)')
                              ->setCellValueByColumnAndRow(10,2, '1 (note: 1=active, 2=resign)')
                              ->setCellValueByColumnAndRow(11,2, 'L/P');
        
        //ADD SHEET DATA Perusahaan
        $this->excel->createSheet(1)->setTitle($this->lang->line('kd_perusahaan'));
        $this->excel->setActiveSheetIndex(1);
        $this->excel->getActiveSheet()->setCellValue('A1', $this->lang->line('kd_perusahaan_perush'))
                              ->setCellValue('B1', $this->lang->line('nm_perusahaan_perush'));
        $No = 2;
        $All_data=$this->pegawai_import_model->get_perusahaan_all_pegawai_import($this->kd_perusahaan);
        
        foreach ($All_data->result() as $row){
            
            $this->excel->getActiveSheet()
                        ->setCellValue('A'.$No, $row->kd_perusahaan)
                        ->setCellValue('B'.$No, $row->nm_perusahaan);
            $No++;
        }
        
        //ADD SHEET DATA DEPARTEMEN
        $this->excel->createSheet(2)->setTitle($this->lang->line('kd_departemen'));
        $this->excel->setActiveSheetIndex(2);
        $this->excel->getActiveSheet()->setCellValue('A1', $this->lang->line('kd_departemen_dept'))
                              ->setCellValue('B1', $this->lang->line('nm_departemen_dept'));
        $No = 2;
        $All_data=$this->pegawai_import_model->get_departemen_all_pegawai_import($this->kd_perusahaan);
        
        foreach ($All_data->result() as $row){
            
            $this->excel->getActiveSheet()
                        ->setCellValue('A'.$No, $row->kd_departemen)
                        ->setCellValue('B'.$No, $row->nm_departemen);
            $No++;
        }
        
        //ADD SHEET DATA JABATAN
        $this->excel->createSheet(3)->setTitle($this->lang->line('kd_jabatan'));
        $this->excel->setActiveSheetIndex(3);
        $this->excel->getActiveSheet()->setCellValue('A1', $this->lang->line('kd_jabatan_jab'))
                              ->setCellValue('B1', $this->lang->line('nm_jabatan_jab'));
        $No = 2;
        $All_data=$this->pegawai_import_model->get_jabatan_all_pegawai_import($this->kd_perusahaan);
        
        foreach ($All_data->result() as $row){
            
            $this->excel->getActiveSheet()
                        ->setCellValue('A'.$No, $row->kd_jabatan)
                        ->setCellValue('B'.$No, $row->nm_jabatan);
            $No++;
        }
        
        //ADD SHEET DATA PEGAWAI
        $this->excel->createSheet(4)->setTitle($this->lang->line('employee_sheet'));
        $this->excel->setActiveSheetIndex(4);
        $this->excel->getActiveSheet()->setCellValue('A1', $this->lang->line('nip'))
                              ->setCellValue('B1', $this->lang->line('nama'));
        $No = 2;
        $All_data=$this->pegawai_import_model->get_pegawai_all_pegawai_import($this->kd_perusahaan);
        
        foreach ($All_data->result() as $row){
            
            $this->excel->getActiveSheet()
                        ->setCellValue('A'.$No, $row->nip)
                        ->setCellValue('B'.$No, $row->nama);
            $No++;
        }
        $filename='FormImportEmployee'.'.xls'; //save our workbook as this file name
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
    // insert appraisal
    public function save()
    {
         
        $Data=["success"=>false,"messages"=>array(),"status"=>false,"data_upload"=>''];
        if (!empty($_FILES['file']['name'])) {
        
            //$KodeBanner=$this->banner_model->GenerateKodeBanner();  
//            $config['allowed_types'] = 'xlsx|csv|xls';
                $config=array(
                            'allowed_types'   => 'csv',
                            'upload_path'   => $this->Upload_Path,
                            'overwrite'     => TRUE,
                            'max_size'      => 10000 // 10mb
                        );
                $this->load->library('upload',$config);
                if ( ! $this->upload->do_upload('file')){
                    $Data['error'] = $this->upload->display_errors();
                }
                else
                {
                    $upload_data = $this->upload->data();
                }
            }
            
        if(isset($Data['error']) or empty($_FILES['file']['name']))
        {
            
            if(isset($upload_data)){
                $Path=$upload_data['full_path'];
                unlink($Path);
            }
            if(isset($Data['error'])){
                $Data['messages']['file']= $Data['error'];
            }else if(empty($_FILES['file']['name'])){
                $Data['messages']['file']= $this->lang->line('error_file');
            }
        }
        else{
            $PathFile=$upload_data['full_path'];
            $file = fopen($PathFile, "r");
            // $column = fgetcsv($file, 0, ",");
            // var_dump($column);die;
            $column=array();
           
//            while(! feof($file))
//            {
//                print_r(fgetcsv($file));
//                echo $column[0]."-".$column[1]."-".$column[2]."-".$column[3]."-".$column[4]."-".$column[5]."<br/>";
//            }
//            fclose($file);
             //load our new PHPExcel library
//            $this->load->library('excel');
//
//            //=== change php ini limits. =====
//            $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
//            $cacheSettings = array( ' memoryCacheSize ' => '50MB');
//            PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
//            //==== create excel object of reader
//            $inputFileType = PHPExcel_IOFactory::identify($PathFile);
//            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
//            $objReader->setDelimiter(";");
//            $objPHPExcel = $objReader->load($PathFile);
//            $sheet = $objPHPExcel->getActiveSheet()->getRowIterator();


            $DataPerush=$this->pegawai_import_model->get_perusahaan_all_pegawai_import($this->kd_perusahaan);
            $ListPerush=  get_value_array($DataPerush,'kd_perusahaan','nm_perusahaan',FALSE);
            
            $DataDept=$this->pegawai_import_model->get_departemen_all_pegawai_import($this->kd_perusahaan);
            $ListDept=  get_value_array($DataDept,'kd_departemen','nm_departemen',FALSE);
            
            $DataJabatan=$this->pegawai_import_model->get_jabatan_all_pegawai_import($this->kd_perusahaan);
            $ListJabatan=  get_value_array($DataJabatan,'kd_jabatan','nm_jabatan',FALSE);
            
            $DataPegawai=$this->pegawai_import_model->get_pegawai_all_pegawai_import($this->kd_perusahaan);
            $ListPegawai=  get_value_array($DataPegawai,'nip','nama',TRUE);
            
            $ListKelamin= $this->_list_kelamin();
            $ListStatus= $this->_list_status();
            $data = array();
            $data_detail = array();
            $numrow = 1;    
            $statusErr=0;
            $error=array();
             while (($column = fgetcsv($file, 0, ";")) !== FALSE) {
                if($numrow==1){
                    if(!$this->_CekFile($column)){
                        $statusErr=1;
                        $Data['messages']['file']= $this->lang->line('error_file2');
                        break;
                    }
                }else if($numrow > 1){
                    $statusErr2=0;
                    if(isset($ListPegawai[$column[1]])){
                        $statusErr2=1;
                        $error[$numrow][1]="row ".$column[0]." ".$this->lang->line('error_pegawai2');
                    }
                    if(!isset($ListPerush[$column[6]])){
                        
                        $statusErr2=1;
                        $error[$numrow][6]="row ".$column[0]." ".$this->lang->line('error_perusahaan');
                        
                    }
                    if(!isset($ListDept[$column[7]])){
                        $statusErr2=1;
                        $error[$numrow][7]="row ".$column[0]." ".$this->lang->line('error_departemen');
                    }
                    if(!isset($ListJabatan[$column[8]])){
                        $statusErr2=1;
                        $error[$numrow][8]="row ".$column[0]." ".$this->lang->line('error_jabatan');
                    }
                    // cek nip atasan
                    // if(!isset($ListPegawai[$column[9]])){
                    //     $statusErr2=1;
                    //     $error[$numrow][9]="row ".$numrow." ".$this->lang->line('error_pegawai');
                    // }
                    if(!$this->_CekTanggal($column[3])){
                        $statusErr2=1;
                        $error[$numrow][3]="row ".$column[0]." ".$this->lang->line('error_tgl');
                    }
                    if($column[4]!="" and !$this->_CekTanggal($column[4])){
                        $statusErr2=1;
                        $error[$numrow][4]="row ".$column[0]." ".$this->lang->line('error_tgl');
                    }
                    if($column[5]!="" and !$this->_CekTanggal($column[5])){
                        $statusErr2=1;
                        $error[$numrow][5]="row ".$column[0]." ".$this->lang->line('error_tgl');
                    }
                    if(!isset($ListKelamin[$column[11]])){
                        $statusErr2=1;
                        $error[$numrow][11]="row ".$column[0]." ".$this->lang->line('error_kelamin');
                    }
                    if(!isset($ListStatus[$column[10]])){
                        $statusErr2=1;
                        $error[$numrow][10]="row ".$column[0]." ".$this->lang->line('error_status');
                    }
                    if($statusErr2==0){
                        array_push($data, array(
                            "nip"=>$column[1],
                            "Nama"=>$column[2],
                            "tgl_masuk"=>$column[3],
                            "dob"=>$column[4],
                            "tgl_keluar"=>$column[5],
                            "kd_perusahaan"=>$column[6],
                            "kd_departemen"=>$column[7],
                            "kd_jabatan"=>$column[8],
                            "report_to"=>$column[9],
                            "status"=>$column[10],
                            "jenis_kelamin"=>$column[11]
                        ));
                    }

                } 
                $numrow++;
            }
            if($statusErr==1)
            {
                $numrow=1;
                $file2 = fopen($PathFile, "r");
                $statusErr=0;
                while (($column = fgetcsv($file2, 0, ",")) !== FALSE) {
                    if($numrow==1){
                        // var_dump($column);die;
                        if(!$this->_CekFile($column)){
                            // var_dump($column);die;
                            $statusErr=1;
                            $Data['messages']['file']= $this->lang->line('error_file2');
                            break;
                        }
                    }else if($numrow > 1){
                        $statusErr2=0;
                        if(isset($ListPegawai[$column[1]])){
                            $statusErr2=1;
                            // echo $column[1]."--<br/>";
                            $error[$numrow][1]="row ".$column[0]." ".$this->lang->line('error_pegawai2');
                            // echo $error[$numrow][1]."<br/>";
                        }
                        if(!isset($ListPerush[$column[6]])){
                            
                            $statusErr2=1;
                            $error[$numrow][6]="row ".$column[0]." ".$this->lang->line('error_perusahaan');
                            
                        }
                        if(!isset($ListDept[$column[7]])){
                            $statusErr2=1;
                            $error[$numrow][7]="row ".$column[0]." ".$this->lang->line('error_departemen');
                        }
                        if(!isset($ListJabatan[$column[8]])){
                            $statusErr2=1;
                            $error[$numrow][8]="row ".$column[0]." ".$this->lang->line('error_jabatan');
                        }
                        // cek nip atasan
                        // if(!isset($ListPegawai[$column[9]])){
                        //     $statusErr2=1;
                        //     $error[$numrow][9]="row ".$numrow." ".$this->lang->line('error_pegawai');
                        // }
                        if(!$this->_CekTanggal($column[3])){
                            $statusErr2=1;
                            $error[$numrow][3]="row ".$column[0]." ".$this->lang->line('error_tgl');
                        }
                        if($column[4]!="" and !$this->_CekTanggal($column[4])){
                            $statusErr2=1;
                            $error[$numrow][4]="row ".$column[0]." ".$this->lang->line('error_tgl');
                        }
                        if($column[5]!="" and !$this->_CekTanggal($column[5])){
                            $statusErr2=1;
                            $error[$numrow][5]="row ".$column[0]." ".$this->lang->line('error_tgl');
                        }
                        if(!isset($ListKelamin[$column[11]])){
                            $statusErr2=1;
                            $error[$numrow][11]="row ".$column[0]." ".$this->lang->line('error_kelamin');
                        }
                        if(!isset($ListStatus[$column[10]])){
                            $statusErr2=1;
                            $error[$numrow][10]="row ".$column[0]." ".$this->lang->line('error_status');
                        }
                        if($statusErr2==0){
                            array_push($data, array(
                                "nip"=>$column[1],
                                "Nama"=>$column[2],
                                "tgl_masuk"=>$column[3],
                                "dob"=>$column[4],
                                "tgl_keluar"=>$column[5],
                                "kd_perusahaan"=>$column[6],
                                "kd_departemen"=>$column[7],
                                "kd_jabatan"=>$column[8],
                                "report_to"=>$column[9],
                                "status"=>$column[10],
                                "jenis_kelamin"=>$column[11]
                            ));
                        }
    
                    } 
                    $numrow++;
                }
                // var_dump($ListPegawai); die;
            }
            if($statusErr==0 and count($error)<=0 and count($data)>0){
                $this->pegawai_import_model->insert_multiple_Pegawai($data);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_input'));
            //insert user activity
            $this->useractivity->run_acitivity('insert '.$this->lang->line('subheader'),'',$data);
                $Data["success"]=true;
                $Data["status"]=true;
            }else if(count($error)>0){
                $listError='<div class="m-list-timeline"> 
                            <div class="m-list-timeline__items">';
                foreach ($error as $key=>$val){
                    foreach($error[$key] as $key2=>$val2){
                        $listError.='<div class="m-list-timeline__item">
                                            <span class="m-list-timeline__badge"></span>
                                            <span class="m-list-timeline__text">'.$val2.'</span>
                                    </div>';
                    }
                }
                $listError.="</div></div>";
                $Data["data_upload"]=$listError;
                $Data["success"]=true;
                $Data["status"]=false;
            }
            
        }
        
        echo json_encode($Data);
    }
    protected function _CekTanggal($tgl){
        if($tgl!=""){
            list($tahun,$bulan,$hari)= explode("-", $tgl);
            return checkdate($bulan, $hari, $tahun);
        }else{
            return FALSE;
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
    protected function _list_status($Status=""){
        $Data['1']=$this->lang->line('aktif');
        $Data['2']=$this->lang->line('resign');
        if($Status!=""){
            return $Data[$Status];
        }else{
            return $Data;
        }
    }
    protected function _CekFile($DataSheet){
        // var_dump($DataSheet);
        if(strtoupper($DataSheet[0])!='NO'){
            return FALSE;
        }else if(strtoupper($DataSheet[1])!=strtoupper($this->lang->line('nip'))){
            return FALSE;
        }else if(strtoupper($DataSheet[2])!=strtoupper($this->lang->line('nama'))){
            return FALSE;
        }else if(strtoupper($DataSheet[3])!=strtoupper($this->lang->line('tgl_masuk'))){
            return FALSE;
        }else if(strtoupper($DataSheet[4])!=strtoupper($this->lang->line('dob'))){
            return FALSE;
        }else if(strtoupper($DataSheet[5])!=strtoupper($this->lang->line('tgl_keluar'))){
            return FALSE;
        }else if(strtoupper($DataSheet[6])!=strtoupper($this->lang->line('kd_perusahaan'))){
            return FALSE;
        }else if(strtoupper($DataSheet[7])!=strtoupper($this->lang->line('kd_departemen'))){
            return FALSE;
        }else if(strtoupper($DataSheet[8])!=strtoupper($this->lang->line('kd_jabatan'))){
            return FALSE;
        }else if(strtoupper($DataSheet[9])!=strtoupper($this->lang->line('report_to'))){
            return FALSE;
        }else if(strtoupper($DataSheet[10])!=strtoupper($this->lang->line('status'))){
            return FALSE;
        }else if(strtoupper($DataSheet[11])!=strtoupper($this->lang->line('jenis_kelamin'))){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    // view appraisal view
    public function view_form()
    {
        $Data=array();
        $kd_appraisal=$this->uri->segment(4);
        $Data['DataPegawaiImport'] = $this->appraisal_model->get_appraisal_detail($kd_appraisal);
        if($Data['DataPegawaiImport']->num_rows()>0){
//            $Data['DataBulan']=$bulan;
//            $Data['DataTahun']=$tahun;
            $Data['ListType']= ListType();
            $Data['ListUnit']= ListUnit();
            $Data['ListUnitSimbol']= ListUnitSimbol();
//            $Data['ListPeriodAll']= ListPeriodAll();
            $this->load->view('PegawaiImport_vf/v_PegawaiImport_view',$Data);
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
            $Data['DataPegawaiImport'] = $this->appraisal_model->get_appraisal_detail($kd_appraisal);
            if($Data['DataPegawaiImport']->num_rows()>0){
                $nip=$Data['DataPegawaiImport']->row()->nip;
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
                    $ListKPIPegawaiImport=array();
                    $remark='';
                    foreach ($Data['DataPegawaiImport']->result() as $row){
                        $ListKPIPegawaiImport[$row->kd_measurement]=$row->actual;
                        $remark=$row->remark;
                    }
                    $Data["ListKPIDepartemen"]=$ListKPIDepartemen;
                    $Data["ListKPIPegawaiImport"]=$ListKPIPegawaiImport;
                    $Data['remark']=$remark;
    //                $Data['ListPeriodAll']= ListPeriodAll();
                    $this->load->view('PegawaiImport_vf/v_PegawaiImport_edit',$Data);
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
        $DataPegawaiImport = $this->appraisal_model->get_appraisal_detail($kd_appraisal);
        if($DataPegawaiImport->num_rows() > 0)
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

                $id=$this->appraisal_model->insert_appraisal($Input);
                $PegawaiImportDetail=array();
                $i=1;
                foreach($kd_measurement as $key=>$val){
                    if($type[$key]=='min'){
                        $result=round(($actual[$key]/$target[$key]),4);
                    }else{
                        $result=round(($target[$key]/$actual[$key]),4);
                    }
                    $score_bd=round(($result*$weightage_bd[$key]*$weightage_bd_dept[$key]),4);
                    $score_kpi=round(($result*$weightage_kpi[$key]),4);
                    $PegawaiImportDetail[$i]['kd_ad']=$kd_appraisalNew."-".$i;
                    $PegawaiImportDetail[$i]['kd_appraisal']=$kd_appraisalNew;
                    $PegawaiImportDetail[$i]['kd_measurement']=$val;
                    $PegawaiImportDetail[$i]['weightage_bd']=$weightage_bd[$key];
                    $PegawaiImportDetail[$i]['weightage_kpi']=$weightage_kpi[$key];
                    $PegawaiImportDetail[$i]['weightage_bd_dept']=$weightage_bd_dept[$key];
                    $PegawaiImportDetail[$i]['target']=$target[$key];
                    $PegawaiImportDetail[$i]['score_bd']=$score_bd;
                    $PegawaiImportDetail[$i]['score_kpi']=$score_kpi;
                    $PegawaiImportDetail[$i]['actual']=$actual[$key];
                    $PegawaiImportDetail[$i]['result']=$result;
                    $PegawaiImportDetail[$i]['type']=$type[$key];
                    $PegawaiImportDetail[$i]['unit']=$unit[$key];
                    $PegawaiImportDetail[$i]['period']=$period[$key];
                    $i++;
                }
                $this->appraisal_model->insert_appraisal_detail_batch($PegawaiImportDetail);
                
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
            $DataPegawaiImport = $this->appraisal_model->get_appraisal_by_code($DataDelete);
            //delete data
            $this->appraisal_model->delete_appraisal($DataDelete);
            $this->session->set_flashdata('AlertInput', $this->lang->line('sukses_delete'));
            //insert user activity
            $this->useractivity->run_acitivity('delete '.$this->lang->line('subheader'),$DataDelete,array(),$DataPegawaiImport->row_array());
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
        //redirect('appraisal/PegawaiImport');
        //echo json_encode($Data);

    }
}


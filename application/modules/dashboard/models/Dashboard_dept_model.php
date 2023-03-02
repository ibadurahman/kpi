<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_dept_model extends CI_Model
{
    public function get_dept_kpi_perbulan($kd_perusahaan,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $this->db->select('departemen_result.kd_departemen,
                            departemen.nm_departemen,
                            (departemen_result.score_kpi) kpi_dept');
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->where('departemen_result.tahun', $tahun);
        $this->db->where('departemen_result.bulan', $bulan);
        $this->db->where('departemen.kd_perusahaan', $kd_perusahaan);
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    
    public function get_dept_radar_chart_perbulan($kd_perusahaan,$tahun,$bulan){
     
        
        $query = $this->get_dept_kpi_perbulan($kd_perusahaan, $tahun, $bulan);
//        echo $this->db->last_query();
//        die();
        $Data["Label"]='';
        $Data["Value"]='';
        //$Data["Color"]='';
        foreach($query->result() as $row){
            $Data["Label"] .="'".$row->nm_departemen."',";
            $Data["Value"] .=$row->kpi_dept.",";
//            $Data["Color"] .="'".$this->rand_color()."',";
        }
        return $Data;
    }
    public function get_dept_kpi_pertahun($kd_perusahaan,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('departemen_result.kd_departemen,
                            departemen.nm_departemen,
                            round(avg(departemen_result.score_kpi),2) kpi_dept');
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->where('departemen_result.tahun', $tahun);
        $this->db->where('departemen.kd_perusahaan', $kd_perusahaan);
        $this->db->group_by('departemen_result.kd_departemen,
                                departemen.nm_departemen');
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_dept_radar_chart_pertahun($kd_perusahaan,$tahun){
     
        
        $query = $this->get_dept_kpi_pertahun($kd_perusahaan, $tahun);
//        echo $this->db->last_query();
//        die();
        $Data["Label"]='';
        $Data["Value"]='';
        //$Data["Color"]='';
        foreach($query->result() as $row){
            $Data["Label"] .="'".$row->nm_departemen."',";
            $Data["Value"] .=$row->kpi_dept.",";
//            $Data["Color"] .="'".$this->rand_color()."',";
        }
        return $Data;
    }
    public function get_dept_kpi_rekap_setahun($kd_perusahaan,$tahun,$bulan,$kd_departemen=NULL){
        if($tahun==""){
            $tahun=date("Y");
        }
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        if($kd_departemen!="" and $kd_departemen!=NULL){
            $this->db->where('departemen_result.kd_departemen', $kd_departemen);
        }
        $this->db->select('departemen_result.kd_departemen,
                            departemen.nm_departemen,
                            departemen_result.bulan,
                            departemen_result.tahun,
                            (departemen_result.score_kpi) kpi_dept');
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->where("concat(departemen_result.tahun,if(departemen_result.bulan<10,concat('0',departemen_result.bulan),departemen_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $this->db->where('departemen.kd_perusahaan', $kd_perusahaan);
        // $this->db->group_by('departemen_result.kd_departemen,
		// 	departemen.nm_departemen,
		// 	departemen_result.tahun,
        //                 departemen_result.bulan');
        $this->db->order_by('departemen_result.kd_departemen');
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_dept_kpi_rekap_setahun_linechart($kd_perusahaan,$tahun,$bulan,$kd_departemen=NULL){
     
        
        $query = $this->get_dept_kpi_rekap_setahun($kd_perusahaan,$tahun,$bulan,$kd_departemen);
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut = 0;
        $temp_dept="";
        foreach($query->result() as $row){
            if($temp_dept!=$row->kd_departemen){
                $temp_dept=$row->kd_departemen;
                $NoUrut++;
            }
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
            $Data['bulan'][$row->tahun.$bulan]= getNamaBulanMin($row->bulan)." ".substr($row->tahun,2);
            $Data['legend'][$row->kd_departemen]= $row->nm_departemen;
            $Data['color'][$row->kd_departemen]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_departemen]["code"] =$row->kd_departemen;
            $Data['data_grafik'][$row->kd_departemen]["nama"] =$row->nm_departemen;
            $Data['data_grafik'][$row->kd_departemen]["score"][$row->tahun.$bulan] =$row->kpi_dept;
        }
        return $Data;
    }
    public function get_dept_kpi_rekap_pertahun($kd_perusahaan,$tahun,$kd_departemen=NULL){
        if($tahun==""){
            $tahun=date("Y");
        }
        $thnAwal=$tahun-10;
        $thnAkhir=$tahun;
        if($kd_departemen!="" and $kd_departemen!=NULL){
            $this->db->where('departemen_result.kd_departemen', $kd_departemen);
        }
        $this->db->select('departemen_result.kd_departemen,
                            departemen.nm_departemen,
                            departemen_result.tahun,
                            round(avg(departemen_result.score_kpi),2) kpi_dept');
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->where("departemen_result.tahun between '$thnAwal' and '$thnAkhir'",NULL);
        $this->db->where('departemen.kd_perusahaan', $kd_perusahaan);
        $this->db->group_by('departemen_result.kd_departemen,
                            departemen.nm_departemen,
                            departemen_result.tahun');
        $this->db->order_by('departemen_result.kd_departemen');
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_dept_kpi_rekap_pertahun_linechart($kd_perusahaan,$tahun,$kd_departemen=NULL){
     
        
        $query = $this->get_dept_kpi_rekap_pertahun($kd_perusahaan,$tahun,$kd_departemen);
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut = 0;
        $temp_dept="";
        foreach($query->result() as $row){
            if($temp_dept!=$row->kd_departemen){
                $temp_dept=$row->kd_departemen;
                $NoUrut++;
            }
            $Data['bulan'][$row->tahun]= substr($row->tahun,2);
            $Data['legend'][$row->kd_departemen]= $row->nm_departemen;
            $Data['color'][$row->kd_departemen]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_departemen]["code"] =$row->kd_departemen;
            $Data['data_grafik'][$row->kd_departemen]["nama"] =$row->nm_departemen;
            $Data['data_grafik'][$row->kd_departemen]["score"][$row->tahun] =$row->kpi_dept;
        }
        return $Data;
    }
    public function get_dept_kpi_detail_perbulan($kd_perusahaan,$tahun,$bulan,$kd_departemen=NULL){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        // $this->db->select('departemen_result.kd_departemen,
		// 		sum(departemen_result.score_kpi) kpi_dept');
        // $this->db->from('departemen_result');
        // $this->db->join('departemen','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        // $this->db->where('departemen_result.tahun', $tahun);
        // $this->db->where('departemen_result.bulan', $bulan);
        // $this->db->where('departemen.kd_perusahaan', $kd_perusahaan);
        // if($kd_departemen!="" and $kd_departemen!=NULL){
        //     $this->db->where('departemen_result.kd_departemen', $kd_departemen);
        // }
        // $this->db->group_by('departemen_result.kd_departemen');
        // $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('departemen_result.kd_dr,
                        departemen_result.bulan,
                        departemen_result.tahun,
                        departemen_result.kd_departemen,
                        departemen_result.kd_measurement,
                        round(departemen_result.weightage_bd,2)weightage_bd,
                        round(departemen_result.weightage_kpi,2)weightage_kpi,
                        departemen_result.target,
                        round(departemen_result.score_bd,2)score_bd,
                        round(departemen_result.score_kpi,2)score_kpi,
                        departemen_result.actual,
                        round(departemen_result.result,2)result,
                        round(departemen_result.resultvsbobot,2)resultvsbobot,
                        round(departemen_result.point_result,2)point_result,
                        round(departemen_result.point_result,2)gross_result,
                        departemen_result.type,
                        departemen_result.unit,
                        departemen_result.period,
			departemen.nm_departemen,
			measurement.nm_measurement,
			round(departemen_result.score_kpi,2)kpi_dept');
        $this->db->from('departemen');
        $this->db->join('departemen_result','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->join('measurement','departemen_result.kd_measurement = measurement.kd_measurement','LEFT');
        // $this->db->join('('.$where_clause.')tbl_kpi','departemen_result.kd_departemen = tbl_kpi.kd_departemen','LEFT');
        $this->db->where('departemen_result.tahun', $tahun);
        $this->db->where('departemen_result.bulan', $bulan);
        $this->db->where('departemen.kd_perusahaan', $kd_perusahaan);
        if($kd_departemen!="" and $kd_departemen!=NULL){
            $this->db->where('departemen_result.kd_departemen', $kd_departemen);
        }
        $this->db->order_by('departemen_result.kd_departemen');
       // $this->searching->SetSerching($DataSearch);
        $query=$this->db->get();
    //    echo $this->db->last_query();
    //    die();
        return $query;
    }
    public function get_dept_kpi_detail_pertahun2($kd_perusahaan,$tahun,$kd_departemen=NULL){
        if($tahun==""){
            $tahun=date("Y");
        }
        // $this->db->select('departemen_result.kd_departemen,
		// 		sum(departemen_result.score_kpi) kpi_dept');
        // $this->db->from('departemen_result');
        // $this->db->join('departemen','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        // $this->db->where('departemen_result.tahun', $tahun);
        // $this->db->where('departemen_result.bulan', $bulan);
        // $this->db->where('departemen.kd_perusahaan', $kd_perusahaan);
        // if($kd_departemen!="" and $kd_departemen!=NULL){
        //     $this->db->where('departemen_result.kd_departemen', $kd_departemen);
        // }
        // $this->db->group_by('departemen_result.kd_departemen');
        // $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('departemen_result.tahun,
                        departemen_result.kd_departemen,
                        departemen.nm_departemen,
                        round(avg(departemen_result.score_kpi),2)kpi_dept');
        $this->db->from('departemen');
        $this->db->join('departemen_result','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        // $this->db->join('('.$where_clause.')tbl_kpi','departemen_result.kd_departemen = tbl_kpi.kd_departemen','LEFT');
        $this->db->where('departemen_result.tahun', $tahun);
        $this->db->where('departemen.kd_perusahaan', $kd_perusahaan);
        if($kd_departemen!="" and $kd_departemen!=NULL){
            $this->db->where('departemen_result.kd_departemen', $kd_departemen);
        }
        $this->db->group_by("departemen_result.tahun,
                            departemen_result.kd_departemen,
                            departemen.nm_departemen");
        $this->db->order_by('departemen_result.kd_departemen');
       // $this->searching->SetSerching($DataSearch);
        $query=$this->db->get();
    //    echo $this->db->last_query();
    //    die();
        return $query;
    }
    public function get_dept_kpi_detail_pertahun($kd_perusahaan,$tahun,$kd_departemen=NULL){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $this->db->select('departemen_result.kd_departemen,
                            departemen_result.bulan,
				sum(departemen_result.score_kpi) kpi_dept');
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->where('departemen_result.tahun', $tahun);
        $this->db->where('departemen.kd_perusahaan', $kd_perusahaan);
        if($kd_departemen!="" and $kd_departemen!=NULL){
            $this->db->where('departemen_result.kd_departemen', $kd_departemen);
        }
        $this->db->group_by('departemen_result.kd_departemen,departemen_result.bulan');
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('departemen_result.kd_dr,
                        departemen_result.bulan,
                        departemen_result.tahun,
                        departemen_result.kd_departemen,
                        departemen_result.kd_measurement,
                        round(departemen_result.weightage_bd,2)weightage_bd,
                        round(departemen_result.weightage_kpi,2)weightage_kpi,
                        departemen_result.target,
                        round(departemen_result.score_bd,2)score_bd,
                        round(departemen_result.score_kpi,2)score_kpi,
                        departemen_result.actual,
                        round(departemen_result.result,2)result,
                        round(departemen_result.resultvsbobot,2)resultvsbobot,
                        round(departemen_result.point_result,2)point_result,
                        round(departemen_result.point_result,2)gross_result,
                        departemen_result.type,
                        departemen_result.unit,
                        departemen_result.period,
			departemen.nm_departemen,
			measurement.nm_measurement,
			round(tbl_kpi.kpi_dept,2)kpi_dept');
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->join('measurement','departemen_result.kd_measurement = measurement.kd_measurement','LEFT');
        $this->db->join('('.$where_clause.')tbl_kpi','departemen_result.kd_departemen = tbl_kpi.kd_departemen','LEFT');
        $this->db->where('departemen_result.tahun', $tahun);
        $this->db->where('departemen_result.bulan', $bulan);
        $this->db->where('departemen.kd_perusahaan', $kd_perusahaan);
        if($kd_departemen!="" and $kd_departemen!=NULL){
            $this->db->where('departemen_result.kd_departemen', $kd_departemen);
        }
        $this->db->order_by('departemen_result.kd_departemen');
       // $this->searching->SetSerching($DataSearch);
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_dept_kpi_perbulan_perdept($kd_departemen,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $this->db->select('departemen_result.*,
                            departemen.nm_departemen');
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->where('departemen_result.tahun', $tahun);
        $this->db->where('departemen_result.bulan', $bulan);
        $this->db->where('departemen_result.kd_departemen', $kd_departemen);
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    
    public function get_pegawai_kpi_dept_perbulan($kd_departemen,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        
        $this->db->select('appraisal.kd_appraisal,
			appraisal.bulan,
			appraisal.tahun,
			appraisal.nip,
			pegawai.nama,
			appraisal.kd_departemen,
			departemen.nm_departemen,
			appraisal.kd_jabatan,
			jabatan.nm_jabatan,
			appraisal.`status`,
			appraisal.point,
			appraisal_detail.kd_measurement,
			measurement.nm_measurement,
			round(appraisal_detail.weightage_bd,2)weightage_bd,
			round(appraisal_detail.weightage_kpi,2)weightage_kpi,
			round(appraisal_detail.weightage_bd_dept,2)weightage_bd_dept,
			appraisal_detail.target,
			round(appraisal_detail.score_bd,2)score_bd,
			round(appraisal_detail.score_kpi,2)score_kpi,
			appraisal_detail.actual,
			round(appraisal_detail.result,2)result,
			round(appraisal_detail.point_result,2)point_result,
			round(appraisal_detail.point_result,2)gross_result,
			appraisal_detail.`type`,
			appraisal_detail.unit,
			appraisal_detail.period,
			case
				when round((appraisal_detail.result*appraisal_detail.weightage_bd*4),2)>4 then 4
				else round((appraisal_detail.result*appraisal_detail.weightage_bd*4),2)
			end as score_result');
        $this->db->from('appraisal');
        $this->db->join('appraisal_detail','appraisal.kd_appraisal = appraisal_detail.kd_appraisal','LEFT');
        $this->db->join('pegawai','appraisal.nip = pegawai.nip','LEFT');
        $this->db->join('departemen','appraisal.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->join('jabatan','appraisal.kd_jabatan = jabatan.kd_jabatan','LEFT');
        $this->db->join('measurement','appraisal_detail.kd_measurement = measurement.kd_measurement','LEFT');
        $this->db->where('appraisal.tahun', $tahun);
        $this->db->where('appraisal.bulan', $bulan);
        $this->db->where('appraisal.kd_departemen', $kd_departemen);
        $this->db->order_by('pegawai.nama');
       // $this->searching->SetSerching($DataSearch);
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_peg_kpi_perbulan_perdept($kd_departemen,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $this->db->select('appraisal.*,
                            departemen.nm_departemen,
                            jabatan.nm_jabatan,
                            pegawai.nama');
        $this->db->from('appraisal');
        $this->db->join('pegawai','appraisal.nip = pegawai.nip','LEFT');
        $this->db->join('departemen','appraisal.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->join('jabatan','appraisal.kd_jabatan = jabatan.kd_jabatan','LEFT');
        $this->db->where('appraisal.tahun', $tahun);
        $this->db->where('appraisal.bulan', $bulan);
        $this->db->where('appraisal.kd_departemen', $kd_departemen);
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_peg_kpi_pertahun_perdept($kd_departemen,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('appraisal.nip,
                            appraisal.kd_departemen,
                            appraisal.kd_jabatan,
                            appraisal.tahun,
                            departemen.nm_departemen,
                            jabatan.nm_jabatan,
                            pegawai.nama,
                            round(avg(appraisal.point),2) as point');
        $this->db->from('appraisal');
        $this->db->join('pegawai','appraisal.nip = pegawai.nip','LEFT');
        $this->db->join('departemen','appraisal.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->join('jabatan','appraisal.kd_jabatan = jabatan.kd_jabatan','LEFT');
        $this->db->where('appraisal.tahun', $tahun);
        $this->db->where('appraisal.kd_departemen', $kd_departemen);
        $this->db->group_by("appraisal.nip,
                            appraisal.kd_departemen,
                            appraisal.kd_jabatan,
                            appraisal.tahun,
                            departemen.nm_departemen,
                            jabatan.nm_jabatan,
                            pegawai.nama,");
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    protected function list_warna($no){
        $list_warna[1]="#00c5dc";//accent
        $list_warna[2]="#ffb822";//warning
        $list_warna[3]="#f4516c";//danger
        $list_warna[4]="#5867dd";//primary
        $list_warna[5]="#34bfa3";//success
        $list_warna[6]="#36a3f7";//info
        if(isset($list_warna[$no])){
            return $list_warna[$no];
        }else{
            return $this->rand_color();
        }
        
    }
    function rand_color() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
    
}

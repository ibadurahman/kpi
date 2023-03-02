<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_ms_model extends CI_Model
{
    public function get_ms_by_code_bulanan($kd_measurement,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $this->db->select('measurement_result.kd_mr,
                            measurement_result.kd_measurement,
                            measurement_result.point_result');
        $this->db->from('measurement_result');
        $this->db->where('measurement_result.tahun', $tahun);
        $this->db->where('measurement_result.bulan', $bulan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("measurement.kd_measurement,measurement.kd_ms,measurement.nm_measurement,ifnull(tbl_ms.point_result,0) point_result ");
        $this->db->from('measurement');
        $this->db->join('('.$where_clause.') tbl_ms','measurement.kd_measurement = tbl_ms.kd_measurement','LEFT');
        $this->db->where('measurement.kd_measurement',$kd_measurement);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_ms_by_code_tahunan($kd_measurement,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('measurement_result.kd_mr,
                            measurement_result.kd_measurement,
                            measurement_result.point_result');
        $this->db->from('measurement_result');
        $this->db->where('measurement_result.tahun', $tahun);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("measurement.kd_measurement,measurement.kd_ms,measurement.nm_measurement,ifnull(round(avg(tbl_ms.point_result),2),0)point_result");
        $this->db->from('measurement');
        $this->db->join('('.$where_clause.') tbl_ms','measurement.kd_measurement = tbl_ms.kd_measurement','LEFT');
        $this->db->where('measurement.kd_measurement',$kd_measurement);
        $this->db->group_by("measurement.kd_measurement,measurement.kd_ms,measurement.nm_measurement");
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function dashboard_dept_bulanan($kd_measurement,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('departemen_result.kd_dr,
                            departemen_result.kd_measurement,
                            departemen_result.kd_departemen,
                            departemen_result.target,
                            departemen_result.actual,
                            departemen_result.result,
                            departemen_result.type,
                            departemen_result.unit,
                            departemen_result.period,
                            departemen_result.bulan,
                            departemen_result.tahun,
                            round(ifnull(departemen_result.point_result,0),2) as gross_point_dept,
                            departemen_result.weightage_bd,
                            case
                                    when (departemen_result.score_bd*4) > 4 then 4
                                    else round(departemen_result.score_bd*4,2)
                            end point_dept');
        $this->db->from('departemen_result');
        $this->db->where('departemen_result.tahun', $tahun);
        $this->db->where('departemen_result.bulan', $bulan);
        $this->db->where('departemen_result.kd_measurement', $kd_measurement);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('departemen_result.kd_measurement,
                            departemen_result.kd_departemen,
                            round(ifnull(avg(departemen_result.point_result),0),2) as gross_point_dept,
                            case
                                    when (avg(departemen_result.score_bd)*4) > 4 then 4
                                    else round(avg(departemen_result.score_bd)*4,2)
                            end point_dept');
        $this->db->from('departemen_result');
        $this->db->where('departemen_result.tahun', $tahun);
        $this->db->group_by('departemen_result.kd_measurement, departemen_result.kd_departemen');
        $where_clause2 = $this->db->get_compiled_select();

        $this->db->select("measurement.kd_measurement,
			measurement.kd_ms,
                        measurement.nm_measurement,
                        point_bulan.target,
                        point_bulan.actual,
                        point_bulan.result,
                        point_bulan.type,
                        point_bulan.unit,
                        point_bulan.period,
                        point_bulan.bulan,
                        point_bulan.tahun,
			departemen.kd_departemen,
			departemen.nm_departemen,
                        point_bulan.weightage_bd,
                        ifnull(point_bulan.gross_point_dept,0) point_result,
			ifnull(point_bulan.gross_point_dept,0) as gross_point,
			ifnull(point_bulan.point_dept,0) as point,
			ifnull(point_tahun.gross_point_dept,0) as gross_point_tahun,
			ifnull(point_tahun.point_dept,0) as point_tahun",false);
        $this->db->from('measurement');
        $this->db->join('('.$where_clause.') point_bulan','measurement.kd_measurement = point_bulan.kd_measurement','LEFT');
        $this->db->join('departemen','point_bulan.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->join('('.$where_clause2.') point_tahun','point_bulan.kd_measurement = point_tahun.kd_measurement and point_bulan.kd_departemen = point_tahun.kd_departemen','LEFT');
        $this->db->where('measurement.kd_measurement',$kd_measurement);
        
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function dashboard_dept_tahunan($kd_measurement,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('departemen_result.kd_measurement,
                            departemen_result.kd_departemen,
                            group_concat(departemen_result.weightage_bd) weightage_bd,
                            group_concat(departemen_result.target)target,
                            group_concat(departemen_result.actual)actual,
                            group_concat(departemen_result.result)result,
                            group_concat(departemen_result.type)type,
                            group_concat(departemen_result.unit)unit,
                            group_concat(departemen_result.period)period,
                            group_concat(departemen_result.bulan)bulan,
                            group_concat(departemen_result.point_result)point_result,
                            departemen_result.tahun,
                            round(avg(departemen_result.point_result),2) as gross_point,
                            case
                                    when round(avg(departemen_result.score_bd)*4,2) > 4 then 4
                                    else round(avg(departemen_result.score_bd)*4,2)
                            end point_dept');
        $this->db->from('departemen_result');
        $this->db->where("departemen_result.tahun", $tahun);
        $this->db->group_by('departemen_result.tahun,departemen_result.kd_measurement, departemen_result.kd_departemen');
        $where_clause = $this->db->get_compiled_select();

        $this->db->select("measurement.kd_measurement,
			measurement.kd_ms,
                        measurement.nm_measurement,
                        point_bulan.kd_departemen,
                        departemen.nm_departemen,
                        point_bulan.target,
                        point_bulan.actual,
                        point_bulan.result,
                        point_bulan.type,
                        point_bulan.unit,
                        point_bulan.period,
                        point_bulan.bulan,
                        point_bulan.tahun,
                        point_bulan.point_result,
			ifnull(point_bulan.weightage_bd,0) as weightage_bd,
			ifnull(point_bulan.gross_point,0) as gross_point,
			ifnull(point_bulan.point_dept,0) as point",false);
        $this->db->from('departemen');
        $this->db->join('('.$where_clause.') point_bulan',' point_bulan.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->join('measurement','measurement.kd_measurement = point_bulan.kd_measurement','LEFT');
        $this->db->where('measurement.kd_measurement',$kd_measurement);
        
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    
    public function get_list_score_ms_bulanan_setahun($kd_measurement,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        
        $this->db->select('measurement.kd_measurement, 
				measurement.kd_ms, 
				measurement.nm_measurement,
				measurement_result.kd_mr, 
				measurement_result.bulan,
				measurement_result.tahun,
				measurement_result.point_result');
        $this->db->from('measurement');
        $this->db->join('measurement_result','measurement.kd_measurement = measurement_result.kd_measurement','LEFT');
        $this->db->where("concat(measurement_result.tahun,if(measurement_result.bulan<10,concat('0',measurement_result.bulan),measurement_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $this->db->where('measurement_result.kd_measurement', $kd_measurement);

        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_list_score_ms_tahunan($kd_measurement,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $ThnAwal= $tahun - 10;
        $ThnAkhir= $tahun;
        $this->db->select('measurement.kd_measurement, 
				measurement.kd_ms, 
				measurement.nm_measurement,
				measurement_result.tahun,
				round(avg(measurement_result.point_result),2) as point_result');
        $this->db->from('measurement');
        $this->db->join('measurement_result','measurement.kd_measurement = measurement_result.kd_measurement','LEFT');
        $this->db->where("measurement_result.tahun between '$ThnAwal' and '$ThnAkhir'", NULL);
        $this->db->where('measurement_result.kd_measurement', $kd_measurement);
        $this->db->group_by("measurement.kd_measurement, 
				measurement.kd_ms, 
				measurement.nm_measurement,
				measurement_result.tahun");
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_list_score_ms_rekap_setahun_chart($kd_measurement,$tahun,$bulan){
     
        
        $query = $this->get_list_score_ms_bulanan_setahun($kd_measurement,$tahun,$bulan);
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut = 0;
        $temp_ms="";
        foreach($query->result() as $row){
            if($temp_ms!=$row->kd_measurement){
                $temp_ms=$row->kd_measurement;
                $NoUrut++;
            }
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
            $Data['bulan'][$row->tahun.$bulan]= getNamaBulanMin($row->bulan)." ".substr($row->tahun,2);
            $Data['legend'][$row->kd_measurement]= $row->nm_measurement;
            $Data['color'][$row->kd_measurement]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_measurement]["code"] =$row->kd_measurement;
            $Data['data_grafik'][$row->kd_measurement]["nama"] =$row->nm_measurement;
            $Data['data_grafik'][$row->kd_measurement]["score"][$row->tahun.$bulan] =$row->point_result;
        }
        return $Data;
    }
    public function get_list_score_ms_tahunan_chart($kd_measurement,$tahun){
     
        
        $query = $this->get_list_score_ms_tahunan($kd_measurement,$tahun);
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut = 0;
        $temp_ms="";
        foreach($query->result() as $row){
            
            if($temp_ms!=$row->kd_measurement){
                $temp_ms=$row->kd_measurement;
                $NoUrut++;
            }
            $Data['bulan'][$row->tahun]= substr($row->tahun,2);
            $Data['legend'][$row->kd_measurement]= $row->nm_measurement;
            $Data['color'][$row->kd_measurement]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_measurement]["code"] =$row->kd_measurement;
            $Data['data_grafik'][$row->kd_measurement]["nama"] =$row->nm_measurement;
            $Data['data_grafik'][$row->kd_measurement]["score"][$row->tahun] =$row->point_result;
        }
        return $Data;
    }
    public function dashboard_list_peg_bulanan($kd_measurement,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        

        $this->db->select("appraisal.kd_appraisal,
                            appraisal.bulan,
                            appraisal.tahun,
                            appraisal.nip,
                            pegawai.nama,
                            appraisal.nip_atasan,
                            appraisal.kd_departemen,
                            departemen.nm_departemen,
                            appraisal.kd_jabatan,
                            jabatan.nm_jabatan,
                            appraisal_detail.kd_measurement,
                            measurement.nm_measurement,
                            appraisal_detail.point_result",false);
        $this->db->from('appraisal_detail');
        $this->db->join('appraisal','appraisal_detail.kd_appraisal = appraisal.kd_appraisal','LEFT');
        $this->db->join('pegawai','appraisal.nip = pegawai.nip','LEFT');
        $this->db->join('departemen','appraisal.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->join('jabatan','appraisal.kd_jabatan = jabatan.kd_jabatan','LEFT');
        $this->db->join('measurement','measurement.kd_measurement = appraisal_detail.kd_measurement','LEFT');
        $this->db->where('appraisal.status',2);
        $this->db->where('appraisal_detail.kd_measurement',$kd_measurement);
        $this->db->where('appraisal.bulan',$bulan);
        $this->db->where('appraisal.tahun',$tahun);
        $this->db->order_by('appraisal_detail.point_result DESC');
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function dashboard_list_peg_tahunan($kd_measurement,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        

        $this->db->select("appraisal.kd_appraisal,
                            appraisal.tahun,
                            appraisal.nip,
                            pegawai.nama,
                            appraisal.nip_atasan,
                            appraisal.kd_departemen,
                            departemen.nm_departemen,
                            appraisal.kd_jabatan,
                            jabatan.nm_jabatan,
                            appraisal_detail.kd_measurement,
                            measurement.nm_measurement,
                            round(avg(appraisal_detail.point_result),2)point_result",false);
        $this->db->from('appraisal_detail');
        $this->db->join('appraisal','appraisal_detail.kd_appraisal = appraisal.kd_appraisal','LEFT');
        $this->db->join('pegawai','appraisal.nip = pegawai.nip','LEFT');
        $this->db->join('departemen','appraisal.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->join('jabatan','appraisal.kd_jabatan = jabatan.kd_jabatan','LEFT');
        $this->db->join('measurement','measurement.kd_measurement = appraisal_detail.kd_measurement','LEFT');
        $this->db->where('appraisal.status',2);
        $this->db->where('appraisal_detail.kd_measurement',$kd_measurement);
        $this->db->where('appraisal.tahun',$tahun);
        $this->db->group_by('appraisal.kd_appraisal,
                            appraisal.tahun,
                            appraisal.nip,
                            pegawai.nama,
                            appraisal.nip_atasan,
                            appraisal.kd_departemen,
                            departemen.nm_departemen,
                            appraisal.kd_jabatan,
                            jabatan.nm_jabatan,
                            appraisal_detail.kd_measurement,
                            measurement.nm_measurement');
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
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

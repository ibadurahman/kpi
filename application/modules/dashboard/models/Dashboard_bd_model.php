<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_bd_model extends CI_Model
{
    public function get_bd_by_code_bulanan($kd_bd,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $this->db->select('business_driver_result.kd_bdr,
                            business_driver_result.kd_bd,
                            business_driver_result.point_result');
        $this->db->from('business_driver_result');
        $this->db->where('business_driver_result.tahun', $tahun);
        $this->db->where('business_driver_result.bulan', $bulan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("business_driver.kd_bd,business_driver.kd_bds,business_driver.nm_bd,ifnull(tbl_bd.point_result,0) point_result ");
        $this->db->from('business_driver');
        $this->db->join('('.$where_clause.') tbl_bd','business_driver.kd_bd = tbl_bd.kd_bd','LEFT');
        $this->db->where('business_driver.kd_bd',$kd_bd);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_bd_by_code_tahunan($kd_bd,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('business_driver_result.kd_bdr,
                            business_driver_result.kd_bd,
                            business_driver_result.point_result');
        $this->db->from('business_driver_result');
        $this->db->where('business_driver_result.tahun', $tahun);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("business_driver.kd_bd,business_driver.kd_bds,business_driver.nm_bd,ifnull(round(avg(tbl_bd.point_result),2),0)point_result");
        $this->db->from('business_driver');
        $this->db->join('('.$where_clause.') tbl_bd','business_driver.kd_bd = tbl_bd.kd_bd','LEFT');
        $this->db->where('business_driver.kd_bd',$kd_bd);
        $this->db->group_by("business_driver.kd_bd,business_driver.kd_bds,business_driver.nm_bd");
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function dashboard_ms_bulanan($kd_bd,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('measurement_result.kd_mr,
                            measurement_result.kd_measurement,
                            measurement_result.target,
                            measurement_result.actual,
                            measurement_result.result,
                            measurement_result.type,
                            measurement_result.unit,
                            measurement_result.period,
                            measurement_result.bulan,
                            measurement_result.tahun,
                            round(ifnull(measurement_result.point_result,0),2) as gross_point_ms,
                            measurement_result.weightage,
                            round(measurement_result.score,2) as point_ms');
        $this->db->from('measurement_result');
        $this->db->where('measurement_result.tahun', $tahun);
        $this->db->where('measurement_result.bulan', $bulan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('measurement_result.kd_measurement,
                            round(ifnull(avg(measurement_result.point_result),0),2) as gross_point_ms,
                            round(avg(measurement_result.score),2) as point_ms');
        $this->db->from('measurement_result');
        $this->db->where('measurement_result.tahun', $tahun);
        $this->db->group_by('measurement_result.kd_measurement');
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
			business_driver.nm_bd,
                        point_bulan.weightage,
                        ifnull(point_bulan.gross_point_ms,0) point_result,
			ifnull(point_bulan.gross_point_ms,0) as gross_point,
			ifnull(point_bulan.point_ms,0) as point,
			ifnull(point_tahun.gross_point_ms,0) as gross_point_tahun,
			ifnull(point_tahun.point_ms,0) as point_tahun",false);
        $this->db->from('measurement');
        $this->db->join('business_driver','measurement.kd_bd = business_driver.kd_bd','LEFT');
        $this->db->join('('.$where_clause.') point_bulan','measurement.kd_measurement = point_bulan.kd_measurement','LEFT');
        $this->db->join('('.$where_clause2.') point_tahun','measurement.kd_measurement = point_tahun.kd_measurement','LEFT');
        $this->db->where('measurement.kd_bd',$kd_bd);
        
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function dashboard_ms_tahunan($kd_bd,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('measurement_result.kd_measurement,
                            group_concat(measurement_result.weightage) weightage,
                            group_concat(measurement_result.target)target,
                            group_concat(measurement_result.actual)actual,
                            group_concat(measurement_result.result)result,
                            group_concat(measurement_result.type)type,
                            group_concat(measurement_result.unit)unit,
                            group_concat(measurement_result.period)period,
                            group_concat(measurement_result.bulan)bulan,
                            group_concat(measurement_result.point_result)point_result,
                            measurement_result.tahun,
                            round(avg(measurement_result.point_result),2) as gross_point,
                            round(avg(measurement_result.score),2) as point_ms');
        $this->db->from('measurement_result');
        $this->db->where("measurement_result.tahun", $tahun);
        $this->db->group_by('measurement_result.tahun,measurement_result.kd_measurement');
        $where_clause = $this->db->get_compiled_select();

        $this->db->select("measurement.kd_measurement,
			measurement.kd_ms,
                        measurement.nm_measurement,
			business_driver.nm_bd,
                        point_bulan.target,
                        point_bulan.actual,
                        point_bulan.result,
                        point_bulan.type,
                        point_bulan.unit,
                        point_bulan.period,
                        point_bulan.bulan,
                        point_bulan.tahun,
                        point_bulan.point_result,
			ifnull(point_bulan.weightage,0) as weightage,
			ifnull(point_bulan.gross_point,0) as gross_point,
			ifnull(point_bulan.point_ms,0) as point",false);
        $this->db->from('measurement');
        $this->db->join('business_driver','measurement.kd_bd = business_driver.kd_bd','LEFT');
        $this->db->join('('.$where_clause.') point_bulan','measurement.kd_measurement = point_bulan.kd_measurement','LEFT');
        $this->db->where('measurement.kd_bd',$kd_bd);
        
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    
    public function get_list_score_bd_bulanan_setahun($kd_bd,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        $this->db->select('business_driver.kd_bd, 
				business_driver.kd_bds, 
				business_driver.nm_bd,
				business_driver_result.kd_bdr, 
				business_driver_result.bulan,
				business_driver_result.tahun,
				business_driver_result.point_result');
        $this->db->from('business_driver');
        $this->db->join('business_driver_result','business_driver.kd_bd = business_driver_result.kd_bd','LEFT');
        $this->db->where("concat(business_driver_result.tahun,if(business_driver_result.bulan<10,concat('0',business_driver_result.bulan),business_driver_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $this->db->where('business_driver_result.kd_bd', $kd_bd);

        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_list_score_bd_tahunan($kd_bd,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $ThnAwal= $tahun - 10;
        $ThnAkhir= $tahun;
        $this->db->select('business_driver.kd_bd, 
				business_driver.kd_bds, 
				business_driver.nm_bd,
				business_driver_result.tahun,
				round(avg(business_driver_result.point_result),2) as point_result');
        $this->db->from('business_driver');
        $this->db->join('business_driver_result','business_driver.kd_bd = business_driver_result.kd_bd','LEFT');
        $this->db->where("business_driver_result.tahun between '$ThnAwal' and '$ThnAkhir'", NULL);
        $this->db->where('business_driver_result.kd_bd', $kd_bd);
        $this->db->group_by("business_driver.kd_bd, 
				business_driver.kd_bds, 
				business_driver.nm_bd,
				business_driver_result.tahun");
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_list_score_bd_rekap_setahun_chart($kd_bd,$tahun,$bulan){
     
        
        $query = $this->get_list_score_bd_bulanan_setahun($kd_bd,$tahun,$bulan);
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut = 0;
        $temp_bd="";
        foreach($query->result() as $row){
            if($temp_bd!=$row->kd_bd){
                $temp_bd=$row->kd_bd;
                $NoUrut++;
            }
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
            $Data['bulan'][$row->tahun.$bulan]= getNamaBulanMin($row->bulan)." ".substr($row->tahun,2);
            $Data['legend'][$row->kd_bd]= $row->nm_bd;
            $Data['color'][$row->kd_bd]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_bd]["code"] =$row->kd_bd;
            $Data['data_grafik'][$row->kd_bd]["nama"] =$row->nm_bd;
            $Data['data_grafik'][$row->kd_bd]["score"][$row->tahun.$bulan] =$row->point_result;
        }
        return $Data;
    }
    public function get_list_score_bd_tahunan_chart($kd_bd,$tahun){
     
        
        $query = $this->get_list_score_bd_tahunan($kd_bd,$tahun);
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut = 0;
        $temp_bd="";
        foreach($query->result() as $row){
            if($temp_bd!=$row->kd_bd){
                $temp_bd=$row->kd_bd;
                $NoUrut++;
            }
            
            $Data['bulan'][$row->tahun]= substr($row->tahun,2);
            $Data['legend'][$row->kd_bd]= $row->nm_bd;
            $Data['color'][$row->kd_bd]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_bd]["code"] =$row->kd_bd;
            $Data['data_grafik'][$row->kd_bd]["nama"] =$row->nm_bd;
            $Data['data_grafik'][$row->kd_bd]["score"][$row->tahun] =$row->point_result;
        }
        return $Data;
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

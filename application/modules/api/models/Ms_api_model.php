<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ms_api_model extends CI_Model
{
    public function get_ms_by_code_bulanan_api($kd_measurement,$tahun,$bulan){
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
    public function get_dept_ms_bulanan_api($kd_measurement,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($tahun==""){
            $tahun=date("Y");
        }
        // $this->db->select('departemen_result.kd_dr,
        //                     departemen_result.kd_measurement,
        //                     departemen_result.kd_departemen,
        //                     departemen_result.target,
        //                     departemen_result.actual,
        //                     departemen_result.result,
        //                     departemen_result.type,
        //                     departemen_result.unit,
        //                     departemen_result.period,
        //                     departemen_result.bulan,
        //                     departemen_result.tahun,
        //                     round(ifnull(departemen_result.point_result,0),2) as gross_point_dept,
        //                     departemen_result.weightage_bd,
        //                     case
        //                             when (departemen_result.score_bd*4) > 4 then 4
        //                             else round(departemen_result.score_bd*4,2)
        //                     end point_dept');
        // $this->db->from('departemen_result');
        // $this->db->where('departemen_result.tahun', $tahun);
        // $this->db->where('departemen_result.bulan', $bulan);
        // $this->db->where('departemen_result.kd_measurement', $kd_measurement);
        // $where_clause = $this->db->get_compiled_select();
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
                            round(departemen_result.score_kpi,2) as point_dept');
        $this->db->from('departemen_result');
        $this->db->where('departemen_result.tahun', $tahun);
        $this->db->where('departemen_result.bulan', $bulan);
        $this->db->where('departemen_result.kd_measurement', $kd_measurement);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('departemen_result.kd_measurement,
                            departemen_result.kd_departemen,
                            round(ifnull(avg(departemen_result.point_result),0),2) as gross_point_dept,
                            round(avg(departemen_result.score_kpi),2) as point_dept');
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
        $i = -1;
        $j = 0;
        $Kd="";
        $ListType= ListType();
        $ListUnit= ListUnit();
        $ListUnitSimbol= ListUnitSimbol();
        foreach($query->result() as $row){
            $target_arr= explode(",", $row->target);
            $actual_arr= explode(",", $row->actual);
            $result_arr= explode(",", $row->result);
            $type_arr= explode(",", $row->type);
            $unit_arr= explode(",", $row->unit);
            $period_arr= explode(",", $row->period);
            $bulan_arr= explode(",", $row->bulan);
            //$tahun_arr= explode(",", $row->tahun);
            $point_result_arr= explode(",", $row->gross_point);
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
            
            $j=0;
            $i++;
            $Data[$i]['kd_departemen']=$row->kd_departemen;
            $Data[$i]['nm_departemen']=$row->nm_departemen;
            $Data[$i]['kd_measurement']=$row->kd_measurement;
            $Data[$i]['nm_measurement']=$row->nm_measurement;
            $Data[$i]['gross_point']=$row->gross_point;
            $Data[$i]['weightage']=$row->weightage_bd;
            $Data[$i]['point']=$row->point;
            if(isset($target_arr)){
                $no=1;
                $TotScore=0;
                foreach($target_arr as $key=>$val)
                {
                    $result=0;
                    if(isset($type_arr[$key])){
                    if($type_arr[$key]=='min'){
                        if($val>0){
                            $result=round(($actual_arr[$key]/$val),4);
                        }else{
                            $result = 0;
                        }
                    }else{
                        if($actual_arr[$key]>0){
                            $result=round(($val/$actual_arr[$key]),4);
                        }else{
                            $result = 0;
                        }

                    }
                    
                    $result=$result*100;
                    }
                    
                    $Data[$i]['detail_result'][$j]['periode']=getNamaBulanMin($bulan_arr[$key])." ".substr($row->tahun,2);
                    $Data[$i]['detail_result'][$j]['target']=$type_arr[$key]." ".number_to_money($val)." ".$ListUnitSimbol[$unit_arr[$key]];
                    $Data[$i]['detail_result'][$j]['actual']=number_to_money($actual_arr[$key]);
                    $Data[$i]['detail_result'][$j]['result']=$result."%";
                    $Data[$i]['detail_result'][$j]['gross_point']=$point_result_arr[$key];
                    $j++;
                }
            }
            
        }
        return $Data;
    }
    
    public function get_list_score_ms_rekap_setahun_chart_api($kd_measurement,$tahun,$bulan){
     
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
        //$this->db->where('measurement_result.tahun', $tahun);
        $this->db->where('measurement_result.kd_measurement', $kd_measurement);
        $this->db->where("concat(measurement_result.tahun,if(measurement_result.bulan<10,concat('0',measurement_result.bulan),measurement_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);

        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
        //$Data["Color"]='';
        $j = 0;
        foreach($query->result() as $row){
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
            $Data[$j]['periode']= getNamaBulanMin($row->bulan)." ".substr($row->tahun,2);
            $Data[$j]["score"] =$row->point_result;
            $j++;
        }
        return $Data;
    }
}

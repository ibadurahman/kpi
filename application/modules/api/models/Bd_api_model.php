<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bd_api_model extends CI_Model
{
    public function get_bd_by_code_bulanan_api($kd_bd,$tahun,$bulan){
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
    public function get_ms_bd_bulanan_api($kd_bd,$tahun,$bulan){
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
                        measurement.kd_bd,
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
			ifnull(point_bulan.gross_point_ms,0) as gross_point,
			ifnull(point_bulan.point_ms,0) as point",false);
        $this->db->from('measurement');
        $this->db->join('business_driver','measurement.kd_bd = business_driver.kd_bd','LEFT');
        $this->db->join('('.$where_clause.') point_bulan','measurement.kd_measurement = point_bulan.kd_measurement','LEFT');
        $this->db->join('('.$where_clause2.') point_tahun','measurement.kd_measurement = point_tahun.kd_measurement','LEFT');
        $this->db->where('measurement.kd_bd',$kd_bd);
        
        
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
            $Data[$i]['kd_measurement']=$row->kd_measurement;
            $Data[$i]['nm_measurement']=$row->nm_measurement;
            $Data[$i]['kd_bd']=$row->kd_bd;
            $Data[$i]['nm_bd']=$row->nm_bd;
            $Data[$i]['gross_point']=$row->gross_point;
            $Data[$i]['weightage']=$row->weightage;
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
    
    public function get_list_score_bd_rekap_setahun_chart_api($kd_bd,$tahun,$bulan){
     
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
        //$this->db->where('business_driver_result.tahun', $tahun);
        $this->db->where('business_driver_result.kd_bd', $kd_bd);
        $this->db->where("concat(business_driver_result.tahun,if(business_driver_result.bulan<10,concat('0',business_driver_result.bulan),business_driver_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);

        
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

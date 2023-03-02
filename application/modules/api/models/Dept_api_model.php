<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dept_api_model extends CI_Model
{
    public function get_dept_by_code_bulanan_api($kd_departemen,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $this->db->select('departemen_result.kd_departemen,
				departemen_result.score_kpi as kpi_dept');
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->where('departemen_result.tahun', $tahun);
        $this->db->where('departemen_result.bulan', $bulan);
        $this->db->where('departemen_result.kd_departemen', $kd_departemen);
        
        // $this->db->group_by('departemen_result.kd_departemen');
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('departemen.*,
			round(tbl_kpi.kpi_dept,2) kpi_dept');
        $this->db->from('departemen');
        $this->db->join('('.$where_clause.')tbl_kpi','departemen.kd_departemen = tbl_kpi.kd_departemen','LEFT');
        $this->db->where('departemen.kd_departemen', $kd_departemen);
        
        $this->db->order_by('departemen.kd_departemen');
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_dept_detail_ms_bulanan_api($kd_departemen,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $this->db->select('departemen_result.kd_departemen,
				departemen_result.score_kpi as kpi_dept');
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->where('departemen_result.tahun', $tahun);
        $this->db->where('departemen_result.bulan', $bulan);
        $this->db->where('departemen_result.kd_departemen', $kd_departemen);
        
        // $this->db->group_by('departemen_result.kd_departemen');
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
        $this->db->where('departemen_result.kd_departemen', $kd_departemen);
        
        $this->db->order_by('departemen_result.kd_departemen');
        
        
        $query=$this->db->get();
        
        $ListPeg= $this->get_dept_detail_peg_bulanan_api($kd_departemen, $tahun, $bulan);
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
            $point_result_arr= explode(",", $row->gross_result);
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
            
            $j=0;
            $i++;
            $Data[$i]['kd_measurement']=$row->kd_measurement;
            $Data[$i]['nm_measurement']=$row->nm_measurement;
            $Data[$i]['gross_point']=$row->gross_result;
            $Data[$i]['weightage']=$row->weightage_kpi;
            $Data[$i]['point']=$row->score_kpi;
            $Data[$i]['detail_pegawai']=$ListPeg[$row->kd_measurement];
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
    public function get_dept_detail_peg_bulanan_api($kd_departemen,$tahun,$bulan){
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
        $this->db->order_by('appraisal_detail.kd_measurement');
        
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        $i = -1;
        $j = 0;
        $Kd="";
        foreach($query->result() as $row){
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
            if($Kd!=$row->kd_measurement){
            $i=0;
            $Kd=$row->kd_measurement;
            }
            $Data[$row->kd_measurement][$i]['nip']=$row->nip;
            $Data[$row->kd_measurement][$i]['nama']=$row->nama;
            $Data[$row->kd_measurement][$i]['kd_jabatan']=$row->kd_jabatan;
            $Data[$row->kd_measurement][$i]['nm_jabatan']=$row->nm_jabatan;
            $Data[$row->kd_measurement][$i]['gross_point']=$row->gross_result;
            $Data[$row->kd_measurement][$i]['weightage']=$row->weightage_bd;
            $Data[$row->kd_measurement][$i]['point']=$row->score_result;
            $Data[$row->kd_measurement][$i]['image']='';
            
            $i++;
            
        }
        return $Data;
    }
    
    public function get_list_score_dept_rekap_setahun_chart_api($kd_departemen,$tahun,$bulan){
     
        if($tahun==""){
            $tahun=date("Y");
        }
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        $this->db->select('departemen_result.kd_departemen,
                            departemen.nm_departemen,
                            departemen_result.bulan,
                            departemen_result.tahun,
                            departemen_result.score_kpi as kpi_dept');
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        //$this->db->where('departemen_result.tahun', $tahun);
        $this->db->where('departemen_result.kd_departemen', $kd_departemen);
        $this->db->where("concat(departemen_result.tahun,if(departemen_result.bulan<10,concat('0',departemen_result.bulan),departemen_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        // $this->db->group_by('departemen_result.bulan,
		// 	departemen_result.tahun,
 		// 	departemen_result.kd_departemen,
		// 	departemen.nm_departemen');

        
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
            $Data[$j]["score"] =$row->kpi_dept;
            $j++;
        }
        return $Data;
    }
}

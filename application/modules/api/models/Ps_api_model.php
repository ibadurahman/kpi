<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ps_api_model extends CI_Model
{
    public function get_perusahaan_kpi($kd_perusahaan,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('perspective_result.kd_pr,
                            perspective_result.kd_perspective,
                            round(perspective_result.score, 2) point_perspective');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $this->db->where('perspective_result.bulan', $bulan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('perspective_result.kd_perspective,
                            round(avg(perspective_result.score),2) point_perspective');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $this->db->group_by('perspective_result.kd_perspective');
        $where_clause2 = $this->db->get_compiled_select();

        $this->db->select("perspective.kd_perspective,
			perspective.kd_ps,
                        perspective.kd_perusahaan,
			perspective.nm_perspective,
			ifnull(point_bulan.point_perspective,0) as point_bulan,
			ifnull(point_tahun.point_perspective,0) as point_tahun",false);
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') point_bulan','perspective.kd_perspective = point_bulan.kd_perspective','LEFT');
        $this->db->join('('.$where_clause2.') point_tahun','perspective.kd_perspective = point_tahun.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $where_clause3 = $this->db->get_compiled_select();
        
        $this->db->select("perusahaan.kd_perusahaan,
			perusahaan.nm_perusahaan,
			ifnull(round(sum(tbl_point.point_bulan),2),0) as point_bulan,
			ifnull(round(sum(tbl_point.point_tahun),2),0) as point_tahun",false);
        $this->db->from('perusahaan');
        $this->db->join('('.$where_clause3.') tbl_point','perusahaan.kd_perusahaan = tbl_point.kd_perusahaan','LEFT');
        $this->db->where('perusahaan.kd_perusahaan',$kd_perusahaan);
        $this->db->group_by('perusahaan.kd_perusahaan,
			perusahaan.nm_perusahaan');
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function dashboard_perspective_bulanan($kd_perusahaan,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('perspective_result.kd_pr,
                            perspective_result.kd_perspective,
                            round(perspective_result.point_result,2) as gross_point,
                            perspective_result.weightage,
                            round(perspective_result.score, 2) point_perspective');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $this->db->where('perspective_result.bulan', $bulan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('perspective_result.kd_perspective,
                            round(avg(perspective_result.point_result),2) as gross_point,
                            round(avg(perspective_result.score),2) point_perspective');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $this->db->group_by('perspective_result.kd_perspective');
        $where_clause2 = $this->db->get_compiled_select();

        $this->db->select("perspective.kd_perspective,
			perspective.kd_ps,
                        perspective.kd_perusahaan,
			perspective.nm_perspective,
			ifnull(point_bulan.weightage,0) as weightage,
			ifnull(point_bulan.gross_point,0) as gross_point,
			ifnull(point_bulan.point_perspective,0) as point,
			ifnull(point_tahun.gross_point,0) as gross_point_tahun,
			ifnull(point_tahun.point_perspective,0) as point_tahun",false);
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') point_bulan','perspective.kd_perspective = point_bulan.kd_perspective','LEFT');
        $this->db->join('('.$where_clause2.') point_tahun','perspective.kd_perspective = point_tahun.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    
    public function get_perusahaan_kpi_chart_periode($kd_perusahaan,$tahun, $bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if(strlen($bulan)<2){
            $bulan='0'.$bulan;
        }
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        $this->db->select('perspective.kd_perspective, 
				perspective.kd_ps, 
				perspective.kd_perusahaan, 
				perspective.nm_perspective,
				perspective_result.kd_pr, 
				perspective_result.bulan,
				perspective_result.tahun,
				round(perspective_result.score, 2) point_perspective');
        $this->db->from('perspective');
        $this->db->join('perspective_result','perspective.kd_perspective = perspective_result.kd_perspective','LEFT');
        //$this->db->where('perspective_result.tahun', $tahun);
        $this->db->where("concat(perspective_result.tahun,if(perspective_result.bulan<10,concat('0',perspective_result.bulan),perspective_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $where_clause = $this->db->get_compiled_select();

        $tgl=$tahun."-".$bulan."-".$bulan;
        $this->db->select("date_format(concat(tbl_point.tahun,'-',tbl_point.bulan,'-',tbl_point.bulan),'%b %y') as periode,
			ifnull(round(sum(tbl_point.point_perspective),2),0) as point",false);
        $this->db->from('perusahaan');
        $this->db->join('('.$where_clause.') tbl_point','perusahaan.kd_perusahaan = tbl_point.kd_perusahaan','LEFT');
        $this->db->where('perusahaan.kd_perusahaan',$kd_perusahaan);
        $this->db->group_by('perusahaan.kd_perusahaan,
			perusahaan.nm_perusahaan,
			tbl_point.bulan,
			tbl_point.tahun');
        $query=$this->db->get();
    //    echo $this->db->last_query();
    //    die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    
    public function get_perspective_bar_chart_bulan($kd_perusahaan,$tahun,$bulan){
        
        if(strlen($bulan)<2){
            $bulan='0'.$bulan;
        }
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        
        $this->db->select("perspective_result.kd_perspective,
                            perspective_result.tahun,
                            perspective_result.bulan,
                            (sum(perspective_result.point_result)) as score",FALSE);
        $this->db->from('perspective_result');
        $this->db->join('perspective','perspective.kd_perspective = perspective_result.kd_perspective');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->where("concat(perspective_result.tahun,if(perspective_result.bulan<10,concat('0',perspective_result.bulan),perspective_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $this->db->group_by("perspective_result.kd_perspective,perspective_result.tahun,perspective_result.bulan");
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("perspective.kd_perspective,
                            perspective.kd_ps,
                            tbl_result.bulan,
                            tbl_result.tahun,
                            perspective.nm_perspective,
                            tbl_result.score",FALSE);
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') as tbl_result',"tbl_result.kd_perspective = perspective.kd_perspective",'LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->order_by("perspective.kd_perspective,tbl_result.tahun,tbl_result.bulan");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        //$Data["Color"]='';
        $i = -1;
        $j = 0;
        $KdPs="";
        foreach($query->result() as $row){
            
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
            if($KdPs != $row->kd_perspective){
                $j=0;
                $i++;
                $Data[$i]['kd_perspective']=$row->kd_perspective;
                $Data[$i]['nm_perspective']=$row->nm_perspective;
                $KdPs=$row->kd_perspective;
            }
            $Data[$i]['data_chart'][$j]['periode']= getNamaBulanMin($row->bulan)." ".substr($row->tahun,2);
            $Data[$i]['data_chart'][$j]["score"] =$row->score;
            $j++;
        }
        return $Data;
    }
    public function get_perspective_by_kd_perspective($kd_perspective,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('perspective_result.kd_pr,
                            perspective_result.kd_perspective,
                            round(perspective_result.point_result,2) as gross_point,
                            perspective_result.weightage,
                            perspective_result.point_result as point_perspective');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $this->db->where('perspective_result.bulan', $bulan);
        $this->db->where('perspective_result.kd_perspective',$kd_perspective);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('perspective_result.kd_perspective,
                            round(avg(perspective_result.point_result),2) as gross_point,
                            round(avg(perspective_result.score),2) as point_perspective');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $this->db->where('perspective_result.kd_perspective',$kd_perspective);
        $this->db->group_by('perspective_result.kd_perspective');
        $where_clause2 = $this->db->get_compiled_select();

        $this->db->select("perspective.kd_perspective,
			perspective.kd_ps,
                        perspective.kd_perusahaan,
			perspective.nm_perspective,
			ifnull(point_bulan.weightage,0) as weightage,
			ifnull(point_bulan.gross_point,0) as gross_point_bulan,
			ifnull(point_bulan.point_perspective,0) as point_bulan,
			ifnull(point_tahun.gross_point,0) as gross_point_tahun,
			ifnull(point_tahun.point_perspective,0) as point_tahun",false);
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') point_bulan','perspective.kd_perspective = point_bulan.kd_perspective','LEFT');
        $this->db->join('('.$where_clause2.') point_tahun','perspective.kd_perspective = point_tahun.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perspective',$kd_perspective);
        
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function perspective_bd_bulanan($kd_perspective,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('business_driver_result.kd_bdr,
                            business_driver_result.kd_bd,
                            round(ifnull(business_driver_result.point_result,0),2) as gross_point_bd,
                            business_driver_result.weightage,
                            round(business_driver_result.score,2) as point_business_driver');
        $this->db->from('business_driver_result');
        $this->db->where('business_driver_result.tahun', $tahun);
        $this->db->where('business_driver_result.bulan', $bulan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('business_driver_result.kd_bd,
                            round(ifnull(avg(business_driver_result.point_result),0),2) as gross_point_bd,
                            round(avg(business_driver_result.score),2) as point_business_driver');
        $this->db->from('business_driver_result');
        $this->db->where('business_driver_result.tahun', $tahun);
        $this->db->group_by('business_driver_result.kd_bd');
        $where_clause2 = $this->db->get_compiled_select();

        $this->db->select("business_driver.kd_bd,
			business_driver.kd_bds,
                        business_driver.nm_bd,
			perspective.nm_perspective,
                        point_bulan.weightage,
			ifnull(point_bulan.gross_point_bd,0) as gross_point,
			ifnull(point_bulan.point_business_driver,0) as point,
			ifnull(point_tahun.gross_point_bd,0) as gross_point_tahun,
			ifnull(point_tahun.point_business_driver,0) as point_tahun",false);
        $this->db->from('business_driver');
        $this->db->join('perspective','perspective.kd_perspective = business_driver.kd_perspective','LEFT');
        $this->db->join('('.$where_clause.') point_bulan','business_driver.kd_bd = point_bulan.kd_bd','LEFT');
        $this->db->join('('.$where_clause2.') point_tahun','business_driver.kd_bd = point_tahun.kd_bd','LEFT');
        $this->db->where('business_driver.kd_perspective',$kd_perspective);
        
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_perspective_bar_chart_bulan_kd_perspective($kd_perspective,$tahun,$bulan){
        
        if(strlen($bulan)<2){
            $bulan = '0'.$bulan;
        }
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        
        $this->db->select('perspective.kd_perspective, 
				perspective.kd_ps, 
				perspective.kd_perusahaan, 
				perspective.nm_perspective,
				perspective_result.kd_pr, 
				perspective_result.bulan,
				perspective_result.tahun,
				perspective_result.point_result as score');
        $this->db->from('perspective');
        $this->db->join('perspective_result','perspective.kd_perspective = perspective_result.kd_perspective','LEFT');
        // $this->db->where('perspective_result.tahun', $tahun);
        $this->db->where("concat(perspective_result.tahun,if(perspective_result.bulan<10,concat('0',perspective_result.bulan),perspective_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $this->db->where('perspective_result.kd_perspective', $kd_perspective);

        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
        //$Data["Color"]='';
        $i = -1;
        $j = 0;
        $KdPs="";
        foreach($query->result() as $row){
            
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
//            if($KdPs != $row->kd_perspective){
//                $j=0;
//                $i++;
//                $Data[$i]['kd_perspective']=$row->kd_perspective;
//                $Data[$i]['nm_perspective']=$row->nm_perspective;
//                $KdPs=$row->kd_perspective;
//            }
            $Data[$j]['periode']= getNamaBulanMin($row->bulan)." ".substr($row->tahun,2);
            $Data[$j]["score"] =$row->score;
            $j++;
        }
        return $Data;
    }
//-------------------------------------------------------------------------------------------------------------------------------------------
    public function dashboard_perspective_tahunan($kd_perusahaan,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('perspective_result.kd_perspective,
                            group_concat(perspective_result.weightage) weightage,
                            perspective_result.tahun,
                            round(avg(perspective_result.point_result),2) as gross_point,
                            case
                                    when round(avg(perspective_result.score)*4,2) > 4 then 4
                                    else round(avg(perspective_result.score)*4,2)
                            end point_perspective');
        $this->db->from('perspective_result');
        $this->db->where("perspective_result.tahun", $tahun);
        $this->db->group_by('perspective_result.tahun,perspective_result.kd_perspective');
        $where_clause = $this->db->get_compiled_select();

        $this->db->select("perspective.kd_perspective,
			perspective.kd_ps,
                        perspective.kd_perusahaan,
			perspective.nm_perspective,
                        point_bulan.tahun,
			ifnull(point_bulan.weightage,0) as weightage,
			ifnull(point_bulan.gross_point,0) as gross_point,
			ifnull(point_bulan.point_perspective,0) as point",false);
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') point_bulan','perspective.kd_perspective = point_bulan.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    
    public function get_point_perusahaan($kd_perusahaan,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('perspective_result.kd_pr,
                            perspective_result.kd_perspective,
                            case
                                    when (perspective_result.score*4) > 4 then 4
                                    else round(perspective_result.score*4,2)
                            end point_perspective');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $this->db->where('perspective_result.bulan', $bulan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('perspective_result.kd_perspective,
                            case
                                    when (avg(perspective_result.score)*4) > 4 then 4
                                    else round(avg(perspective_result.score)*4,2)
                            end point_perspective');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $this->db->group_by('perspective_result.kd_perspective');
        $where_clause2 = $this->db->get_compiled_select();

        $this->db->select("perspective.kd_perspective,
			perspective.kd_ps,
                        perspective.kd_perusahaan,
			perspective.nm_perspective,
			ifnull(point_bulan.point_perspective,0) as point_bulan,
			ifnull(point_tahun.point_perspective,0) as point_tahun",false);
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') point_bulan','perspective.kd_perspective = point_bulan.kd_perspective','LEFT');
        $this->db->join('('.$where_clause2.') point_tahun','perspective.kd_perspective = point_tahun.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $where_clause3 = $this->db->get_compiled_select();
        
        $this->db->select("perusahaan.kd_perusahaan,
			perusahaan.nm_perusahaan,
			ifnull(round(sum(tbl_point.point_bulan),2),0) as point_bulan,
			ifnull(round(sum(tbl_point.point_tahun),2),0) as point_tahun",false);
        $this->db->from('perusahaan');
        $this->db->join('('.$where_clause3.') tbl_point','perusahaan.kd_perusahaan = tbl_point.kd_perusahaan','LEFT');
        $this->db->where('perusahaan.kd_perusahaan',$kd_perusahaan);
        $this->db->group_by('perusahaan.kd_perusahaan,
			perusahaan.nm_perusahaan');
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_list_score_perusahaan_range_tahunan($kd_perusahaan,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $ThnAwal= $tahun - 10;
        $ThnAkhir= $tahun;
        $this->db->select('perspective.kd_perspective, 
				perspective.kd_ps, 
				perspective.kd_perusahaan, 
				perspective.nm_perspective,
				perspective_result.kd_pr, 
				perspective_result.bulan,
				perspective_result.tahun,
				case
					when (perspective_result.score*4) > 4 then 4
					else round(perspective_result.score*4, 2)
				end point_perspective');
        $this->db->from('perspective');
        $this->db->join('perspective_result','perspective.kd_perspective = perspective_result.kd_perspective','LEFT');
        $this->db->where("perspective_result.tahun between '$ThnAwal' and '$ThnAkhir'", NULL);
        $where_clause = $this->db->get_compiled_select();

        
        $this->db->select("perusahaan.kd_perusahaan,
			perusahaan.nm_perusahaan,
			tbl_point.bulan,
			tbl_point.tahun,
			ifnull(round(sum(tbl_point.point_perspective),2),0) as point",false);
        $this->db->from('perusahaan');
        $this->db->join('('.$where_clause.') tbl_point','perusahaan.kd_perusahaan = tbl_point.kd_perusahaan','LEFT');
        $this->db->where('perusahaan.kd_perusahaan',$kd_perusahaan);
        $this->db->group_by('perusahaan.kd_perusahaan,
			perusahaan.nm_perusahaan,
			tbl_point.bulan,
			tbl_point.tahun');
        $where_clause2 = $this->db->get_compiled_select();
        
        $this->db->select("perusahaan.kd_perusahaan,
			perusahaan.nm_perusahaan,
			tbl_point.tahun,
			ifnull(avg(round(tbl_point.point,2)),0) as point",false);
        $this->db->from('perusahaan');
        $this->db->join('('.$where_clause2.') tbl_point','perusahaan.kd_perusahaan = tbl_point.kd_perusahaan','LEFT');
        $this->db->where('perusahaan.kd_perusahaan',$kd_perusahaan);
        $this->db->group_by('perusahaan.kd_perusahaan,
			perusahaan.nm_perusahaan,
			tbl_point.tahun');
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_list_score_perusahaan_tahunan_chart($kd_perusahaan,$tahun){
     
        
        $query = $this->get_list_score_perusahaan_tahunan($kd_perusahaan,$tahun);
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        foreach($query->result() as $row){
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
            $Data['bulan'][$row->tahun.$bulan]= getNamaBulanMin($row->bulan)." ".substr($row->tahun,2);
            $Data['legend'][$row->kd_perusahaan]= $row->nm_perusahaan;
            $Data['color'][$row->kd_perusahaan]= $this->rand_color();
            $Data['data_grafik'][$row->kd_perusahaan]["code"] =$row->kd_perusahaan;
            $Data['data_grafik'][$row->kd_perusahaan]["nama"] =$row->nm_perusahaan;
            $Data['data_grafik'][$row->kd_perusahaan]["score"][$row->tahun.$bulan] =$row->point;
        }
        return $Data;
    }
    public function get_list_score_perusahaan_chart_pertahun($kd_perusahaan,$tahun){
     
        
        $query = $this->get_list_score_perusahaan_range_tahunan($kd_perusahaan,$tahun);
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        foreach($query->result() as $row){
            
            $Data['bulan'][$row->tahun]= substr($row->tahun,2);
            $Data['legend'][$row->kd_perusahaan]= $row->nm_perusahaan;
            $Data['color'][$row->kd_perusahaan]= $this->rand_color();
            $Data['data_grafik'][$row->kd_perusahaan]["code"] =$row->kd_perusahaan;
            $Data['data_grafik'][$row->kd_perusahaan]["nama"] =$row->nm_perusahaan;
            $Data['data_grafik'][$row->kd_perusahaan]["score"][$row->tahun] =$row->point;
        }
        return $Data;
    }
    function rand_color() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
    
    public function get_perspective_radar_chart_bulan($kd_perusahaan,$tahun,$bulan){
     
        
        $query = $this->dashboard_perspective_bulanan($kd_perusahaan, $tahun, $bulan);
//        echo $this->db->last_query();
//        die();
        $Data["Label"]='';
        $Data["Value"]='';
        //$Data["Color"]='';
        foreach($query->result() as $row){
            $Data["Label"] .="'".$row->kd_ps."',";
            $Data["Value"] .=$row->gross_point.",";
//            $Data["Color"] .="'".$this->rand_color()."',";
        }
        return $Data;
    }
    public function get_perspective_radar_chart_tahun($kd_perusahaan,$tahun){
     
        
        $query = $this->dashboard_perspective_tahunan($kd_perusahaan, $tahun);
//        echo $this->db->last_query();
//        die();
        $Data["Label"]='';
        $Data["Value"]='';
        //$Data["Color"]='';
        foreach($query->result() as $row){
            $Data["Label"] .="'".$row->kd_ps."',";
            $Data["Value"] .=$row->gross_point.",";
//            $Data["Color"] .="'".$this->rand_color()."',";
        }
        return $Data;
    }
    public function get_perspective_bar_chart_tahun($kd_perusahaan,$tahun){
     
        $thnAwal=$tahun-10;
        
        $this->db->select("perspective_result.kd_perspective,
                            perspective_result.tahun,
                            round(avg(perspective_result.score),2) as score",FALSE);
        $this->db->from('perspective_result');
        $this->db->join('perspective','perspective.kd_perspective = perspective_result.kd_perspective');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->where("perspective_result.tahun between '$thnAwal' and '$tahun'",NULL);
        $this->db->group_by("perspective_result.kd_perspective,perspective_result.tahun");
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("perspective.kd_perspective,
                            perspective.kd_ps,
                            tbl_result.tahun,
                            perspective.nm_perspective,
                            tbl_result.score",FALSE);
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') as tbl_result',"tbl_result.kd_perspective = perspective.kd_perspective",'LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->order_by("tbl_result.tahun");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut = 1;
        foreach($query->result() as $row){
            
            $Data['bulan'][$row->tahun]= substr($row->tahun,2);
            $Data['legend'][$row->kd_perspective]= $row->nm_perspective;
            $Data['color'][$row->kd_perspective]= $this->rand_color();
            $Data['data_grafik'][$row->kd_perspective]["code"] =$row->kd_ps;
            $Data['data_grafik'][$row->kd_perspective]["nama"] =$row->nm_perspective;
            $Data['data_grafik'][$row->kd_perspective]["score"][$row->tahun] =$row->score;
            $NoUrut++;
        }
        return $Data;
    }
}

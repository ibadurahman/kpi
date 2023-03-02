<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function get_perusahaan_by_code_dashboard($kd_perusahaan){
        
        $this->db->select("perusahaan.*");
        $this->db->from('perusahaan');
        $this->db->where('perusahaan.kd_perusahaan',$kd_perusahaan);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function dashboard_perspective_bulanan($kd_perusahaan,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('perspective_result.kd_pr,
                            perspective_result.kd_perspective,
                            round(perspective_result.point_result,2) as gross_point,
                            perspective_result.weightage,
                            round(perspective_result.score,2) as point_perspective');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $this->db->where('perspective_result.bulan', $bulan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('perspective_result.kd_perspective,
                            round(avg(perspective_result.point_result),2) as gross_point,
                            round(avg(perspective_result.score),2) as point_perspective');
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
    public function dashboard_perspective_tahunan($kd_perusahaan,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('perspective_result.kd_perspective,
                            group_concat(perspective_result.weightage) weightage,
                            perspective_result.tahun,
                            round(avg(perspective_result.point_result),2) as gross_point,
                            round(avg(perspective_result.score),2) as point_perspective');
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
    public function get_list_score_perusahaan_tahunan($kd_perusahaan,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
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
				round(perspective_result.score, 2)as point_perspective');
        $this->db->from('perspective');
        $this->db->join('perspective_result','perspective.kd_perspective = perspective_result.kd_perspective','LEFT');
        //$this->db->where('perspective_result.tahun', $tahun);
        $this->db->where("concat(perspective_result.tahun,if(perspective_result.bulan<10,concat('0',perspective_result.bulan),perspective_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
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
			tbl_point.tahun,
			tbl_point.bulan');
        $query=$this->db->get();
    //    echo $this->db->last_query();
    //    die();
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
				round(perspective_result.score, 2) as point_perspective');
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
    public function get_list_score_perusahaan_tahunan_chart($kd_perusahaan,$tahun,$bulan){
     
        
        $query = $this->get_list_score_perusahaan_tahunan($kd_perusahaan,$tahun,$bulan);
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $temp_perush="";
        $NoUrut=0;
        foreach($query->result() as $row){
            if($temp_perush!=$row->kd_perusahaan){
                $temp_perush=$row->kd_perusahaan;
                $NoUrut++;
            }
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
            $Data['bulan'][$row->tahun.$bulan]= getNamaBulanMin($row->bulan)." ".substr($row->tahun,2);
            $Data['legend'][$row->kd_perusahaan]= $row->nm_perusahaan;
            $Data['color'][$row->kd_perusahaan]= $this->list_warna($NoUrut);
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
        $temp_perush="";
        $NoUrut=0;
        foreach($query->result() as $row){
            
            if($temp_perush!=$row->kd_perusahaan){
                $temp_perush=$row->kd_perusahaan;
                $NoUrut++;
            }
            $Data['bulan'][$row->tahun]= substr($row->tahun,2);
            $Data['legend'][$row->kd_perusahaan]= $row->nm_perusahaan;
            $Data['color'][$row->kd_perusahaan]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_perusahaan]["code"] =$row->kd_perusahaan;
            $Data['data_grafik'][$row->kd_perusahaan]["nama"] =$row->nm_perusahaan;
            $Data['data_grafik'][$row->kd_perusahaan]["score"][$row->tahun] =$row->point;
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
    public function get_perspective_bar_chart_bulan($kd_perusahaan,$bulan,$tahun){
     
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        $TglAwal=$thnAwal."-".$bulan."-".$bulan;
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
//         $sql="SELECT tbl_ps.kd_perspective, 
//			tbl_ps.kd_ps, 
//			tbl_result.bulan, 
//			tbl_result.tahun, 
//			tbl_ps.nm_perspective, 
//			ifnull(tbl_result.score,0)score,
//			tbl_ps.period,
//			tbl_ps.bln
//                FROM (
//                        select perspective.kd_perspective,
//                                                perspective.kd_ps,
//                                                perspective.nm_perspective,
//                                                perspective.kd_perusahaan,
//                                                tbl_period.period,
//                                                tbl_period.bln
//                        from perspective,
//                        (select date_format(data_tgl.tgl,'%Y%m') period, date_format(data_tgl.tgl,'%Y-%m') as bln
//                        from(
//                                select ? as tgl,0 as jml
//                                union
//                                select date_add( ? , interval tbl_bln.m MONTH) as tgl, tbl_bln.m
//                                        from(
//                                                select @rownum:=@rownum+1 as m from
//                                                (select 1 union select 2 union select 3) t1,
//                                                (select 1 union select 2 ) t2,
//                                                (select 1 union select 2 ) t3,
//                                                (select @rownum:=0) t0
//                                        )tbl_bln
//                                )data_tgl
//                        )tbl_period
//                        where perspective.kd_perusahaan= ?
//                ) tbl_ps
//                LEFT JOIN (
//                        SELECT perspective_result.kd_perspective, 
//                                                perspective_result.tahun, 
//                                                perspective_result.bulan, 
//                                                (sum(perspective_result.point_result)) as score,
//                                                concat( perspective_result.tahun,if(length(perspective_result.bulan)<2,concat('0',perspective_result.bulan),perspective_result.bulan)) as period 
//                        FROM `perspective_result` 
//                        JOIN `perspective` ON `perspective`.`kd_perspective` = `perspective_result`.`kd_perspective` 
//                        WHERE `perspective`.`kd_perusahaan` = ? 
//                        AND concat(perspective_result.tahun,if(perspective_result.bulan < 10,concat('0',perspective_result.bulan),perspective_result.bulan)) between ? and ? 
//                        GROUP BY `perspective_result`.`kd_perspective`, `perspective_result`.`tahun`, `perspective_result`.`bulan`
//                ) as tbl_result ON tbl_result.kd_perspective = tbl_ps.kd_perspective and tbl_ps.period = tbl_result.period
//                WHERE `tbl_ps`.`kd_perusahaan` = ? 
//                ORDER BY `tbl_ps`.`kd_perspective`, `tbl_ps`.`period`";
//        $bind=[$TglAwal,$TglAwal,$kd_perusahaan,$kd_perusahaan,$PeriodeAwal,$PeriodeAkhir,$kd_perusahaan];
//        $query = $this->db->query($sql,$bind);
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut = 0;
        $temp_ps="";
        foreach($query->result() as $row){
            if($temp_ps!=$row->kd_perspective){
                $temp_ps=$row->kd_perspective;
                $NoUrut++;
            }
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
            $Data['bulan'][$row->tahun.$bulan]= getNamaBulanMin($row->bulan)." ".substr($row->tahun,2);
            $Data['legend'][$row->kd_perspective]= $row->nm_perspective;
            $Data['color'][$row->kd_perspective]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_perspective]["code"] =$row->kd_ps;
            $Data['data_grafik'][$row->kd_perspective]["nama"] =$row->nm_perspective;
            $Data['data_grafik'][$row->kd_perspective]["score"][$row->tahun.$row->bulan] =$row->score;
            
//            $period= explode("-", $row->bln);
//            $bulan=$period[1];
//            $tahun=$period[0];
//            
//            $Data['bulan'][$row->period]= getNamaBulanMin($bulan)." ".substr($tahun,2);
//            $Data['legend'][$row->kd_perspective]= $row->nm_perspective;
//            $Data['color'][$row->kd_perspective]= $this->list_warna($NoUrut);
//            $Data['data_grafik'][$row->kd_perspective]["code"] =$row->kd_ps;
//            $Data['data_grafik'][$row->kd_perspective]["nama"] =$row->nm_perspective;
//            $Data['data_grafik'][$row->kd_perspective]["score"][$row->period] =$row->score;
            
        }
        return $Data;
    }
    public function get_perspective_bar_chart_tahun($kd_perusahaan,$tahun){
     
        $thnAwal=$tahun-10;
        
        $this->db->select("perspective_result.kd_perspective,
                            perspective_result.tahun,
                            round(avg(perspective_result.point_result),2) as score",FALSE);
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
        $this->db->order_by("perspective.kd_perspective,tbl_result.tahun");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut = 0;
        $temp_ps="";
        foreach($query->result() as $row){
            if($temp_ps!=$row->kd_perspective){
                $temp_ps=$row->kd_perspective;
                $NoUrut++;
            }
            
            $Data['bulan'][$row->tahun]= substr($row->tahun,2);
            $Data['legend'][$row->kd_perspective]= $row->nm_perspective;
            $Data['color'][$row->kd_perspective]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_perspective]["code"] =$row->kd_ps;
            $Data['data_grafik'][$row->kd_perspective]["nama"] =$row->nm_perspective;
            $Data['data_grafik'][$row->kd_perspective]["score"][$row->tahun] =$row->score;
            
        }
        return $Data;
    }
}

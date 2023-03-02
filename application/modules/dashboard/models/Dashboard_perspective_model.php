<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_perspective_model extends CI_Model
{
    public function get_perspective_by_code_bulanan($kd_perspective,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $this->db->select('perspective_result.kd_pr,
                            perspective_result.kd_perspective,
                            perspective_result.point_result');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $this->db->where('perspective_result.bulan', $bulan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("perspective.kd_perspective,perspective.kd_ps,perspective.nm_perspective,ifnull(tbl_ps.point_result,0) point_result ");
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') tbl_ps','perspective.kd_perspective = tbl_ps.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perspective',$kd_perspective);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_perspective_by_code_tahunan($kd_perspective,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('perspective_result.kd_pr,
                            perspective_result.kd_perspective,
                            perspective_result.point_result');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("perspective.kd_perspective,perspective.kd_ps,perspective.nm_perspective,ifnull(round(avg(tbl_ps.point_result),2),0)point_result");
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') tbl_ps','perspective.kd_perspective = tbl_ps.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perspective',$kd_perspective);
        $this->db->group_by("perspective.kd_perspective,perspective.kd_ps,perspective.nm_perspective");
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function dashboard_bd_bulanan($kd_perspective,$tahun,$bulan){
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
    public function dashboard_bd_tahunan($kd_perspective,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('business_driver_result.kd_bd,
                            group_concat(business_driver_result.weightage) weightage,
                            business_driver_result.tahun,
                            round(avg(business_driver_result.point_result),2) as gross_point,
                            round(avg(business_driver_result.score),2) as point_bd');
        $this->db->from('business_driver_result');
        $this->db->where("business_driver_result.tahun", $tahun);
        $this->db->group_by('business_driver_result.tahun,business_driver_result.kd_bd');
        $where_clause = $this->db->get_compiled_select();

        $this->db->select("business_driver.kd_bd,
			business_driver.kd_bds,
                        business_driver.nm_bd,
			perspective.nm_perspective,
                        point_bulan.tahun,
			ifnull(point_bulan.weightage,0) as weightage,
			ifnull(point_bulan.gross_point,0) as gross_point,
			ifnull(point_bulan.point_bd,0) as point",false);
        $this->db->from('business_driver');
        $this->db->join('perspective','perspective.kd_perspective = business_driver.kd_perspective','LEFT');
        $this->db->join('('.$where_clause.') point_bulan','business_driver.kd_bd = point_bulan.kd_bd','LEFT');
        $this->db->where('business_driver.kd_perspective',$kd_perspective);
        
        
        $query=$this->db->get();
    //    echo $this->db->last_query();
    //    die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    
    public function get_list_score_ps_bulanan_setahun($kd_perspective,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
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
				perspective_result.point_result');
        $this->db->from('perspective');
        $this->db->join('perspective_result','perspective.kd_perspective = perspective_result.kd_perspective','LEFT');
        // $this->db->where('perspective_result.tahun', $tahun);
        $this->db->where("concat(perspective_result.tahun,if(perspective_result.bulan<10,concat('0',perspective_result.bulan),perspective_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $this->db->where('perspective_result.kd_perspective', $kd_perspective);

        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_list_score_ps_tahunan($kd_perspective,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $ThnAwal= $tahun - 10;
        $ThnAkhir= $tahun;
        $this->db->select('perspective.kd_perspective, 
				perspective.kd_ps, 
				perspective.kd_perusahaan, 
				perspective.nm_perspective,
				perspective_result.tahun,
				round(avg(perspective_result.point_result),2) as point_result');
        $this->db->from('perspective');
        $this->db->join('perspective_result','perspective.kd_perspective = perspective_result.kd_perspective','LEFT');
        $this->db->where("perspective_result.tahun between '$ThnAwal' and '$ThnAkhir'", NULL);
        $this->db->where('perspective_result.kd_perspective', $kd_perspective);
        $this->db->group_by("perspective.kd_perspective, 
				perspective.kd_ps, 
				perspective.kd_perusahaan, 
				perspective.nm_perspective,
                                perspective_result.tahun");
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_list_score_ps_rekap_setahun_chart($kd_perspective,$tahun,$bulan){
     
        
        $query = $this->get_list_score_ps_bulanan_setahun($kd_perspective,$tahun,$bulan);
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
            $Data['data_grafik'][$row->kd_perspective]["code"] =$row->kd_perspective;
            $Data['data_grafik'][$row->kd_perspective]["nama"] =$row->nm_perspective;
            $Data['data_grafik'][$row->kd_perspective]["score"][$row->tahun.$bulan] =$row->point_result;
        }
        return $Data;
    }
    public function get_list_score_ps_tahunan_chart($kd_perspective,$tahun){
     
        
        $query = $this->get_list_score_ps_tahunan($kd_perspective,$tahun);
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
            $Data['color'][$row->kd_perspective]= $this->rand_color();
            $Data['data_grafik'][$row->kd_perspective]["code"] =$row->kd_perspective;
            $Data['data_grafik'][$row->kd_perspective]["nama"] =$row->nm_perspective;
            $Data['data_grafik'][$row->kd_perspective]["score"][$row->tahun] =$row->point_result;
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

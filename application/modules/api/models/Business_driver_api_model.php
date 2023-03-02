<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_driver_api_model extends CI_Model{
  
    
    public function get_list_business_driver($kd_perspective,$tahun,$bulan){
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
			perspective.nm_perspective,
                        point_bulan.weightage,
			ifnull(point_bulan.gross_point_bd,0) as gross_point_bulan,
			ifnull(point_bulan.point_business_driver,0) as point_bulan,
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
    public function get_point_business_driver_detail($kd_bd,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('business_driver_result.kd_bdr,
                            business_driver_result.kd_bd,
                            business_driver_result.point_result as gross_point_bd,
                            business_driver_result.weightage,
                            business_driver_result.bulan,
                            business_driver_result.tahun,
                            round(business_driver_result.score,2) point_bd');
        $this->db->from('business_driver_result');
        $this->db->where('business_driver_result.tahun', $tahun);
        $where_clause = $this->db->get_compiled_select();
        

        $this->db->select("business_driver.kd_bd,
			business_driver.kd_bds,
                        business_driver.kd_perspective,
                        perspective.nm_perspective,
			business_driver.nm_bd,
                        point_bulan.bulan,
                        point_bulan.tahun,
			ifnull(point_bulan.gross_point_bd,0) as gross_point_bulan,
			ifnull(point_bulan.weightage,0) as weightage,
			ifnull(point_bulan.point_bd,0) as point_bulan",false);
        $this->db->from('business_driver');
        $this->db->join('perspective','perspective.kd_perspective = business_driver.kd_perspective','LEFT');
        $this->db->join('('.$where_clause.') point_bulan','business_driver.kd_bd = point_bulan.kd_bd','LEFT');
        $this->db->where('business_driver.kd_bd',$kd_bd);
        $this->db->order_by('business_driver.kd_bd');
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Weightage_company_model extends CI_Model
{
    public function get_weightage_company_all($Limit=NULL,$Offset=NULL){
        
        $this->db->select("weightage_company.*");
        $this->db->from('weightage_company');
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_weightage_company_all_perusahaan($kd_perusahaan,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("weightage_company.*,perusahaan.nm_perusahaan");
        $this->db->from('weightage_company');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=weightage_company.kd_perusahaan','LEFT');
        $this->db->where('weightage_company.kd_perusahaan',$kd_perusahaan);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_weightage_company_by_code($kd_wc){
        
        $this->db->select("weightage_company.*,perusahaan.nm_perusahaan");
        $this->db->from('weightage_company');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=weightage_company.kd_perusahaan','LEFT');
        $this->db->where('weightage_company.kd_wc',$kd_wc);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function insert_weightage_company($data){
       $this->db->insert('weightage_company',$data);
       return $this->db->insert_id();
    }
    
    public function update_weightage_company($kd_wc,$data){
        $this->db->where('kd_wc',$kd_wc);
        $this->db->update('weightage_company',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function delete_weightage_company($kd_wc){
       $this->db->where('kd_wc',$kd_wc);
       $this->db->delete('weightage_company');
    }
    public function get_perspective_weightage_company($kd_perusahaan,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("perspective.*,perusahaan.nm_perusahaan");
        $this->db->from('perspective');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=perspective.kd_perusahaan','LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_bd_weightage_company($kd_perusahaan,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("business_driver.*,perspective.nm_perspective,perusahaan.nm_perusahaan");
        $this->db->from('business_driver');
        $this->db->join('perspective','business_driver.kd_perspective=perspective.kd_perspective','LEFT');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=perspective.kd_perusahaan','LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
}

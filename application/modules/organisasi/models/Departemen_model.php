<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Departemen_model extends CI_Model
{
    
    public function get_departemen_search($keyword,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("departemen.*,perusahaan.nm_perusahaan");
        $this->db->from('departemen');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=departemen.kd_perusahaan','LEFT');
        $this->db->like('departemen.kd_departemen',$keyword);
        $this->db->or_like('departemen.nm_departemen',$keyword);
        $this->db->or_like('perusahaan.nm_perusahaan',$keyword);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_departemen_all($Limit=NULL,$Offset=NULL){
        
        $this->db->select("departemen.*,perusahaan.nm_perusahaan");
        $this->db->from('departemen');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=departemen.kd_perusahaan','LEFT');
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_departemen_all_perusahaan($kd_perusahaan,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("departemen.*,perusahaan.nm_perusahaan");
        $this->db->from('departemen');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=departemen.kd_perusahaan','LEFT');
        $this->db->where('departemen.kd_perusahaan',$kd_perusahaan);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_departemen_by_code($kd_departemen){
        
        $this->db->select("departemen.*,perusahaan.nm_perusahaan");
        $this->db->from('departemen');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=departemen.kd_perusahaan','LEFT');
        $this->db->where('departemen.kd_departemen',$kd_departemen);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function insert_departemen($data){
       $this->db->insert('departemen',$data);
       return $this->db->insert_id();
    }
    
    public function update_departemen($kd_departemen,$data){
        $this->db->where('kd_departemen',$kd_departemen);
        $this->db->update('departemen',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function delete_departemen($kd_departemen){
       $this->db->where('kd_departemen',$kd_departemen);
       $this->db->delete('departemen');
    }
}

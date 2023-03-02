<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Level_model extends CI_Model
{
    
    public function get_level_search($keyword,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("level.*,perusahaan.nm_perusahaan");
        $this->db->from('level');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=level.kd_perusahaan','LEFT');
        $this->db->like('level.kd_level',$keyword);
        $this->db->or_like('level.nm_level',$keyword);
        $this->db->or_like('perusahaan.nm_perusahaan',$keyword);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_level_all($Limit=NULL,$Offset=NULL){
        
        $this->db->select("level.*,perusahaan.nm_perusahaan");
        $this->db->from('level');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=level.kd_perusahaan','LEFT');
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_level_all_perusahaan($kd_perusahaan,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("level.*,perusahaan.nm_perusahaan");
        $this->db->from('level');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=level.kd_perusahaan','LEFT');
        $this->db->where('level.kd_perusahaan',$kd_perusahaan);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_level_by_code($kd_level){
        
        $this->db->select("level.*,perusahaan.nm_perusahaan");
        $this->db->from('level');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=level.kd_perusahaan','LEFT');
        $this->db->where('level.kd_level',$kd_level);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function insert_level($data){
       $this->db->insert('level',$data);
       return $this->db->insert_id();
    }
    
    public function update_level($kd_level,$data){
        $this->db->where('kd_level',$kd_level);
        $this->db->update('level',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function delete_level($kd_level){
       $this->db->where('kd_level',$kd_level);
       $this->db->delete('level');
    }
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perusahaan_model extends CI_Model
{
    
    public function get_perusahaan_search($keyword,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("perusahaan.*");
        $this->db->from('perusahaan');
        $this->db->like('perusahaan.kd_perusahaan',$keyword);
        $this->db->or_like('perusahaan.nm_peruahaan',$keyword);
        $this->db->or_like('perusahaan.nm_peruahaan',$keyword);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_perusahaan_all($Limit=NULL,$Offset=NULL){
        
        $this->db->select("perusahaan.*");
        $this->db->from('perusahaan');
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_perusahaan_by_code($kd_perusahaan){
        
        $this->db->select("perusahaan.*");
        $this->db->from('perusahaan');
        $this->db->where('perusahaan.kd_perusahaan',$kd_perusahaan);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function insert_perusahaan($data){
       $this->db->insert('perusahaan',$data);
       return $this->db->insert_id();
    }
    
    public function update_perusahaan($kd_perusahaan,$data){
        $this->db->where('kd_perusahaan',$kd_perusahaan);
        $this->db->update('perusahaan',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function delete_perusahaan($kd_perusahaan){
       $this->db->where('kd_perusahaan',$kd_perusahaan);
       $this->db->delete('perusahaan');
    }
}

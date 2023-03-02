<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jabatan_model extends CI_Model
{
    
    public function get_jabatan_search($keyword,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("jabatan.*,perusahaan.nm_perusahaan, level.nm_level");
        $this->db->from('jabatan');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=jabatan.kd_perusahaan','LEFT');
        $this->db->join('level','jabatan.kd_level=level.kd_level','LEFT');
        $this->db->like('jabatan.kd_jabatan',$keyword);
        $this->db->or_like('jabatan.nm_jabatan',$keyword);
        $this->db->or_like('perusahaan.nm_perusahaan',$keyword);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_jabatan_all($Limit=NULL,$Offset=NULL){
        
        $this->db->select("jabatan.*,perusahaan.nm_perusahaan, level.nm_level");
        $this->db->from('jabatan');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=jabatan.kd_perusahaan','LEFT');
        $this->db->join('level','jabatan.kd_level=level.kd_level','LEFT');
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_jabatan_all_perusahaan($kd_perusahaan,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("jabatan.*,perusahaan.nm_perusahaan, level.nm_level");
        $this->db->from('jabatan');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=jabatan.kd_perusahaan','LEFT');
        $this->db->join('level','jabatan.kd_level=level.kd_level','LEFT');
        $this->db->where('jabatan.kd_perusahaan',$kd_perusahaan);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_jabatan_by_code($kd_jabatan){
        
        $this->db->select("jabatan.*,perusahaan.nm_perusahaan, level.nm_level");
        $this->db->from('jabatan');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=jabatan.kd_perusahaan','LEFT');
        $this->db->join('level','jabatan.kd_level=level.kd_level','LEFT');
        $this->db->where('jabatan.kd_jabatan',$kd_jabatan);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_level_all_jabatan($kd_perusahaan){
        
//        $this->db->select("level.*");
//        $this->db->from('level');
//        $this->db->where('menu.status_show','1');
//        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        $this->db->where('kd_perusahaan',$kd_perusahaan);
        return $this->db->get('level');
    }
    public function insert_jabatan($data){
       $this->db->insert('jabatan',$data);
       return $this->db->insert_id();
    }
    
    public function update_jabatan($kd_jabatan,$data){
        $this->db->where('kd_jabatan',$kd_jabatan);
        $this->db->update('jabatan',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function delete_jabatan($kd_jabatan){
       $this->db->where('kd_jabatan',$kd_jabatan);
       $this->db->delete('jabatan');
    }
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permission_model extends CI_Model
{
    
    public function get_permission_search($keyword,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("permission.*");
        $this->db->from('permission');
        $this->db->join('menu','menu.kd_menu = permission.kd_menu','LEFT');
        $this->db->like('permission.kd_permission',$keyword);
        $this->db->or_like('permission.deskripsi',$keyword);
        $this->db->or_like('menu.menu',$keyword);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_permission_all($Limit=NULL,$Offset=NULL){
        
        $this->db->select("permission.*");
        $this->db->from('permission');
        $this->db->join('menu','menu.kd_menu = permission.kd_menu','LEFT');
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_menu_all_permission($Limit=NULL,$Offset=NULL){
        
        $this->db->select("menu.*");
        $this->db->from('menu');
        $this->db->where('menu.status_show','1');
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_permission_by_code($kd_permission){
        
        $this->db->select("permission.*,menu.menu");
        $this->db->from('permission');
        $this->db->join('menu','menu.kd_menu = permission.kd_menu','LEFT');
        $this->db->where('permission.kd_permission',$kd_permission);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function insert_permission($data){
       $this->db->insert('permission',$data);
       return $this->db->insert_id();
    }
    
    public function update_permission($kd_permission,$data){
        $this->db->where('kd_permission',$kd_permission);
        $this->db->update('permission',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function delete_permission($kd_permission){
       $this->db->where('kd_permission',$kd_permission);
       $this->db->delete('permission');
    }
}

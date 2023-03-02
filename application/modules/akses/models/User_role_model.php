<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_role_model extends CI_Model
{
    
    public function get_groups_search($keyword,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("perms_groups.*,groups.name as name_group, permission.deskripsi as deskripsi_permission, menu.menu");
        $this->db->from('perms_groups');
        $this->db->join('groups','perms_groups.id_groups = groups.id','LEFT');
        $this->db->join('permission','perms_groups.kd_permission = permission.kd_permission','LEFT');
        $this->db->join('menu','menu.kd_menu = permission.kd_menu','LEFT');
        $this->db->like('groups.kd_groups',$keyword);
        $this->db->or_like('groups.deskripsi',$keyword);
        $this->db->or_like('menu.menu',$keyword);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_perms_groups_all($Limit=NULL,$Offset=NULL){
        
        $this->db->select("perms_groups.*,groups.name as name_group, permission.deskripsi as deskripsi_permission, permission.kd_menu, menu.menu");
        $this->db->from('perms_groups');
        $this->db->join('groups','perms_groups.id_groups = groups.id','LEFT');
        $this->db->join('permission','perms_groups.kd_permission = permission.kd_permission','LEFT');
        $this->db->join('menu','menu.kd_menu = permission.kd_menu','LEFT');
        $this->db->order_by('permission.kd_menu');
        $this->db->limit($Limit, $Offset);
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_permission($Limit=NULL,$Offset=NULL){
        
        $this->db->select("permission.*,menu.menu");
        $this->db->from('permission');
        $this->db->join('menu','menu.kd_menu = permission.kd_menu','LEFT');
        $this->db->order_by('permission.kd_menu');
        $this->db->limit($Limit, $Offset);
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_perms_groups_by_id_group($id_groups){
        
        $this->db->select("perms_groups.*,groups.name as name_group, permission.deskripsi as deskripsi_permission, menu.menu");
        $this->db->from('perms_groups');
        $this->db->join('groups','perms_groups.id_groups = groups.id','LEFT');
        $this->db->join('permission','perms_groups.kd_permission = permission.kd_permission','LEFT');
        $this->db->join('menu','menu.kd_menu = permission.kd_menu','LEFT');
        $this->db->where('perms_groups.id_groups',$id_groups);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function insert_perms_groups($data){
       $this->db->insert('perms_groups',$data);
       return $this->db->insert_id();
    }
    public function insert_perms_groups_batch($data){
       $this->db->insert_batch('perms_groups', $data);
       //return $this->db->insert_id();
    }
    public function update_perms_groups($kd_perms_group,$data){
        $this->db->where('kd_perms_group',$kd_perms_group);
        $this->db->update('perms_groups',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function delete_perms_groups($kd_perms_group){
       $this->db->where('kd_perms_group',$kd_perms_group);
       $this->db->delete('perms_groups');
    }
    public function delete_perms_groups_id_groups($id_groups){
       $this->db->where('id_groups',$id_groups);
       $this->db->delete('perms_groups');
    }
}

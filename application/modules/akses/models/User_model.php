<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function get_pegawai_all_user($Limit=NULL,$Offset=NULL){
        
        $this->db->select("pegawai.*,perusahaan.nm_perusahaan, departemen.nm_departemen, jabatan.nm_jabatan");
        $this->db->from('pegawai');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=pegawai.kd_perusahaan','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai.kd_departemen','LEFT');
        $this->db->join('jabatan','jabatan.kd_jabatan=pegawai.kd_jabatan','LEFT');
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_pegawai_by_code_user($nip){
        
        $this->db->select("pegawai.*,perusahaan.nm_perusahaan, departemen.nm_departemen, jabatan.nm_jabatan");
        $this->db->from('pegawai');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=pegawai.kd_perusahaan','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai.kd_departemen','LEFT');
        $this->db->join('jabatan','jabatan.kd_jabatan=pegawai.kd_jabatan','LEFT');
        $this->db->where("pegawai.nip",$nip);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_pegawai_search($text){
        
        $this->db->select("pegawai.*,perusahaan.nm_perusahaan, departemen.nm_departemen, jabatan.nm_jabatan");
        $this->db->from('pegawai');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=pegawai.kd_perusahaan','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai.kd_departemen','LEFT');
        $this->db->join('jabatan','jabatan.kd_jabatan=pegawai.kd_jabatan','LEFT');
        $this->db->like("pegawai.nip",$text);
        $this->db->or_like("pegawai.nama",$text);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_user_by_code($id){
        
        $this->db->select("users.*,
                            pegawai.tgl_masuk,
                            pegawai.dob,
                            pegawai.tgl_keluar,
                            pegawai.kd_departemen,
                            departemen.nm_departemen,
                            pegawai.kd_jabatan,
                            jabatan.nm_jabatan,
                            pegawai.kd_perusahaan,
                            perusahaan.nm_perusahaan,
                            pegawai.report_to,
                            pegawai.status,
                            pegawai.jenis_kelamin,
                            pegawai.foto, 
                            pg.nama as nm_atasan,
                            groups.name as group_name,
                            users_groups.group_id");
        $this->db->from('users');
        $this->db->join('pegawai','pegawai.nip=users.nip','LEFT');
        $this->db->join('perusahaan','pegawai.kd_perusahaan=perusahaan.kd_perusahaan','LEFT');
        $this->db->join('departemen','pegawai.kd_departemen=departemen.kd_departemen','LEFT');
        $this->db->join('jabatan','pegawai.kd_jabatan=jabatan.kd_jabatan','LEFT');
        $this->db->join('pegawai pg','pegawai.report_to=pg.nip','LEFT');
        $this->db->join('users_groups','users_groups.user_id=users.id','LEFT');
        $this->db->join('groups','groups.id=users_groups.group_id','LEFT');
        $this->db->where("users.id",$id);
        $query= $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_user_by_username($username){
        
        $this->db->select("users.*");
        $this->db->from('users');
        $this->db->like("users.username",$username);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_user_by_email($email){
        
        $this->db->select("users.*");
        $this->db->from('users');
        $this->db->like("users.email",$email);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function update_user($id,$data){
        $this->db->where('id',$id);
        $this->db->update('users',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function update_pegawai_user($nip,$data){
        $this->db->where('nip',$nip);
        $this->db->update('pegawai',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function get_user_activity_by_code($id,$start,$end){
        
        $this->db->select("users_activity.*,pegawai.nama");
        $this->db->from('users_activity');
        $this->db->join('users','users_activity.USER_ID=users.id','LEFT');
        $this->db->join('pegawai','pegawai.nip=users.nip','LEFT');
        $this->db->where("users.id",$id);
        $this->db->where("users_activity.LOG_DATE BETWEEN ".$start." and ".$end);
        $this->db->order_by("users_activity.LOG_DATE DESC");
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
}

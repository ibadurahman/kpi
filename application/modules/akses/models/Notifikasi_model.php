<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifikasi_model extends CI_Model
{
    
    public function get_notifikasi_all($report_to=""){
        
        $this->db->select("notifikasi.*");
        $this->db->from('notifikasi');
        $this->db->join('pegawai','pegawai.nip=notifikasi.nip','LEFT');
        if($report_to!=""){
            $this->db->where('pegawai.nip',$report_to);
            $this->db->or_where('pegawai.report_to',$report_to);
            $this->db->order_by('notifikasi.status asc');
        }else{
            $this->db->order_by('notifikasi.status_admin asc, notifikasi.tgl_input desc');
        }
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_notifikasi_Tgl($start,$end,$report_to=""){
        
        $this->db->select("notifikasi.*");
        $this->db->from('notifikasi');
        $this->db->join('pegawai','pegawai.nip=notifikasi.nip','LEFT');
        if($report_to!=""){
            $this->db->where('pegawai.nip',$report_to);
            $this->db->or_where('pegawai.report_to',$report_to);
            $this->db->order_by('notifikasi.status asc');
        }else{
            $this->db->order_by('notifikasi.status_admin asc, notifikasi.tgl_input desc');
        }
        $this->db->where("notifikasi.tgl_input BETWEEN '".$start."' and '".$end."'");
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function update_notifikasi($kd_notifikasi,$data){
        $this->db->where('kd_notifikasi',$kd_notifikasi);
        $this->db->update('notifikasi',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function update_notifikasi_nip($nip,$data){
        $this->db->select('pegawai.nip');
        $this->db->from('pegawai');
        $this->db->where('pegawai.nip',$nip);
        $this->db->or_where('pegawai.report_to',$nip);
        $where_clause = $this->db->get_compiled_select();

       
       $this->db->where('notifikasi.nip IN ('.$where_clause.')',NULL,FALSE);
        $this->db->update('notifikasi',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function update_notifikasi_admin(){
        
        $data=['status_admin'=>1];
       
       $this->db->where('status_admin','0');
        $this->db->update('notifikasi',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
}

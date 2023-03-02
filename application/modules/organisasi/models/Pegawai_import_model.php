<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai_import_model extends CI_Model
{
    
    public function get_jabatan_all_pegawai_import($kd_perusahaan){
        $this->db->where('kd_perusahaan',$kd_perusahaan);
        return $this->db->get('jabatan');
    }
    public function get_departemen_all_pegawai_import($kd_perusahaan){
        $this->db->where('kd_perusahaan',$kd_perusahaan);
        return $this->db->get('departemen');
    }
    
    public function get_perusahaan_all_pegawai_import($kd_perusahaan){
        $this->db->where('kd_perusahaan',$kd_perusahaan);
        return $this->db->get('perusahaan');
    }
    public function get_pegawai_all_pegawai_import($kd_perusahaan,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("pegawai.*,perusahaan.nm_perusahaan, departemen.nm_departemen, jabatan.nm_jabatan");
        $this->db->from('pegawai');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=pegawai.kd_perusahaan','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai.kd_departemen','LEFT');
        $this->db->join('jabatan','jabatan.kd_jabatan=pegawai.kd_jabatan','LEFT');
        $this->db->where('pegawai.kd_perusahaan',$kd_perusahaan);
        $this->db->where('pegawai.status',1);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    
    public function insert_multiple_Pegawai($data){
        $this->db->insert_batch('pegawai', $data);
    }
}

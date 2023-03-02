<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_appraisal_model extends CI_Model
{
    
    public function get_jabatan_all_report_appraisal($kd_perusahaan){
        $this->db->where('kd_perusahaan',$kd_perusahaan);
        return $this->db->get('jabatan');
    }
    public function get_departemen_all_report_appraisal($kd_perusahaan){
        
        $this->db->where('kd_perusahaan',$kd_perusahaan);
        return $this->db->get('departemen');
    }
    
    public function get_perusahaan_all_report_appraisal($kd_perusahaan){
        
        $this->db->where('kd_perusahaan',$kd_perusahaan);
        return $this->db->get('perusahaan');
    }
    
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_individual_model extends CI_Model
{
    
    public function get_jabatan_all_report_individual($kd_perusahaan){
        $this->db->where('kd_perusahaan',$kd_perusahaan);
        return $this->db->get('jabatan');
    }
    public function get_departemen_all_report_individual($kd_perusahaan){
        
        $this->db->where('kd_perusahaan',$kd_perusahaan);
        return $this->db->get('departemen');
    }
    
    public function get_perusahaan_all_report_individual($kd_perusahaan){
        
        $this->db->where('kd_perusahaan',$kd_perusahaan);
        return $this->db->get('perusahaan');
    }
    public function get_pegawai_search($kd_perusahaan,$search,$stat=true){
        
        $this->db->select("pegawai.*,perusahaan.nm_perusahaan, departemen.nm_departemen, jabatan.nm_jabatan");
        $this->db->from('pegawai');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=pegawai.kd_perusahaan','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai.kd_departemen','LEFT');
        $this->db->join('jabatan','jabatan.kd_jabatan=pegawai.kd_jabatan','LEFT');
        $this->db->where('pegawai.kd_perusahaan',$kd_perusahaan);
        if(!$stat){
            $this->db->where("pegawai.nip in (
	                            	select nip
						from(
						select @pv:=concat(@pv,',',tabel.nip) as kode,tabel.* 
						from ( 
								select pegawai.nip,pegawai.report_to
						      from pegawai 
								LEFT JOIN pegawai pg ON pg.nip=pegawai.report_to
						      where pegawai.kd_perusahaan = '".$kd_perusahaan."'
						      order by pegawai.nip asc
						) as tabel
						join
						(select @pv:=(select GROUP_CONCAT(nip) from pegawai where nip in ('".$this->session->userdata('login_nip')."')))tmp
						where FIND_IN_SET(tabel.report_to, @pv) or tabel.nip='".$this->session->userdata('login_nip')."'
						)as list_pegawai
					)",NULL);
        }
        $this->db->group_start();
        $this->db->like('pegawai.nip',$search);
        $this->db->or_like('pegawai.nama',$search);
        $this->db->group_end();
       // $this->searching->SetSerching($DataSearch);
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_appraisal_detail_report_individual($nip,$bulan,$tahun){
        
        $this->db->select("appraisal.*,
                            appraisal_detail.kd_ad,
                            appraisal_detail.kd_measurement,
                            appraisal_detail.weightage_bd,
                            appraisal_detail.weightage_kpi,
                            appraisal_detail.weightage_bd_dept,
                            appraisal_detail.target,
                            appraisal_detail.score_bd,
                            appraisal_detail.score_kpi,
                            appraisal_detail.actual,
                            appraisal_detail.result,
                            appraisal_detail.point_result,
                            appraisal_detail.type,
                            appraisal_detail.unit,
                            appraisal_detail.period,
                            appraisal_detail.target_label,
                            appraisal_detail.status_calculate,
                            appraisal_detail.formula,
                            pegawai.nama,
                            pg.nama as nm_atasan,,
                            departemen.nm_departemen,
                            jabatan.nm_jabatan,
                            measurement.nm_measurement,
                            business_driver.kd_bds,
                            business_driver.nm_bd,
                            business_driver.kd_bd");
        $this->db->from('appraisal');
        $this->db->join('appraisal_detail','appraisal_detail.kd_appraisal=appraisal.kd_appraisal','LEFT');
        $this->db->join('pegawai','pegawai.nip=appraisal.nip','LEFT');
        $this->db->join('pegawai pg','pg.nip=appraisal.nip_atasan','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=appraisal.kd_departemen','LEFT');
        $this->db->join('jabatan','jabatan.kd_jabatan=appraisal.kd_jabatan','LEFT');
        $this->db->join('measurement','measurement.kd_measurement=appraisal_detail.kd_measurement','LEFT');
        $this->db->join('business_driver','measurement.kd_bd=business_driver.kd_bd','LEFT');
        $this->db->where("appraisal.nip", $nip);
        $this->db->where("appraisal.bulan", $bulan);
        $this->db->where("appraisal.tahun", $tahun);
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    
}

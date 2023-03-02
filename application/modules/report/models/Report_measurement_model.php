<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_measurement_model extends CI_Model
{
    
    public function get_jabatan_all_report_measurement($kd_perusahaan){
        $this->db->where('kd_perusahaan',$kd_perusahaan);
        return $this->db->get('jabatan');
    }
    public function get_departemen_all_report_measurement($kd_perusahaan){
        
        $this->db->where('kd_perusahaan',$kd_perusahaan);
        return $this->db->get('departemen');
    }
    
    public function get_perusahaan_all_report_measurement($kd_perusahaan){
        
        $this->db->where('kd_perusahaan',$kd_perusahaan);
        return $this->db->get('perusahaan');
    }
    public function get_pegawai_search_report_measurement($kd_perusahaan,$search){
        
        $this->db->select("pegawai.*,perusahaan.nm_perusahaan, departemen.nm_departemen, jabatan.nm_jabatan");
        $this->db->from('pegawai');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=pegawai.kd_perusahaan','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai.kd_departemen','LEFT');
        $this->db->join('jabatan','jabatan.kd_jabatan=pegawai.kd_jabatan','LEFT');
        $this->db->where('pegawai.kd_perusahaan',$kd_perusahaan);
        $this->db->group_start();
        $this->db->like('pegawai.nip',$search);
        $this->db->or_like('pegawai.nama',$search);
        $this->db->group_end();
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_pegawai_measurement_aktual($kd_perusahaan,$bulan,$tahun,$nip,$kd_departemen){
        
        $this->db->select("appraisal.nip,
			pegawai.nama,
			appraisal.bulan,
			appraisal.tahun,
			appraisal.kd_departemen,
			departemen.nm_departemen,
			appraisal.kd_jabatan,
			jabatan.nm_jabatan,
			appraisal.nip_atasan,
			pg.nama as nm_atasan,
			appraisal_detail.kd_measurement,
			measurement.nm_measurement,
			appraisal_detail.target,
			appraisal_detail.actual,
			appraisal_detail.result,
			appraisal_detail.score_bd,
			appraisal_detail.score_kpi,
			appraisal_detail.`type`,
			appraisal_detail.unit,
			appraisal_detail.period");
        $this->db->from('appraisal');
        $this->db->join('appraisal_detail','appraisal.kd_appraisal = appraisal_detail.kd_appraisal');
        $this->db->join('measurement','appraisal_detail.kd_measurement = measurement.kd_measurement');
        $this->db->join('departemen','departemen.kd_departemen=appraisal.kd_departemen','LEFT');
        $this->db->join('jabatan','jabatan.kd_jabatan = appraisal.kd_jabatan','LEFT');
        $this->db->join('pegawai','appraisal.nip = pegawai.nip','LEFT');
        $this->db->join('pegawai pg','appraisal.nip_atasan = pg.nip','LEFT');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=departemen.kd_perusahaan','LEFT');
        $this->db->where('departemen.kd_perusahaan',$kd_perusahaan);
        $this->db->where('appraisal.bulan',$bulan);
        $this->db->where('appraisal.tahun',$tahun);
        if($nip!=""){
            $this->db->where('appraisal.nip',$nip);
        }
        if($kd_departemen!=""){
            $this->db->where('appraisal.kd_departemen',$kd_departemen);
        }
        $this->db->order_by('pegawai.nama ASC, appraisal.tahun ASC, appraisal.bulan ASC');
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_departemen_measurement_aktual($kd_perusahaan,$bulan,$tahun,$kd_departemen){
        
        $this->db->select("departemen_result.bulan,
			departemen_result.tahun,
			departemen_result.kd_departemen,
			departemen.nm_departemen,
			departemen_result.kd_measurement,
			measurement.nm_measurement,
			departemen_result.target,
			departemen_result.actual,
			departemen_result.result,
			departemen_result.score_bd,
			departemen_result.score_kpi,
			departemen_result.`type`,
			departemen_result.unit,
			departemen_result.period");
        $this->db->from('departemen_result');
        $this->db->join('measurement','departemen_result.kd_measurement = measurement.kd_measurement');
        $this->db->join('departemen','departemen.kd_departemen=departemen_result.kd_departemen','LEFT');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=departemen.kd_perusahaan','LEFT');
        $this->db->where('departemen.kd_perusahaan',$kd_perusahaan);
        $this->db->where('departemen_result.bulan',$bulan);
        $this->db->where('departemen_result.tahun',$tahun);
        if($kd_departemen!=""){
            $this->db->where('departemen_result.kd_departemen',$kd_departemen);
        }
        $this->db->order_by('departemen.nm_departemen ASC, departemen_result.tahun ASC, departemen_result.bulan ASC');
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_pegawai_measurement_aktual_arr($kd_perusahaan,$bulan,$tahun,$nip,$kd_departemen){
        
        $Result= $this->get_pegawai_measurement_aktual($kd_perusahaan, $bulan, $tahun, $nip, $kd_departemen);
        $ResultArr=array();
        if($Result->num_rows()>0){
            foreach($Result->result() as $row){
                $ResultArr[$row->kd_measurement][$row->kd_departemen][$row->nip]["nip"]=$row->nip;
                $ResultArr[$row->kd_measurement][$row->kd_departemen][$row->nip]["nama"]=$row->nama;
                $ResultArr[$row->kd_measurement][$row->kd_departemen][$row->nip]["kd_measurement"]=$row->kd_measurement;
                $ResultArr[$row->kd_measurement][$row->kd_departemen][$row->nip]["kd_departemen"]=$row->kd_departemen;
                $ResultArr[$row->kd_measurement][$row->kd_departemen][$row->nip]["target"]=$row->target;
                $ResultArr[$row->kd_measurement][$row->kd_departemen][$row->nip]["actual"]=$row->actual;
                $ResultArr[$row->kd_measurement][$row->kd_departemen][$row->nip]["result"]=$row->result;
            }
        }
        return $ResultArr;
    }
    public function get_measurement_aktual($kd_perusahaan,$bulan,$tahun){
        
        $this->db->select("measurement_result.bulan,
			measurement_result.tahun,
                        perusahaan.nm_perusahaan,
			measurement_result.kd_bd,
			business_driver.nm_bd,
			measurement_result.kd_measurement,
			measurement.nm_measurement,
			measurement_result.target,
			measurement_result.actual,
			measurement_result.result,
			measurement_result.score,
			measurement_result.`type`,
			measurement_result.unit,
			measurement_result.period");
        $this->db->from('measurement_result');
        $this->db->join('measurement','measurement_result.kd_measurement = measurement.kd_measurement');
        $this->db->join('business_driver','measurement_result.kd_bd = business_driver.kd_bd','LEFT');
        $this->db->join('perspective','perspective.kd_perspective = business_driver.kd_perspective','LEFT');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=perspective.kd_perusahaan','LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->where('measurement_result.bulan',$bulan);
        $this->db->where('measurement_result.tahun',$tahun);
        
        $this->db->order_by('measurement_result.kd_bd ASC, measurement.nm_measurement ASC, measurement_result.tahun ASC, measurement_result.bulan ASC');
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_departemen_measurement_aktual_arr($kd_perusahaan,$bulan,$tahun,$kd_departemen){
        
        $Result= $this->get_departemen_measurement_aktual($kd_perusahaan,$bulan,$tahun,$kd_departemen);
        $ResultArr=array();
        if($Result->num_rows()>0){
            foreach($Result->result() as $row){
                $ResultArr[$row->kd_measurement][$row->kd_departemen]["nm_departemen"]=$row->nm_departemen;
                $ResultArr[$row->kd_measurement][$row->kd_departemen]["kd_measurement"]=$row->kd_measurement;
                $ResultArr[$row->kd_measurement][$row->kd_departemen]["kd_departemen"]=$row->kd_departemen;
                $ResultArr[$row->kd_measurement][$row->kd_departemen]["target"]=$row->target;
                $ResultArr[$row->kd_measurement][$row->kd_departemen]["actual"]=$row->actual;
                $ResultArr[$row->kd_measurement][$row->kd_departemen]["result"]=$row->result;
            }
        }
        return $ResultArr;
    }
}

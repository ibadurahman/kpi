<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appraisal_model extends CI_Model
{
   
    public function get_appraisal_detail($kd_appraisal){
        
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
                            pg.nama as nm_atasan,
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
        $this->db->where("appraisal.kd_appraisal", $kd_appraisal);
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_appraisal_by_code($kd_appraisal){
        
        $this->db->select("appraisal.*");
        $this->db->from('appraisal');
        // $this->db->join('perusahaan','perusahaan.kd_perusahaan=appraisal.kd_perusahaan','LEFT');
        $this->db->where('appraisal.kd_appraisal',$kd_appraisal);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function insert_appraisal($data){
       $this->db->insert('appraisal',$data);
       return $this->db->insert_id();
    }
    
    public function update_appraisal($kd_appraisal,$data){
        $this->db->where('kd_appraisal',$kd_appraisal);
        $this->db->update('appraisal',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function delete_appraisal($kd_appraisal){
       $this->db->where('kd_appraisal',$kd_appraisal);
       $this->db->delete('appraisal');
    }
    public function get_pegawai_kpi_by_nip_appraisal($nip,$bulan,$tahun=''){
        if($tahun==""){
            $tahun=date("Y");
        }
        // utk mendapatkan data kpi pegawai terupdate
        $this->db->select('pegawai_kpi.nip, max(pegawai_kpi.kd_pk) as kd_pk');
        $this->db->from('pegawai_kpi');
        $this->db->where('pegawai_kpi.bulan <=', $bulan);
        $this->db->where('pegawai_kpi.tahun <=', $tahun);
        $this->db->group_by('pegawai_kpi.nip');
        $where_clause = $this->db->get_compiled_select();
        
        // utk mendapatkan data kpi pegawai terupdate berdasarkan tahun
        $this->db->select('pegawai_kpi.nip, max(pegawai_kpi.kd_pk) as kd_pk');
        $this->db->from('pegawai_kpi');
        $this->db->where('pegawai_kpi.tahun', $tahun);
        $this->db->group_by('pegawai_kpi.nip');
        $where_clause2 = $this->db->get_compiled_select();
        
        //get total bobot bd
        $this->db->select("pegawai_kpi.kd_departemen,
			pegawai_kpi_d.kd_measurement, 
			sum(pegawai_kpi_d.weightage_bd) as Tot_bobot_bd",FALSE);
        $this->db->from('pegawai_kpi');
        $this->db->join('('.$where_clause2.') as max_pk','pegawai_kpi.kd_pk=max_pk.kd_pk');
        $this->db->join('pegawai_kpi_d','pegawai_kpi.kd_pk = pegawai_kpi_d.kd_pk');
//        $this->db->where('pegawai_kpi.nip',$nip);
        $this->db->where('pegawai_kpi.tahun', $tahun);
        $this->db->group_by('pegawai_kpi.kd_departemen,pegawai_kpi_d.kd_measurement');
        $where_clause3 = $this->db->get_compiled_select();
        // echo $where_clause3;
        //get total bobot kpi
        $this->db->select("pegawai_kpi.kd_pk, 
                            sum(pegawai_kpi_d.weightage_kpi) as Tot_bobot_kpi",FALSE);
        $this->db->from('pegawai_kpi');
        $this->db->join('pegawai_kpi_d','pegawai_kpi.kd_pk = pegawai_kpi_d.kd_pk');
        $this->db->where('pegawai_kpi.nip',$nip);
        $this->db->group_by('pegawai_kpi.kd_pk');
        $where_clause4 = $this->db->get_compiled_select();
        
        //get total bobot kpi
        $this->db->select("pegawai_target.kd_pk,pegawai_target.kd_measurement,
                            pegawai_target.type,
                            pegawai_target.unit,
                            pegawai_target.period,
                            pegawai_target_d.bulan as bulan_target, pegawai_target_d.target",FALSE);
        $this->db->from('pegawai_target');
        $this->db->join('pegawai_target_d','pegawai_target_d.kd_pt = pegawai_target.kd_pt');
        $this->db->where('pegawai_target.tahun',$tahun);
        $this->db->where('pegawai_target_d.bulan',$bulan);
        $where_clause5 = $this->db->get_compiled_select();
        
        
//        echo $where_clause4;
        $this->db->select("pegawai_kpi.*,
                            pegawai_kpi_d.kd_pkd,
                            pegawai_kpi_d.kd_measurement,
                            pegawai_kpi_d.kd_dk,
                            pegawai_kpi_d.weightage_bd,
                            pegawai_kpi_d.weightage_kpi,
                            pegawai_kpi_d.target as target_baru,
                            pegawai_kpi_d.target_label,
                            pegawai_kpi_d.tipe_target,
                            pegawai_kpi_d.status_calculate,
                            pegawai_kpi_d.formula,
                            departemen.nm_departemen,
                            measurement.nm_measurement,
                            measurement.kd_ms,
                            pkpit.type,
                            pkpit.unit,
                            pkpit.period,
                            business_driver.kd_bd,
                            business_driver.kd_bds,  
                            business_driver.nm_bd,
                            pkpitb.Tot_bobot_bd,
                            pkpitkpi.Tot_bobot_kpi,
                            ifnull(pkpit.target,0) as target,
                            pkpit.bulan_target,
                            pegawai.nama,
                            pegawai.kd_departemen as kd_dept_peg,
                            pegawai.report_to,
                            pegawai.kd_jabatan,
                            pg.nama as nm_atasan,
                            jabatan.nm_jabatan");
        $this->db->from('pegawai_kpi');
        $this->db->join('('.$where_clause.') as max_pk','pegawai_kpi.kd_pk=max_pk.kd_pk');
        $this->db->join('pegawai','pegawai.nip=pegawai_kpi.nip','LEFT');
        $this->db->join('pegawai pg','pegawai.report_to=pg.nip','LEFT');
        $this->db->join('jabatan','pegawai.kd_jabatan=jabatan.kd_jabatan','LEFT');
        $this->db->join('pegawai_kpi_d','pegawai_kpi.kd_pk = pegawai_kpi_d.kd_pk');
        $this->db->join('measurement','pegawai_kpi_d.kd_measurement=measurement.kd_measurement','LEFT');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai.kd_departemen','LEFT');
        $this->db->join('('.$where_clause3.') as pkpitb','pkpitb.kd_measurement=pegawai_kpi_d.kd_measurement and pkpitb.kd_departemen=pegawai_kpi.kd_departemen','LEFT');
        $this->db->join('('.$where_clause4.') as pkpitkpi','pkpitkpi.kd_pk=pegawai_kpi.kd_pk','LEFT');
        $this->db->join('('.$where_clause5.') as pkpit','pkpit.kd_pk=pegawai_kpi.kd_pk and pkpit.kd_measurement=pegawai_kpi_d.kd_measurement','LEFT');
        $this->db->where('pegawai_kpi.nip',$nip);
        $this->db->where('pegawai_kpi.tahun', $tahun);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_departemen_kpi_by_kd_departemen_appraisal($kd_departemen,$tahun=''){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('departemen_kpi.kd_measurement, sum(departemen_kpi.weightage_bd) as Tot_bobot_bd');
        $this->db->from('departemen_kpi');
        $this->db->where('departemen_kpi.tahun', $tahun);
        $this->db->group_by('departemen_kpi.kd_measurement');
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('departemen_kpi.kd_departemen, sum(departemen_kpi.weightage_kpi) as Tot_bobot_kpi');
        $this->db->from('departemen_kpi');
        $this->db->where('departemen_kpi.tahun', $tahun);
        $this->db->group_by('departemen_kpi.kd_departemen');
        $where_clause2 = $this->db->get_compiled_select();
        
        $this->db->select("departemen_kpi.*,
                            departemen.nm_departemen,
                            measurement.nm_measurement,
                            measurement.kd_ms,
                            business_driver.kd_bd, 
                            business_driver.nm_bd,
                            dkpitb.Tot_bobot_bd,
                            dkpitkpi.Tot_bobot_kpi");
        $this->db->from('departemen_kpi');
        $this->db->join('measurement','departemen_kpi.kd_measurement=measurement.kd_measurement','LEFT');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=departemen_kpi.kd_departemen','LEFT');
        $this->db->join('('.$where_clause.') as dkpitb','dkpitb.kd_measurement=measurement.kd_measurement','LEFT');
        $this->db->join('('.$where_clause2.') as dkpitkpi','dkpitkpi.kd_departemen=departemen_kpi.kd_departemen','LEFT');
        $this->db->where('departemen_kpi.kd_departemen',$kd_departemen);
        $this->db->where('departemen_kpi.tahun', $tahun);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function insert_appraisal_detail_batch($data){
       $this->db->insert_batch('appraisal_detail',$data);
    }
    public function proses_input_result($Bulan,$Tahun,$KodePerusahaan){
       $sql= "CALL `SpInputResult`(?, ?, ?)";
       $Bind=array($Bulan,$Tahun,$KodePerusahaan);
       $this->db->query($sql,$Bind);
    }
    public function getDataMeasurementInAppraisal($kd_measurement)
    {
        $this->db->select("measurement.*");
        $this->db->from('measurement');
        $this->db->where('measurement.kd_measurement',$kd_measurement);
        $query = $this->db->get();
        if($query->num_rows()>0){
            return $query->row();
        }
        return false;
    }
}

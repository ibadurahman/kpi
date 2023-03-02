<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai_model extends CI_Model
{
    
    public function get_pegawai_search($keyword,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("pegawai.*,perusahaan.nm_perusahaan, level.nm_level");
        $this->db->from('pegawai');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=pegawai.kd_perusahaan','LEFT');
        $this->db->join('level','pegawai.kd_level=level.kd_level','LEFT');
        $this->db->like('pegawai.nip',$keyword);
        $this->db->or_like('pegawai.nm_pegawai',$keyword);
        $this->db->or_like('perusahaan.nm_perusahaan',$keyword);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_pegawai_all($kd_perusahaan,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("pegawai.*,perusahaan.nm_perusahaan, departemen.nm_departemen, jabatan.nm_jabatan");
        $this->db->from('pegawai');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=pegawai.kd_perusahaan','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai.kd_departemen','LEFT');
        $this->db->join('jabatan','jabatan.kd_jabatan=pegawai.kd_jabatan','LEFT');
        $this->db->where('pegawai.kd_perusahaan',$kd_perusahaan);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_pegawai_all_perusahaan($kd_perusahaan,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("pegawai.*,perusahaan.nm_perusahaan, level.nm_level");
        $this->db->from('pegawai');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=pegawai.kd_perusahaan','LEFT');
        $this->db->join('level','pegawai.kd_level=level.kd_level','LEFT');
        $this->db->where('pegawai.kd_perusahaan',$kd_perusahaan);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_pegawai_by_code($nip){
        
        $this->db->select("pegawai.*, pg.nama as nm_report_to,
                perusahaan.nm_perusahaan, departemen.nm_departemen, jabatan.nm_jabatan");
        $this->db->from('pegawai');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=pegawai.kd_perusahaan','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai.kd_departemen','LEFT');
        $this->db->join('jabatan','jabatan.kd_jabatan=pegawai.kd_jabatan','LEFT');
        $this->db->join('pegawai pg','pg.nip=pegawai.report_to','LEFT');
        $this->db->where('pegawai.nip',$nip);
        $query = $this->db->get();
    //    echo $this->db->last_query();
    //    die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function insert_pegawai($data){
       $this->db->insert('pegawai',$data);
       return $this->db->insert_id();
    }
    
    public function update_pegawai($nip,$data){
        $this->db->where('nip',$nip);
        $this->db->update('pegawai',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function update_pegawai_kpi_bobot($kd_pkd,$data){
        $this->db->where('kd_pkd',$kd_pkd);
        $this->db->update('pegawai_kpi_d',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function delete_pegawai($nip){
       $this->db->where('nip',$nip);
       $this->db->delete('pegawai');
    }
    
    public function get_jabatan_all_pegawai($kd_perusahaan){
        $this->db->where('kd_perusahaan',$kd_perusahaan);
        return $this->db->get('jabatan');
    }
    public function get_departemen_all_pegawai($kd_perusahaan){
        $this->db->where('kd_perusahaan',$kd_perusahaan);
        return $this->db->get('departemen');
    }
    
    public function get_perusahaan_all_pegawai($kd_perusahaan){
        $this->db->where('kd_perusahaan',$kd_perusahaan);
        return $this->db->get('perusahaan');
    }
    public function get_kpi_all_pegawai($kd_perusahaan){
        
//        $this->db->select('pegawai_kpi.kd_dk,ifnull(sum(pegawai_kpi.weightage_bd),0) as weightage_bd');
//        $this->db->from('pegawai_kpi');
//        $this->db->where('pegawai_kpi.tahun', $tahun);
//        $this->db->group_by('pegawai_kpi.kd_dk');
//        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("measurement.*,
                            business_driver.kd_bd, 
                            business_driver.nm_bd");
        $this->db->from('measurement');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('perspective','perspective.kd_perspective=business_driver.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->order_by('measurement.kd_bd,measurement.nm_measurement');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_measurement_search_multi_pegawai($kd_departemen,$kd_measurement,$tahun=''){
        
        if($tahun==""){
            $tahun=date("Y");
        }
//        $this->db->select('pegawai_kpi.kd_dk,ifnull(sum(pegawai_kpi.weightage_bd),0) as weightage_bd');
//        $this->db->from('pegawai_kpi');
//        $this->db->where('pegawai_kpi.tahun', $tahun);
//        $this->db->group_by('pegawai_kpi.kd_dk');
//        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("departemen_kpi.*,
                            departemen.nm_departemen,
                            measurement.nm_measurement,
                            measurement.kd_ms,
                            business_driver.kd_bd, 
                            business_driver.nm_bd");
        $this->db->from('departemen_kpi');
        $this->db->join('measurement','departemen_kpi.kd_measurement=measurement.kd_measurement','LEFT');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=departemen_kpi.kd_departemen','LEFT');
//        $this->db->join('('.$where_clause.') tbl_kpi','tbl_kpi.kd_dk = departemen_kpi.kd_dk','LEFT');
        $this->db->where('departemen_kpi.kd_departemen',$kd_departemen);
        $this->db->where_in('measurement.kd_measurement', $kd_measurement);
        $this->db->where('departemen_kpi.tahun', $tahun);
        $this->db->order_by('measurement.kd_bd');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_measurement_search_multi_all_pegawai($kd_measurement){
        
//        $this->db->select('pegawai_kpi.kd_dk,ifnull(sum(pegawai_kpi.weightage_bd),0) as weightage_bd');
//        $this->db->from('pegawai_kpi');
//        $this->db->where('pegawai_kpi.tahun', $tahun);
//        $this->db->group_by('pegawai_kpi.kd_dk');
//        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("measurement.*,
                            business_driver.kd_bd, 
                            business_driver.nm_bd");
        $this->db->from('measurement');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
//        $this->db->join('('.$where_clause.') tbl_kpi','tbl_kpi.kd_dk = departemen_kpi.kd_dk','LEFT');
        $this->db->where_in('measurement.kd_measurement', $kd_measurement);
        $this->db->order_by('measurement.kd_bd');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_pegawai_kpi_by_nip($nip,$tahun=''){
        if($tahun==""){
            $tahun=date("Y");
        }
        // utk mendapatkan data kpi pegawai terupdate
        $this->db->select('pegawai_kpi.nip, max(pegawai_kpi.kd_pk) as kd_pk');
        $this->db->from('pegawai_kpi');
        $this->db->group_by('pegawai_kpi.nip');
        $where_clause = $this->db->get_compiled_select();
        
        // utk mendapatkan data kpi pegawai terupdate berdasarkan tahun
        $this->db->select('pegawai_kpi.nip, max(pegawai_kpi.kd_pk) as kd_pk');
        $this->db->from('pegawai_kpi');
        $this->db->where('pegawai_kpi.tahun', $tahun);
        $this->db->group_by('pegawai_kpi.nip');
        $where_clause2 = $this->db->get_compiled_select();
        
        //get total bobot bd
//         $this->db->select("pegawai_kpi.kd_departemen,
// 			pegawai_kpi_d.kd_measurement, 
// 			sum(pegawai_kpi_d.weightage_bd) as Tot_bobot_bd",FALSE);
//         $this->db->from('pegawai_kpi');
//         $this->db->join('('.$where_clause2.') as max_pk','pegawai_kpi.kd_pk=max_pk.kd_pk');
//         $this->db->join('pegawai_kpi_d','pegawai_kpi.kd_pk = pegawai_kpi_d.kd_pk');
// //        $this->db->where('pegawai_kpi.nip',$nip);
//         $this->db->where('pegawai_kpi.tahun', $tahun);
//         $this->db->group_by('pegawai_kpi.kd_departemen,pegawai_kpi_d.kd_measurement');
//         $where_clause3 = $this->db->get_compiled_select();
        
        //get total bobot kpi
        $this->db->select("pegawai_kpi.kd_pk, 
                            sum(pegawai_kpi_d.weightage_kpi) as Tot_bobot_kpi",FALSE);
        $this->db->from('pegawai_kpi');
        $this->db->join('pegawai_kpi_d','pegawai_kpi.kd_pk = pegawai_kpi_d.kd_pk');
        $this->db->where('pegawai_kpi.nip',$nip);
        $this->db->group_by('pegawai_kpi.kd_pk');
        $where_clause4 = $this->db->get_compiled_select();
        
        //get total target
        // $this->db->select("pegawai_target.kd_pk,pegawai_target.kd_measurement, 
        //                     count(pegawai_target.kd_pk) as total_target",FALSE);
        // $this->db->from('pegawai_target');
        // $this->db->group_by('pegawai_target.kd_pk,pegawai_target.kd_measurement');
        // $where_clause5 = $this->db->get_compiled_select();
        
//        echo $where_clause4;
        $this->db->select("pegawai_kpi.*,
                            pegawai_kpi_d.kd_pkd,
                            pegawai_kpi_d.kd_measurement,
                            pegawai_kpi_d.kd_dk,
                            pegawai_kpi_d.weightage_bd,
                            pegawai_kpi_d.weightage_kpi,
                            pegawai_kpi_d.target,
                            departemen.nm_departemen,
                            measurement.nm_measurement,
                            measurement.kd_ms,
                            measurement.type,
                            measurement.unit,
                            measurement.period,
                            business_driver.kd_bd, 
                            business_driver.nm_bd,
                            pkpitkpi.Tot_bobot_kpi,
                            pegawai.nama");
        $this->db->from('pegawai_kpi');
        $this->db->join('('.$where_clause.') as max_pk','pegawai_kpi.kd_pk=max_pk.kd_pk');
        $this->db->join('pegawai','pegawai.nip=pegawai_kpi.nip','LEFT');
        $this->db->join('pegawai_kpi_d','pegawai_kpi.kd_pk = pegawai_kpi_d.kd_pk');
        $this->db->join('measurement','pegawai_kpi_d.kd_measurement=measurement.kd_measurement','LEFT');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai_kpi.kd_departemen','LEFT');
        // $this->db->join('('.$where_clause3.') as pkpitb','pkpitb.kd_measurement=pegawai_kpi_d.kd_measurement and pkpitb.kd_departemen=pegawai_kpi.kd_departemen','LEFT');
        $this->db->join('('.$where_clause4.') as pkpitkpi','pkpitkpi.kd_pk=pegawai_kpi.kd_pk','LEFT');
        // $this->db->join('('.$where_clause5.') as pkpit','pkpit.kd_pk=pegawai_kpi.kd_pk and pkpit.kd_measurement=pegawai_kpi_d.kd_measurement','LEFT');
        $this->db->where('pegawai_kpi.nip',$nip);
        $this->db->where('pegawai_kpi.tahun', $tahun);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_pegawai_kpi_header_by_nip($nip,$tahun=''){
        if($tahun==""){
            $tahun=date("Y");
        }
  
//        echo $where_clause4;
        $this->db->select("pegawai_kpi.*,
                            departemen.nm_departemen,
                            pegawai.nama");
        $this->db->from('pegawai_kpi');
        $this->db->join('pegawai','pegawai.nip=pegawai_kpi.nip','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai_kpi.kd_departemen','LEFT');
        $this->db->where('pegawai_kpi.nip',$nip);
        $this->db->where('pegawai_kpi.tahun', $tahun);
        $this->db->order_by('pegawai_kpi.tahun DESC, pegawai_kpi.bulan DESC');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_pegawai_kpi_header_by_bulan_tahun($nip,$bulan,$tahun){
  
//        echo $where_clause4;
        $this->db->select("pegawai_kpi.*,
                            departemen.nm_departemen,
                            pegawai.nama");
        $this->db->from('pegawai_kpi');
        $this->db->join('pegawai','pegawai.nip=pegawai_kpi.nip','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai_kpi.kd_departemen','LEFT');
        $this->db->where('pegawai_kpi.nip',$nip);
        $this->db->where('pegawai_kpi.bulan',$bulan);
        $this->db->where('pegawai_kpi.tahun', $tahun);
        $this->db->order_by('pegawai_kpi.tahun DESC, pegawai_kpi.bulan DESC');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_pegawai_kpi_by_kd_pk($kd_pk){
        
        //get total bobot kpi
        $this->db->select("pegawai_kpi.kd_pk, 
                            sum(pegawai_kpi_d.weightage_kpi) as Tot_bobot_kpi",FALSE);
        $this->db->from('pegawai_kpi');
        $this->db->join('pegawai_kpi_d','pegawai_kpi.kd_pk = pegawai_kpi_d.kd_pk');
        $this->db->group_by('pegawai_kpi.kd_pk');
        $where_clause4 = $this->db->get_compiled_select();
//        echo $where_clause4;
        $this->db->select("pegawai_kpi.*,
                            pegawai_kpi_d.kd_measurement,
                            pegawai_kpi_d.kd_dk,
                            pegawai_kpi_d.weightage_bd,
                            pegawai_kpi_d.weightage_kpi,
                            departemen.nm_departemen,
                            measurement.nm_measurement,
                            measurement.kd_ms,
                            measurement.type,
                            measurement.unit,
                            measurement.period,
                            business_driver.kd_bd, 
                            business_driver.nm_bd,
                            pkpitkpi.Tot_bobot_kpi,
                            pegawai.nama");
        $this->db->from('pegawai_kpi');
        $this->db->join('pegawai','pegawai.nip=pegawai_kpi.nip','LEFT');
        $this->db->join('pegawai_kpi_d','pegawai_kpi.kd_pk = pegawai_kpi_d.kd_pk');
        $this->db->join('measurement','pegawai_kpi_d.kd_measurement=measurement.kd_measurement','LEFT');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai_kpi.kd_departemen','LEFT');
        $this->db->join('('.$where_clause4.') as pkpitkpi','pkpitkpi.kd_pk=pegawai_kpi.kd_pk','LEFT');
        $this->db->where('pegawai_kpi.kd_pk',$kd_pk);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_mesurement_target_pegawai($nip,$measurement,$tahun=''){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('pegawai.kd_departemen');
        $this->db->from('pegawai');
        $this->db->where('pegawai.nip', $nip);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("departemen_kpi.*,
		 measurement.nm_measurement,
		 measurement_target.tahun,
		 measurement_target.target_setahun_aktual,
		 measurement_target_d.bulan,
		 measurement_target_d.target,
		 departemen_kpi.weightage_bd,
		 round((measurement_target_d.target * departemen_kpi.weightage_bd)/100,0) as target_departemen");
        $this->db->from('departemen_kpi');
        $this->db->join('measurement','departemen_kpi.kd_measurement = measurement.kd_measurement','INNER');
        $this->db->join('measurement_target','measurement.kd_measurement = measurement_target.kd_measurement','LEFT');
        $this->db->join('measurement_target_d','measurement_target_d.kd_mt = measurement_target.kd_mt','LEFT');
        $this->db->where("departemen_kpi.kd_departemen in(".$where_clause.")",NULL);
        $this->db->where('measurement_target.tahun', $tahun);
        $this->db->where_in('departemen_kpi.kd_measurement', $measurement);
        $this->db->order_by('measurement.kd_measurement,measurement_target_d.bulan');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function delete_pegawai_kpi_nip($nip,$tahun){
       $this->db->where('nip',$nip);
       $this->db->where('tahun',$tahun);
       $this->db->delete('pegawai_kpi');
    }
    public function delete_pegawai_kpi($kd_pk){
       $this->db->where('kd_pk',$kd_pk);
       $this->db->delete('pegawai_kpi');
    }
    public function insert_pegawai_kpi($data){
       $this->db->insert('pegawai_kpi',$data);
       return $this->db->insert_id();
    }
    public function insert_pegawai_kpi_d($data){
       $this->db->insert('pegawai_kpi_d',$data);
       return $this->db->insert_id();
    }
    public function delete_pegawai_kpi_kd_measurement_departemen($kd_measurement,$kd_departemen,$tahun){
       $this->db->where('kd_departemen',$kd_departemen);
       $this->db->where('kd_measurement',$kd_measurement);
       $this->db->where('tahun',$tahun);
       $this->db->delete('pegawai_kpi');
    }
    public function insert_pegawai_kpi_detail($data){
       $this->db->insert('pegawai_kpi_detail',$data);
       return $this->db->insert_id();
    }
    public function insert_copy_bobot_pegawai_kpi($nip,$thn_berjalan,$thn_lalu,$user,$tgl_input){
        $sql="INSERT INTO `pegawai_kpi` (`kd_pk`,nip, `kd_measurement`,kd_departemen,kd_dk, `weightage_bd`, `weightage_bd_persen`, `weightage_kpi`, `weightage_kpi_persen`, `tahun`, `status`, `user_input`, `tgl_input`) 
                select concat(?,pegawai_kpi.nip,pegawai_kpi.kd_measurement) as kode,
                                        pegawai_kpi.nip,
                                        pegawai_kpi.kd_measurement,
                                        pegawai_kpi.kd_departemen,
                                        pegawai_kpi.kd_dk,
                                        pegawai_kpi.weightage_bd,
                                        pegawai_kpi.weightage_bd_persen,
                                        pegawai_kpi.weightage_kpi,
                                        pegawai_kpi.weightage_kpi_persen,
                                        ? as tahun,
                                        '1' as `status`,
                                        ? as user_input,
                                        ? as tgl_input
                from pegawai_kpi
                where pegawai_kpi.tahun = ? and pegawai_kpi.nip = ?";
        $bind=[$thn_berjalan,$thn_berjalan,$user,$tgl_input,$thn_lalu,$nip];
       // $this->searching->SetSerching($DataSearch);
        return $this->db->query($sql,$bind);
    }
    public function get_pegawai_kpi_by_kd_measurement($kd_measurement,$kd_departemen,$tahun=''){
        if($tahun==""){
            $tahun=date("Y");
        }
        
         // utk mendapatkan data kpi pegawai terupdate
        $this->db->select('pegawai_kpi.nip, max(pegawai_kpi.kd_pk) as kd_pk');
        $this->db->from('pegawai_kpi');
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
        $this->db->where('pegawai_kpi.tahun', $tahun);
        $this->db->group_by('pegawai_kpi.kd_departemen,pegawai_kpi_d.kd_measurement');
        $where_clause3 = $this->db->get_compiled_select();
        
//        echo $where_clause4;
        $this->db->select("pegawai_kpi.*,
                            pegawai_kpi_d.kd_pkd,
                            pegawai_kpi_d.kd_measurement,
                            pegawai_kpi_d.kd_dk,
                            pegawai_kpi_d.weightage_bd,
                            pegawai_kpi_d.weightage_kpi,
                            departemen.nm_departemen,
                            measurement.nm_measurement,
                            measurement.kd_ms,
                            measurement.type,
                            measurement.unit,
                            measurement.period,
                            business_driver.kd_bd, 
                            business_driver.nm_bd,
                            pkpitb.Tot_bobot_bd,
                            pegawai.nama");
        $this->db->from('pegawai_kpi');
        $this->db->join('('.$where_clause.') as max_pk','pegawai_kpi.kd_pk=max_pk.kd_pk');
        $this->db->join('pegawai','pegawai.nip=pegawai_kpi.nip','LEFT');
        $this->db->join('pegawai_kpi_d','pegawai_kpi.kd_pk = pegawai_kpi_d.kd_pk');
        $this->db->join('measurement','pegawai_kpi_d.kd_measurement=measurement.kd_measurement','LEFT');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai_kpi.kd_departemen','LEFT');
        $this->db->join('('.$where_clause3.') as pkpitb','pkpitb.kd_measurement=pegawai_kpi_d.kd_measurement and pkpitb.kd_departemen=pegawai_kpi.kd_departemen','LEFT');
        $this->db->where('pegawai_kpi_d.kd_measurement',$kd_measurement);
        $this->db->where('pegawai_kpi.kd_departemen',$kd_departemen);
        $this->db->where('pegawai_kpi.tahun', $tahun);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function insert_pegawaii_target($data){
       $this->db->insert('pegawai_target',$data);
       return $this->db->insert_id();
    }
    public function insert_pegawaii_target_d_batch($data){
       $this->db->insert_batch('pegawai_target_d',$data);
    }
    public function get_pegawai_kpi_by_kd_measurement_cek($nip,$kd_measurement,$kd_departemen,$bulan,$tahun){
        
        $this->db->select('pegawai_kpi.kd_departemen,pegawai_kpi.kd_measurement, sum(pegawai_kpi.weightage_bd) as Tot_bobot_bd');
        $this->db->from('pegawai_kpi');
        $this->db->where('pegawai_kpi.tahun', $tahun);
        $this->db->group_by('pegawai_kpi.kd_measurement,pegawai_kpi.kd_departemen');
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("pegawai_kpi.*,
                            pegawai.nama,
                            departemen.nm_departemen,
                            measurement.nm_measurement,
                            measurement.kd_ms,
                            business_driver.kd_bd, 
                            business_driver.nm_bd,
                            pkpitb.Tot_bobot_bd");
        $this->db->from('pegawai_kpi');
        $this->db->join('pegawai','pegawai_kpi.nip=pegawai.nip','LEFT');
        $this->db->join('measurement','pegawai_kpi.kd_measurement=measurement.kd_measurement','LEFT');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai_kpi.kd_departemen','LEFT');
        $this->db->join('('.$where_clause.') as pkpitb','pkpitb.kd_measurement=pegawai_kpi.kd_measurement and pkpitb.kd_departemen=pegawai_kpi.kd_departemen','LEFT');
        $this->db->where('pegawai_kpi.kd_measurement',$kd_measurement);
        $this->db->where('pegawai_kpi.kd_departemen',$kd_departemen);
        $this->db->where('pegawai_kpi.tahun', $tahun);
        $this->db->where('pegawai_kpi.bulan', $bulan);
        $this->db->where('pegawai_kpi.nip', $nip);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_pegawai_kpi_d_by_kd_pkd($kd_pkd,$tahun,$bulan){
        $this->db->select('max(measurement_target.kd_mt) kd_mt,measurement_target.kd_measurement');
        $this->db->from('measurement_target');
        $this->db->where('measurement_target.tahun', $tahun);
        $this->db->where('measurement_target.bulan <=', $bulan);
        $this->db->group_by('measurement_target.kd_measurement');
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('sum(departemen_kpi.weightage_bd) Tot_bobot_bd,
                            departemen_kpi.kd_measurement');
        $this->db->from('departemen_kpi');
        $this->db->where('departemen_kpi.tahun', $tahun);
        $this->db->group_by('departemen_kpi.kd_measurement');
        $where_clause2 = $this->db->get_compiled_select();
        
        //get total bobot bd
        $this->db->select(" departemen_kpi.kd_departemen,
                            departemen_kpi.kd_measurement,
                            departemen_kpi.weightage_bd as dk_weightage_bd,
                            ifnull(dp_bobot_bd.Tot_bobot_bd,0) dk_tot_bobot_bd,
                            ((departemen_kpi.weightage_bd/ifnull(dp_bobot_bd.Tot_bobot_bd,0))*100) dk_persen_weightage",FALSE);
        $this->db->from('departemen_kpi');
        $this->db->join('('.$where_clause2.') as dp_bobot_bd','dp_bobot_bd.kd_measurement=departemen_kpi.kd_measurement');
        $this->db->where('departemen_kpi.tahun', $tahun);
        $where_clause3 = $this->db->get_compiled_select();
        
         // utk mendapatkan data kpi pegawai terupdate
        $this->db->select('pegawai_kpi.nip, max(pegawai_kpi.kd_pk) as kd_pk');
        $this->db->from('pegawai_kpi');
        $this->db->group_by('pegawai_kpi.nip');
        $where_clause5 = $this->db->get_compiled_select();
        
        //get total bobot bd
        $this->db->select("pegawai_kpi.kd_departemen,
			pegawai_kpi_d.kd_measurement, 
			sum(pegawai_kpi_d.weightage_bd) as Tot_bobot_bd",FALSE);
        $this->db->from('pegawai_kpi');
        $this->db->join('('.$where_clause5.') as max_pk','pegawai_kpi.kd_pk=max_pk.kd_pk');
        $this->db->join('pegawai_kpi_d','pegawai_kpi.kd_pk = pegawai_kpi_d.kd_pk');
        $this->db->where('pegawai_kpi.tahun', $tahun);
        $this->db->group_by('pegawai_kpi.kd_departemen,pegawai_kpi_d.kd_measurement');
        $where_clause4 = $this->db->get_compiled_select();
//        echo $where_clause4;
        $this->db->select("pegawai_kpi.*,
                            pegawai_kpi_d.kd_pkd,
                            pegawai_kpi_d.kd_measurement,
                            pegawai_kpi_d.kd_dk,
                            pegawai_kpi_d.weightage_bd,
                            pegawai_kpi_d.weightage_kpi,
                            departemen.nm_departemen,
                            measurement.nm_measurement,
                            measurement.kd_ms,
                            measurement_target.type,
                            measurement_target.unit,
                            measurement_target.period,
                            measurement_target.aggregation,
                            business_driver.kd_bd, 
                            business_driver.nm_bd,
                            measurement_target_d.bulan as bulan_target,
                            measurement_target_d.target,
                            dp_bobot_bd.dk_persen_weightage,
                            pkpitb.Tot_bobot_bd,
                            round((pegawai_kpi_d.weightage_bd/pkpitb.Tot_bobot_bd)*100,2) as pk_persen_weightage");
        $this->db->from('pegawai_kpi');
        $this->db->join('pegawai_kpi_d','pegawai_kpi.kd_pk = pegawai_kpi_d.kd_pk');
        $this->db->join('measurement','pegawai_kpi_d.kd_measurement=measurement.kd_measurement','LEFT');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai_kpi.kd_departemen','LEFT');
        $this->db->join('measurement_target','measurement_target.kd_measurement=measurement.kd_measurement');
        $this->db->join('('.$where_clause.') as max_mt','measurement_target.kd_mt=max_mt.kd_mt');
        $this->db->join('measurement_target_d','measurement_target_d.kd_mt=measurement_target.kd_mt');
        $this->db->join('('.$where_clause3.') as dp_bobot_bd','dp_bobot_bd.kd_departemen=pegawai_kpi.kd_departemen and dp_bobot_bd.kd_measurement=pegawai_kpi_d.kd_measurement');
        $this->db->join('('.$where_clause4.') as pkpitb','pkpitb.kd_measurement=pegawai_kpi_d.kd_measurement and pkpitb.kd_departemen=pegawai_kpi.kd_departemen','LEFT');
        $this->db->where('pegawai_kpi_d.kd_pkd',$kd_pkd);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_pegawai_target_by_kd_pkd($kd_pkd){
       
//        echo $where_clause4;
        $this->db->select("pegawai_kpi_d.*,
                            measurement.nm_measurement,
                            business_driver.kd_bd, 
                            business_driver.nm_bd,
                            pegawai_kpi.nip");
        $this->db->from('pegawai_kpi_d');
        $this->db->join('pegawai_kpi','pegawai_kpi_d.kd_pk=pegawai_kpi.kd_pk','LEFT');
        $this->db->join('measurement','pegawai_kpi_d.kd_measurement=measurement.kd_measurement','LEFT');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->where('pegawai_kpi_d.kd_pkd',$kd_pkd);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function delete_pegawai_target_kd_pk_measurement($kd_pk,$kd_measurement){
       $this->db->where('kd_pk',$kd_pk);
       $this->db->where('kd_measurement',$kd_measurement);
       $this->db->delete('pegawai_target');
    }
    public function get_appraisal_nip_monthly($nip,$bulan,$tahun){
     
        
        $this->db->select("appraisal.*",FALSE);
        $this->db->from('appraisal');
//        $this->db->join('appraisal_detail','appraisal.kd_appraisal = appraisal_detail.kd_appraisal');
        $this->db->where('appraisal.bulan',$bulan);
        $this->db->where('appraisal.tahun',$tahun);
        $this->db->where('appraisal.nip',$nip);
//        $this->db->group_by("appraisal.nip");
        $query = $this->db->get();
        
        return $query;
    }
    public function get_appraisal_nip_yearly($nip,$tahun){
     
        
        $this->db->select("appraisal.nip,
                            appraisal.tahun,
                            round(avg(appraisal.point),2)as point",FALSE);
        $this->db->from('appraisal');
//        $this->db->join('appraisal_detail','appraisal.kd_appraisal = appraisal_detail.kd_appraisal');
        $this->db->where('appraisal.tahun',$tahun);
        $this->db->where('appraisal.nip',$nip);
       $this->db->group_by("appraisal.nip,
                            appraisal.tahun");
        $query = $this->db->get();
    //    echo $this->db->last_query();
    //    die();        
        return $query;
    }
    public function get_appraisal_history_nip($nip,$bulan,$tahun){
     
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        
        $this->db->select("appraisal.nip,
                            pegawai.nama,
                            appraisal.tahun,
                            appraisal.bulan,
                            IFNULL(appraisal.point,0)point",FALSE);
        $this->db->from('appraisal');
//        $this->db->join('appraisal_detail','appraisal.kd_appraisal = appraisal_detail.kd_appraisal');
        $this->db->join('pegawai','pegawai.nip = appraisal.nip');
        $this->db->where('appraisal.nip',$nip);
        $this->db->where("concat(appraisal.tahun,if(appraisal.bulan<10,concat('0',appraisal.bulan),appraisal.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
//        $this->db->group_by("appraisal.nip,
//                            pegawai.nama,
//                            appraisal.tahun,
//                            appraisal.bulan");
        $this->db->order_by("appraisal.tahun DESC, appraisal.bulan DESC");

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_appraisal_chart_monthly_nip($nip,$bulan,$tahun){
     
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        
        $this->db->select("appraisal.nip,
                            pegawai.nama,
                            appraisal.tahun,
                            appraisal.bulan,
                            IFNULL(appraisal.point,0)point",FALSE);
        $this->db->from('appraisal');
//        $this->db->join('appraisal_detail','appraisal.kd_appraisal = appraisal_detail.kd_appraisal');
        $this->db->join('pegawai','pegawai.nip = appraisal.nip');
        $this->db->where('appraisal.nip',$nip);
        $this->db->where("concat(appraisal.tahun,if(appraisal.bulan<10,concat('0',appraisal.bulan),appraisal.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
//        $this->db->group_by("appraisal.nip,
//                            pegawai.nama,
//                            appraisal.tahun,
//                            appraisal.bulan");
        $this->db->order_by("appraisal.tahun ASC, appraisal.bulan ASC");

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $temp_nip="";
        $NoUrut=0;
        foreach($query->result() as $row){
            if($temp_nip!=$row->nip){
                $temp_nip=$row->nip;
                $NoUrut++;
            }
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
            $Data['bulan'][$row->tahun.$bulan]= getNamaBulanMin($row->bulan)." ".substr($row->tahun,2);
            $Data['legend'][$row->nip]=$row->nama;
            $Data['color'][$row->nip]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->nip]["code"] =$row->nip;
            $Data['data_grafik'][$row->nip]["nama"] =$row->nama;
            $Data['data_grafik'][$row->nip]["score"][$row->tahun.$row->bulan] =$row->point;
        }
//        var_dump($Data);
//        die();
        return $Data;
    }
    public function get_appraisal_history_nip_yearly($nip,$tahun){
     
        $thnAwal=$tahun-10;
        $thnAkhir=$tahun;
        
        $this->db->select("appraisal.nip,
                            pegawai.nama,
                            appraisal.tahun,
                            round(avg(IFNULL(appraisal.point,0)),2) point",FALSE);
        $this->db->from('appraisal');
//        $this->db->join('appraisal_detail','appraisal.kd_appraisal = appraisal_detail.kd_appraisal');
        $this->db->join('pegawai','pegawai.nip = appraisal.nip');
        $this->db->where('appraisal.nip',$nip);
        $this->db->where("appraisal.tahun between '$thnAwal' and '$thnAkhir'",NULL);
       $this->db->group_by("appraisal.nip,
                           pegawai.nama,
                           appraisal.tahun,
                           appraisal.bulan");
        $this->db->order_by("appraisal.tahun DESC, appraisal.bulan DESC");

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_appraisal_chart_yearly_nip($nip,$tahun){
     
        $thnAwal=$tahun-10;
        $thnAkhir=$tahun;
        
        $this->db->select("appraisal.nip,
                            pegawai.nama,
                            appraisal.tahun,
                            round(avg(IFNULL(appraisal.point,0)),2) point",FALSE);
        $this->db->from('appraisal');
//        $this->db->join('appraisal_detail','appraisal.kd_appraisal = appraisal_detail.kd_appraisal');
        $this->db->join('pegawai','pegawai.nip = appraisal.nip');
        $this->db->where('appraisal.nip',$nip);
        $this->db->where("appraisal.tahun between '$thnAwal' and '$thnAkhir'",NULL);
       $this->db->group_by("appraisal.nip,
                           pegawai.nama,
                           appraisal.tahun");
        $this->db->order_by("appraisal.tahun ASC, appraisal.bulan ASC");

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $temp_nip="";
        $NoUrut=0;
        foreach($query->result() as $row){
            if($temp_nip!=$row->nip){
                $temp_nip=$row->nip;
                $NoUrut++;
            }
            $Data['bulan'][$row->tahun]= substr($row->tahun,2);
            $Data['legend'][$row->nip]=$row->nama;
            $Data['color'][$row->nip]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->nip]["code"] =$row->nip;
            $Data['data_grafik'][$row->nip]["nama"] =$row->nama;
            $Data['data_grafik'][$row->nip]["score"][$row->tahun] =$row->point;
        }
//        var_dump($Data);
//        die();
        return $Data;
    }
    protected function list_warna($no){
        $list_warna[1]="#00c5dc";
        $list_warna[2]="#34bfa3";
        $list_warna[3]="#ffb822";
        $list_warna[4]="#f4516c";
        $list_warna[5]="#5867dd";
        $list_warna[6]="#36a3f7";
        if(isset($list_warna[$no])){
            return $list_warna[$no];
        }else{
            return $this->rand_color();
        }
        
    }
    function rand_color() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
    
    public function getDataMeasurement($kd_measurement)
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

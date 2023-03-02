<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Weightage_peg_model extends CI_Model
{
    public function get_weightage_peg_by_kdPk($kd_pk){
        
        $sql="SELECT 	pk.kd_pk,
                        pk.nip,
                        pg.nama,
                        pk.bulan,
                        pk.tahun,
                        ms.kd_ms,
                        ms.nm_measurement,
                        pd.weightage_kpi,
                        tb.TotalBobot,
                        ifnull(ROUND(((pd.weightage_kpi/tb.TotalBobot)*100),0),0) AS bobot
                FROM pegawai_kpi pk
                INNER JOIN pegawai_kpi_d pd ON pk.kd_pk = pd.kd_pk
                INNER JOIN pegawai pg ON pk.nip = pg.nip 
                INNER JOIN measurement ms ON pd.kd_measurement = ms.kd_measurement
                INNER JOIN (
                SELECT pd.kd_pk, SUM(pd.weightage_kpi) TotalBobot
                FROM pegawai_kpi_d pd
                GROUP BY pd.kd_pk
                )tb ON tb.kd_pk = pk.kd_pk 
                WHERE pk.kd_pk = ?
                ";
        $bind=[$kd_pk];
        $query=$this->db->query($sql,$bind);
        
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_target_peg_by_kdPk($kd_pk){
        
        $sql="
        SELECT pt.nip,
                    pg.nama,
                    pt.kd_measurement,
                    ms.nm_measurement,
                    ms.unit,
                    pt.bulan AS bln_efektif,
                    pt.tahun AS thn_efektif,
                    pt.target_setahun,
                    pt.target_setahun_aktual,
                    group_concat(pd.bulan ORDER BY pd.bulan ASC) bulan,
                    group_concat(pd.target ORDER BY pd.bulan ASC) target
        FROM pegawai_target pt
        INNER JOIN pegawai_target_d pd ON pt.kd_pt = pd.kd_pt
        INNER JOIN pegawai pg ON pg.nip = pt.nip
        INNER JOIN measurement ms ON ms.kd_measurement = pt.kd_measurement
        WHERE pt.kd_pk = ?
        GROUP BY  pt.nip,
                    pg.nama,
                    pt.kd_measurement,
                    ms.nm_measurement,
                    ms.unit,
                    pt.bulan,
                    pt.tahun,
                    pt.target_setahun,
                    pt.target_setahun_aktual";
        $bind=[$kd_pk];
        $query=$this->db->query($sql,$bind);
        // echo $this->db->last_query();die;
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_pegawai_target_by_kd_pk_weightage_peg($kd_pk,$kd_measurement){
       
        //        echo $where_clause4;
                $this->db->select("pegawai_target.*,
                                    pegawai_target_d.bulan as bulan_target,
                                    pegawai_target_d.target,
                                    departemen.nm_departemen,
                                    measurement.nm_measurement,
                                    business_driver.kd_bd, 
                                    business_driver.nm_bd");
                $this->db->from('pegawai_target');
                //$this->db->join('pegawai_target','pegawai_kpi.kd_pk = pegawai_target.kd_pk');
                $this->db->join('pegawai_target_d','pegawai_target_d.kd_pt = pegawai_target.kd_pt');
                $this->db->join('measurement','pegawai_target.kd_measurement=measurement.kd_measurement','LEFT');
                $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
                $this->db->join('departemen','departemen.kd_departemen=pegawai_target.kd_departemen','LEFT');
                $this->db->where('pegawai_target.kd_pk',$kd_pk);
                $this->db->where('pegawai_target.kd_measurement',$kd_measurement);
                $this->db->order_by('pegawai_target_d.bulan ASC');
                $query = $this->db->get();
        //        echo $this->db->last_query();
        //        die();
               // $this->searching->SetSerching($DataSearch);
                return $query;
            }
    public function get_weightage_peg_all_perusahaan($kd_perusahaan,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("weightage_peg.*,perusahaan.nm_perusahaan");
        $this->db->from('weightage_peg');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=weightage_peg.kd_perusahaan','LEFT');
        $this->db->where('weightage_peg.kd_perusahaan',$kd_perusahaan);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function insert_pegawai_target_batch($data){
        $this->db->insert_batch('pegawai_target',$data);
        return $this->db->insert_id();
    }
    public function insert_pegawai_target_d_batch($data){
       $this->db->insert_batch('pegawai_target_d',$data);
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
    public function delete_pegawai_target_kd_pk_measurement($kd_pk,$kd_measurement){
        $this->db->where('kd_pk',$kd_pk);
        $this->db->where('kd_measurement',$kd_measurement);
        $this->db->delete('pegawai_target');
     }
    public function get_pegawai_order_dept($kd_perusahaan,$nipReportTo='',$statusAdmin=TRUE)
    {
        $this->db->select("pegawai.*,perusahaan.nm_perusahaan, departemen.nm_departemen, jabatan.nm_jabatan");
        $this->db->from('pegawai');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=pegawai.kd_perusahaan','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai.kd_departemen','LEFT');
        $this->db->join('jabatan','jabatan.kd_jabatan=pegawai.kd_jabatan','LEFT');
        $this->db->where('pegawai.kd_perusahaan',$kd_perusahaan);
        if(!$statusAdmin){
            $this->db->where('pegawai.report_to',$nipReportTo);
        }
        
        $this->db->order_by('departemen.nm_departemen');
        $query = $this->db->get();
        return $query;
    }
    public function get_departemen_kpi_pegawai($ListNIP,$tahun=''){
        
        if($tahun==""){
            $tahun=date("Y");
        }
        $nip = implode("','",$ListNIP);
        $nip = "'".$nip."'";
       $this->db->select('pegawai.kd_departemen');
       $this->db->from('pegawai');
       $this->db->where('pegawai.nip in ('.$nip.')', NULL);
       $where_clause = $this->db->get_compiled_select();
        
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
        $this->db->where('departemen_kpi.kd_departemen IN ('.$where_clause.')',NULL);
        $this->db->where('departemen_kpi.tahun', $tahun);
        $this->db->order_by('departemen.nm_departemen,measurement.nm_measurement');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        $Data=array();
        $KdDeptTemp="";
        if($query->num_rows()>0){
            foreach($query->result() as $row){
                if($row->kd_departemen!=$KdDeptTemp){
                    $KdDeptTemp=$row->kd_departemen;
                    $Data['dept'][$row->kd_departemen]=$row->nm_departemen;
                }
                $Data['ms'][$row->kd_departemen][$row->kd_measurement]['nm_measurement']=$row->nm_measurement;
                $Data['ms'][$row->kd_departemen][$row->kd_measurement]['kd_ms']=$row->kd_ms;
            }
        }
        return $Data;
    }
    public function get_pegawai_list_nip($ListNIP){
        $nip = implode("','",$ListNIP);
        $nip = "'".$nip."'";
        $this->db->select("pegawai.*,perusahaan.nm_perusahaan, departemen.nm_departemen, jabatan.nm_jabatan");
        $this->db->from('pegawai');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=pegawai.kd_perusahaan','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai.kd_departemen','LEFT');
        $this->db->join('jabatan','jabatan.kd_jabatan=pegawai.kd_jabatan','LEFT');
        $this->db->where('pegawai.nip IN ('.$nip.')',NULL);
        
        $this->db->order_by('departemen.nm_departemen');
        $query = $this->db->get();
        $Data=array();
        if($query->num_rows()>0){
            foreach($query->result() as $row){
                $Data[$row->kd_departemen][$row->nip]['nama']=$row->nama;
                $Data[$row->kd_departemen][$row->nip]['jabatan']=$row->nm_jabatan;
                $Data[$row->kd_departemen][$row->nip]['departemen']=$row->nm_departemen;
            }
        }
        return $Data;
    }
    public function get_departemen_kpi_pegawai_list_ms($ListMS,$tahun=''){
        
        if($tahun==""){
            $tahun=date("Y");
        }
        $kd_measurement = implode("','",$ListMS);
        $kd_measurement = "'".$kd_measurement."'";
        
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
        $this->db->where('departemen_kpi.tahun', $tahun);
        $this->db->where('departemen_kpi.kd_measurement IN('.$kd_measurement.')',NULL);
        $this->db->order_by('departemen.nm_departemen,measurement.nm_measurement');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        $Data=array();
        $KdDeptTemp="";
        if($query->num_rows()>0){
            foreach($query->result() as $row){
                if($row->kd_departemen!=$KdDeptTemp){
                    $KdDeptTemp=$row->kd_departemen;
                    $Data['dept'][$row->kd_departemen]=$row->nm_departemen;
                }
                $Data['ms'][$row->kd_departemen][$row->kd_measurement]['nm_measurement']=$row->nm_measurement;
                $Data['ms'][$row->kd_departemen][$row->kd_measurement]['kd_ms']=$row->kd_ms;
            }
        }
        return $Data;
    }
    public function getDataMeasurementListMs($ListNIP,$ListMS,$tahun,$bulan)
    {
        $kd_measurement = implode("','",$ListMS);
        $kd_measurement = "'".$kd_measurement."'";
        $this->db->select('max(measurement_target.kd_mt) kd_mt,measurement_target.kd_measurement');
        $this->db->from('measurement_target');
        $this->db->where('measurement_target.tahun', $tahun);
        $this->db->where('measurement_target.bulan <=', $bulan);
        $this->db->group_by('measurement_target.kd_measurement');
        $where_clause = $this->db->get_compiled_select();

        $nip = implode("','",$ListNIP);
        $nip = "'".$nip."'";
        $this->db->select('pegawai.kd_departemen');
        $this->db->from('pegawai');
        $this->db->where('pegawai.nip in ('.$nip.')', NULL);
        $where_clause1 = $this->db->get_compiled_select();

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

        $this->db->select("measurement_target.*,
                            departemen_kpi.kd_departemen,
                            measurement.nm_measurement, 
                            measurement.kd_ms,
                            departemen.nm_departemen,
                            business_driver.kd_bd, 
                            business_driver.nm_bd,
                            dp_bobot_bd.dk_persen_weightage,
                            pkpitb.Tot_bobot_bd as Tot_bobot_bd_peg");
        $this->db->from('measurement_target');
        $this->db->join('('.$where_clause.') as max_mt','measurement_target.kd_mt=max_mt.kd_mt');
        $this->db->join('measurement','measurement.kd_measurement=measurement_target.kd_measurement','LEFT');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('departemen_kpi','departemen_kpi.kd_measurement=measurement.kd_measurement','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=departemen_kpi.kd_departemen','LEFT');
        $this->db->join('('.$where_clause3.') as dp_bobot_bd','dp_bobot_bd.kd_departemen=departemen_kpi.kd_departemen and dp_bobot_bd.kd_measurement=departemen_kpi.kd_measurement');
        $this->db->join('('.$where_clause4.') as pkpitb','pkpitb.kd_measurement=departemen_kpi.kd_measurement and pkpitb.kd_departemen=departemen_kpi.kd_departemen','LEFT');
        $this->db->where('departemen_kpi.kd_departemen IN ('.$where_clause1.')',NULL);
        $this->db->where('measurement_target.kd_measurement IN('.$kd_measurement.')',NULL);
        $query = $this->db->get();
        $Data=array();
        $KdDeptTemp="";
        if($query->num_rows()>0){
            foreach($query->result() as $row){
                if($row->kd_departemen!=$KdDeptTemp){
                    $KdDeptTemp=$row->kd_departemen;
                    $Data['dept'][$row->kd_departemen]=$row->nm_departemen;
                }
                $Data['ms'][$row->kd_departemen][$row->kd_measurement]['nm_measurement']=$row->nm_measurement;
                $Data['ms'][$row->kd_departemen][$row->kd_measurement]['kd_ms']=$row->kd_ms;
                $Data['ms'][$row->kd_departemen][$row->kd_measurement]['type']=$row->type;
                $Data['ms'][$row->kd_departemen][$row->kd_measurement]['unit']=$row->unit;
                $Data['ms'][$row->kd_departemen][$row->kd_measurement]['period']=$row->period;
                $Data['ms'][$row->kd_departemen][$row->kd_measurement]['aggregation']=$row->aggregation;
                $Data['ms'][$row->kd_departemen][$row->kd_measurement]['target_setahun_aktual']=$row->target_setahun_aktual;
                $Data['ms'][$row->kd_departemen][$row->kd_measurement]['dk_persen_weightage']=$row->dk_persen_weightage;
                $Data['ms'][$row->kd_departemen][$row->kd_measurement]['Tot_bobot_bd_peg']=$row->Tot_bobot_bd_peg;
            }
        }
        return $Data;
    }
    public function get_pegawai_list_nip_dataPeg($ListNIP){
        $nip = implode("','",$ListNIP);
        $nip = "'".$nip."'";
        $this->db->select("pegawai.*,perusahaan.nm_perusahaan, departemen.nm_departemen, jabatan.nm_jabatan");
        $this->db->from('pegawai');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=pegawai.kd_perusahaan','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=pegawai.kd_departemen','LEFT');
        $this->db->join('jabatan','jabatan.kd_jabatan=pegawai.kd_jabatan','LEFT');
        $this->db->where('pegawai.nip IN ('.$nip.')',NULL);
        
        $this->db->order_by('departemen.nm_departemen');
        $query = $this->db->get();
        $Data=array();
        if($query->num_rows()>0){
            foreach($query->result() as $row){
                $Data[$row->nip]['nama']=$row->nama;
                $Data[$row->nip]['jabatan']=$row->nm_jabatan;
                $Data[$row->nip]['kd_departemen']=$row->$row->kd_departemen;
                $Data[$row->nip]['nm_departemen']=$row->nm_departemen;
            }
        }
        return $Data;
    }
}

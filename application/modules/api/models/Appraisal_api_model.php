<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appraisal_api_model extends CI_Model{
    public function get_profil_pegawai($nip,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('appraisal.kd_appraisal,
                            appraisal.nip,
                            appraisal.tahun,
                            appraisal.bulan,
                            appraisal.point as score_point');
        $this->db->from('appraisal');
//        $this->db->join('appraisal_detail','appraisal.kd_appraisal = appraisal_detail.kd_appraisal');
        $this->db->where('appraisal.tahun', $tahun);
        $this->db->where('appraisal.bulan', $bulan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('appraisal.kd_appraisal,
                            appraisal.nip,
                            appraisal.tahun,
                            appraisal.bulan,
                            appraisal.point as score_point');
        $this->db->from('appraisal');
        $this->db->join('appraisal_detail','appraisal.kd_appraisal = appraisal_detail.kd_appraisal');
        $this->db->where('appraisal.tahun', $tahun);
        $where_clause2 = $this->db->get_compiled_select();
        
        
        $this->db->select('tbl_appr.nip, avg(ifnull(tbl_appr.score_point,0))as score_point');
        $this->db->from('('.$where_clause2.') tbl_appr');
        $this->db->group_by('tbl_appr.nip');
        $where_clause3 = $this->db->get_compiled_select();
        
        $Upload_Path = base_url('assets/upload/foto/');
        $this->db->select("pegawai.nip,
			pegawai.nama,
			pegawai.tgl_masuk,
			pegawai.dob,
			pegawai.tgl_keluar,
			pegawai.kd_departemen,
			departemen.nm_departemen,
			pegawai.kd_jabatan,
			jabatan.nm_jabatan,
			pegawai.kd_perusahaan,
			perusahaan.nm_perusahaan,
			pegawai.report_to as nip_atasan,
			pg.nama as nm_atasan,
			pegawai.`status`,
                        case
                            when pegawai.`status` = 1 then 'Active'
                            when pegawai.`status` = 2 then 'Resign'
                            else ''
                        end nm_status,    
			pegawai.jenis_kelamin,
                        case
                            when pegawai.foto <> '' then concat('".$Upload_Path."',pegawai.foto)
                            else ''
                        end foto,
			round(ifnull(score_setahun.score_point,0),2) as score_point_tahun,
			round(ifnull(score_sebulan.score_point,0),2) as score_bulan",false);
        $this->db->from('pegawai');
        $this->db->join('perusahaan','pegawai.kd_perusahaan = perusahaan.kd_perusahaan','LEFT');
        $this->db->join('departemen','pegawai.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->join('jabatan','pegawai.kd_jabatan = jabatan.kd_jabatan','LEFT');
        $this->db->join('pegawai pg','pegawai.report_to = pg.nip','LEFT');
        $this->db->join('('.$where_clause3.') score_setahun','pegawai.nip = score_setahun.nip','LEFT');
        $this->db->join('('.$where_clause.') score_sebulan','pegawai.nip = score_sebulan.nip','LEFT');
        $this->db->where('pegawai.nip',$nip);
        
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    
    public function get_list_pegawai_report_to($nip,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('appraisal.kd_appraisal,
                            appraisal.nip,
                            appraisal.tahun,
                            appraisal.bulan,
                            appraisal.point as score_point');
        $this->db->from('appraisal');
//        $this->db->join('appraisal_detail','appraisal.kd_appraisal = appraisal_detail.kd_appraisal');
        $this->db->where('appraisal.tahun', $tahun);
        $this->db->where('appraisal.bulan', $bulan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('appraisal.kd_appraisal,
                            appraisal.nip,
                            appraisal.tahun,
                            appraisal.bulan,
                            appraisal.point as score_point');
        $this->db->from('appraisal');
        //$this->db->join('appraisal_detail','appraisal.kd_appraisal = appraisal_detail.kd_appraisal');
        $this->db->where('appraisal.tahun', $tahun);
        $where_clause2 = $this->db->get_compiled_select();
        
        
        $this->db->select('tbl_appr.nip,avg(ifnull(tbl_appr.score_point,0))as score_point');
        $this->db->from('('.$where_clause2.') tbl_appr');
        $this->db->group_by('tbl_appr.nip');
        $where_clause3 = $this->db->get_compiled_select();
        
        $Upload_Path = base_url('assets/upload/foto/');
        $LinkNoImage= base_url('assets/img/NoImage.png');
        $this->db->select("pegawai.nip,
			pegawai.nama,
			pegawai.tgl_masuk,
			pegawai.dob,
			pegawai.tgl_keluar,
			pegawai.kd_departemen,
			departemen.nm_departemen,
			pegawai.kd_jabatan,
			jabatan.nm_jabatan,
			pegawai.kd_perusahaan,
			perusahaan.nm_perusahaan,
			pegawai.report_to as nip_atasan,
			pg.nama as nm_atasan,
			pegawai.`status`,
                        case
                            when pegawai.`status` = 1 then 'Active'
                            when pegawai.`status` = 2 then 'Resign'
                            else ''
                        end nm_status,    
			pegawai.jenis_kelamin,
                        case
                            when pegawai.foto <> '' then concat('".$Upload_Path."',pegawai.foto)
                            else '".$LinkNoImage."'
                        end foto,
			round(ifnull(score_setahun.score_point,0),2) as score_point_tahun,
			round(ifnull(score_sebulan.score_point,0),2) as score_bulan",false);
        $this->db->from('pegawai');
        $this->db->join('perusahaan','pegawai.kd_perusahaan = perusahaan.kd_perusahaan','LEFT');
        $this->db->join('departemen','pegawai.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->join('jabatan','pegawai.kd_jabatan = jabatan.kd_jabatan','LEFT');
        $this->db->join('pegawai pg','pegawai.report_to = pg.nip','LEFT');
        $this->db->join('('.$where_clause3.') score_setahun','pegawai.nip = score_setahun.nip','LEFT');
        $this->db->join('('.$where_clause.') score_sebulan','pegawai.nip = score_sebulan.nip','LEFT');
        $this->db->where('pegawai.report_to',$nip);
        
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    
    public function get_detail_kpi_pegawai($nip,$tahun,$bulan){
        
        $this->db->select("appraisal.kd_appraisal,
			appraisal.nip,
			pegawai.nama,
			appraisal.bulan,
			appraisal.tahun,
			appraisal.kd_departemen,
			departemen.nm_departemen,
			appraisal.kd_jabatan,
			jabatan.nm_jabatan,
			appraisal_detail.kd_measurement,
			measurement.nm_measurement,
			round(appraisal_detail.score_kpi,2) as point_kpi",false);
        $this->db->from('appraisal');
        $this->db->join('appraisal_detail','appraisal.kd_appraisal = appraisal_detail.kd_appraisal');
        $this->db->join('measurement','measurement.kd_measurement = appraisal_detail.kd_measurement');
        $this->db->join('pegawai','pegawai.nip = appraisal.nip');
        $this->db->join('departemen','appraisal.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->join('jabatan','appraisal.kd_jabatan = jabatan.kd_jabatan','LEFT');
        $this->db->where('appraisal.nip',$nip);
        $this->db->where('appraisal.bulan',$bulan);
        $this->db->where('appraisal.tahun',$tahun);
        
        $query=$this->db->get();
        
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_profil_pegawai_api($nip,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('appraisal.kd_appraisal,
                            appraisal.nip,
                            appraisal.tahun,
                            appraisal.bulan,
                            appraisal.point as score_point');
        $this->db->from('appraisal');
//        $this->db->join('appraisal_detail','appraisal.kd_appraisal = appraisal_detail.kd_appraisal');
        $this->db->where('appraisal.tahun', $tahun);
        $this->db->where('appraisal.bulan', $bulan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('appraisal.kd_appraisal,
                            appraisal.nip,
                            appraisal.tahun,
                            appraisal.bulan,
                            appraisal.point as score_point');
        $this->db->from('appraisal');
        //$this->db->join('appraisal_detail','appraisal.kd_appraisal = appraisal_detail.kd_appraisal');
        $this->db->where('appraisal.tahun', $tahun);
        $where_clause2 = $this->db->get_compiled_select();
        
        
        $this->db->select('tbl_appr.nip, avg(ifnull(tbl_appr.score_point,0))as score_point');
        $this->db->from('('.$where_clause2.') tbl_appr');
        $this->db->group_by('tbl_appr.nip');
        $where_clause3 = $this->db->get_compiled_select();
        
        $Upload_Path = base_url('assets/upload/foto/');
        $this->db->select("pegawai.nip,
			pegawai.nama,
			pegawai.tgl_masuk,
			pegawai.dob,
			pegawai.tgl_keluar,
			pegawai.kd_departemen,
			departemen.nm_departemen,
			pegawai.kd_jabatan,
			jabatan.nm_jabatan,
			pegawai.kd_perusahaan,
			perusahaan.nm_perusahaan,
			pegawai.report_to as nip_atasan,
			pg.nama as nm_atasan,
			pegawai.`status`,
                        case
                            when pegawai.`status` = 1 then 'Active'
                            when pegawai.`status` = 2 then 'Resign'
                            else ''
                        end nm_status,    
			pegawai.jenis_kelamin,
                        case
                            when pegawai.foto <> '' then concat('".$Upload_Path."',pegawai.foto)
                            else ''
                        end foto,
			round(ifnull(score_setahun.score_point,0),2) as score_tahun,
			round(ifnull(score_sebulan.score_point,0),2) as score_bulan",false);
        $this->db->from('pegawai');
        $this->db->join('perusahaan','pegawai.kd_perusahaan = perusahaan.kd_perusahaan','LEFT');
        $this->db->join('departemen','pegawai.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->join('jabatan','pegawai.kd_jabatan = jabatan.kd_jabatan','LEFT');
        $this->db->join('pegawai pg','pegawai.report_to = pg.nip','LEFT');
        $this->db->join('('.$where_clause3.') score_setahun','pegawai.nip = score_setahun.nip','LEFT');
        $this->db->join('('.$where_clause.') score_sebulan','pegawai.nip = score_sebulan.nip','LEFT');
        $this->db->where('pegawai.nip',$nip);
        
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_peg_kpi_perbulan_api($nip,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        
        // $this->db->select('appraisal.kd_appraisal,
        //                     appraisal.nip,
        //                     pegawai.nama,
        //                     appraisal.tahun,
        //                     appraisal.bulan,
        //                     appraisal.point as score_point,
        //                     appraisal_detail.kd_measurement,
        //                     measurement.nm_measurement,
        //                     round(appraisal_detail.weightage_bd,2)weightage_bd,
        //                     round(appraisal_detail.weightage_kpi,2)weightage_kpi,
        //                     round(appraisal_detail.weightage_bd_dept,2)weightage_bd_dept,
        //                     appraisal_detail.target,
        //                     round(appraisal_detail.score_bd,2)score_bd,
        //                     round(appraisal_detail.score_kpi,2)score_kpi,
        //                     appraisal_detail.actual,
        //                     round(appraisal_detail.result,2)result,
        //                     round(appraisal_detail.point_result,2)point_result,
        //                     appraisal_detail.type,
        //                     appraisal_detail.unit,
        //                     appraisal_detail.period
        //                     ');
        // $this->db->from('appraisal');
        // $this->db->join('appraisal_detail','appraisal.kd_appraisal=appraisal_detail.kd_appraisal','left');
        // $this->db->join('pegawai','appraisal.nip=pegawai.nip','left');
        // $this->db->join('measurement','appraisal_detail.kd_measurement=measurement.kd_measurement','left');
        // $this->db->where("appraisal.tahun",$tahun);
        // $this->db->where("appraisal.bulan",$bulan);
        // $this->db->where('appraisal.nip', $nip);
       
        $this->db->select("appraisal.kd_appraisal,
                            appraisal.nip,
                            appraisal.tahun,
                            appraisal.bulan,
                            appraisal.point as score_point,
                            appraisal_detail.kd_ad,
                            appraisal_detail.kd_measurement,
                            appraisal_detail.weightage_bd,
                            FORMAT(appraisal_detail.weightage_kpi,2) as weightage_kpi,
                            appraisal_detail.weightage_bd_dept,
                            appraisal_detail.target,
                            appraisal_detail.score_bd,
                            FORMAT(appraisal_detail.score_kpi,2) as score_kpi,
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
                            measurement.nm_measurement");
        $this->db->from('appraisal');
        $this->db->join('appraisal_detail','appraisal_detail.kd_appraisal=appraisal.kd_appraisal','LEFT');
        $this->db->join('pegawai','pegawai.nip=appraisal.nip','LEFT');
        $this->db->join('measurement','measurement.kd_measurement=appraisal_detail.kd_measurement','LEFT');
        $this->db->where("appraisal.tahun",$tahun);
        $this->db->where("appraisal.bulan",$bulan);
        $this->db->where('appraisal.nip', $nip);
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_peg_kpi_rekap_setahun_api($nip,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        
        $this->db->select('appraisal.kd_appraisal,
                            appraisal.nip,
                            pegawai.nama,
                            appraisal.tahun,
                            appraisal.bulan,
                            appraisal.point as score_point');
        $this->db->from('appraisal');
        $this->db->join('pegawai','appraisal.nip=pegawai.nip','left');
        $this->db->where("concat(appraisal.tahun,if(appraisal.bulan<10,concat('0',appraisal.bulan),appraisal.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $this->db->where('appraisal.nip', $nip);
       
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_peg_kpi_rekap_setahun_api2($nip,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        
        $this->db->select('appraisal.kd_appraisal,
                            appraisal.nip,
                            pegawai.nama,
                            appraisal.tahun,
                            appraisal.bulan,
                            appraisal.point as score_point');
        $this->db->from('appraisal');
        $this->db->join('pegawai','appraisal.nip=pegawai.nip','left');
        // $this->db->where("concat(appraisal.tahun,if(appraisal.bulan<10,concat('0',appraisal.bulan),appraisal.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $this->db->where('appraisal.nip', $nip);
        $this->db->where('appraisal.tahun', $tahun);
       
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_kpi_pegawai_setahun($nip,$tahun){
        
        $this->db->select("appraisal.kd_appraisal,
                            appraisal.nip,
                            pegawai.nama,
                            appraisal.tahun,
                            appraisal.bulan,
                            appraisal.point as score_point",false);
        $this->db->from('appraisal');
//        $this->db->join('appraisal_detail','appraisal.kd_appraisal = appraisal_detail.kd_appraisal');
        $this->db->join('pegawai','pegawai.nip = appraisal.nip');
        $this->db->where('appraisal.nip',$nip);
        $this->db->where('appraisal.tahun',$tahun);
//        $this->db->group_by('appraisal.kd_appraisal,
//                            appraisal.nip,
//                            pegawai.nama,
//                            appraisal.tahun,
//                            appraisal.bulan');
        
        $query=$this->db->get();
        
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function update_pegawai_api($nip,$data){
        $this->db->where('nip',$nip);
        $this->db->update('pegawai',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function update_users_api($id,$data){
        $this->db->where('id',$id);
        $this->db->update('users',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function get_pegawai_api($nip){
        
        $this->db->select("pegawai.*",false);
        $this->db->from('pegawai');
        $this->db->where('pegawai.nip',$nip);
        
        $query=$this->db->get();
        
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_users_api($id){
        
        $this->db->select("users.*",false);
        $this->db->from('users');
        $this->db->where('users.id',$id);
        
        $query=$this->db->get();
        
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    
    public function get_perspective($kd_perusahaan,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('perspective_result.kd_pr,
                            perspective_result.kd_perspective,
                            round(perspective_result.point_result,2) as gross_point,
                            perspective_result.weightage,
                            round(perspective_result.score,2) point_perspective');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $this->db->where('perspective_result.bulan', $bulan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('perspective_result.kd_perspective,
                            round(avg(perspective_result.point_result),2) as gross_point,
                            round(avg(perspective_result.score),2) point_perspective');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $this->db->group_by('perspective_result.kd_perspective');
        $where_clause2 = $this->db->get_compiled_select();

        $this->db->select("perspective.kd_perspective,
			perspective.kd_ps,
                        perspective.kd_perusahaan,
			perspective.nm_perspective,
			ifnull(point_bulan.weightage,0) as weightage,
			ifnull(point_bulan.gross_point,0) as gross_point_bulan,
			ifnull(point_bulan.point_perspective,0) as point_bulan,
			ifnull(point_tahun.gross_point,0) as gross_point_tahun,
			ifnull(point_tahun.point_perspective,0) as point_tahun",false);
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') point_bulan','perspective.kd_perspective = point_bulan.kd_perspective','LEFT');
        $this->db->join('('.$where_clause2.') point_tahun','perspective.kd_perspective = point_tahun.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_point_perusahaan($kd_perusahaan,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('perspective_result.kd_pr,
                            perspective_result.kd_perspective,
                            case
                                    when (perspective_result.score*4) > 4 then 4
                                    else round(perspective_result.score*4,2)
                            end point_perspective');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $this->db->where('perspective_result.bulan', $bulan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('perspective_result.kd_perspective,
                            case
                                    when (avg(perspective_result.score)*4) > 4 then 4
                                    else round(avg(perspective_result.score)*4,2)
                            end point_perspective');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $this->db->group_by('perspective_result.kd_perspective');
        $where_clause2 = $this->db->get_compiled_select();

        $this->db->select("perspective.kd_perspective,
			perspective.kd_ps,
                        perspective.kd_perusahaan,
			perspective.nm_perspective,
			ifnull(point_bulan.point_perspective,0) as point_bulan,
			ifnull(point_tahun.point_perspective,0) as point_tahun",false);
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') point_bulan','perspective.kd_perspective = point_bulan.kd_perspective','LEFT');
        $this->db->join('('.$where_clause2.') point_tahun','perspective.kd_perspective = point_tahun.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $where_clause3 = $this->db->get_compiled_select();
        
        $this->db->select("perusahaan.kd_perusahaan,
			perusahaan.nm_perusahaan,
			ifnull(round(sum(tbl_point.point_bulan),2),0) as point_bulan,
			ifnull(round(sum(tbl_point.point_tahun),2),0) as point_tahun",false);
        $this->db->from('perusahaan');
        $this->db->join('('.$where_clause3.') tbl_point','perusahaan.kd_perusahaan = tbl_point.kd_perusahaan','LEFT');
        $this->db->where('perusahaan.kd_perusahaan',$kd_perusahaan);
        $this->db->group_by('perusahaan.kd_perusahaan,
			perusahaan.nm_perusahaan');
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_point_perspective_detail($kd_perspective,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('perspective_result.kd_pr,
                            perspective_result.kd_perspective,
                            round(perspective_result.point_result,2) as gross_point,
                            perspective_result.weightage,
                            perspective_result.bulan,
                            perspective_result.tahun,
                            round(perspective_result.score,2) as point_perspective');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $where_clause = $this->db->get_compiled_select();
        

        $this->db->select("perspective.kd_perspective,
			perspective.kd_ps,
                        perspective.kd_perusahaan,
			perspective.nm_perspective,
                        point_bulan.bulan,
                        point_bulan.tahun,
			ifnull(point_bulan.gross_point,0) as gross_point_bulan,
			ifnull(point_bulan.weightage,0) as weightage,
			ifnull(point_bulan.point_perspective,0) as point_bulan",false);
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') point_bulan','perspective.kd_perspective = point_bulan.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perspective',$kd_perspective);
        $this->db->order_by('perspective.kd_perspective');
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_point_perusahaan_detail($kd_perusahaan,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('perspective.kd_perspective, 
				perspective.kd_ps, 
				perspective.kd_perusahaan, 
				perspective.nm_perspective,
				perspective_result.kd_pr, 
				perspective_result.bulan,
				perspective_result.tahun,
				round(perspective_result.score,2) as point_perspective');
        $this->db->from('perspective');
        $this->db->join('perspective_result','perspective.kd_perspective = perspective_result.kd_perspective','LEFT');
        $this->db->where('perspective_result.tahun', $tahun);
        $where_clause = $this->db->get_compiled_select();

        
        $this->db->select("perusahaan.kd_perusahaan,
			perusahaan.nm_perusahaan,
			tbl_point.bulan,
			tbl_point.tahun,
			ifnull(round(sum(tbl_point.point_perspective),2),0) as point_bulan",false);
        $this->db->from('perusahaan');
        $this->db->join('('.$where_clause.') tbl_point','perusahaan.kd_perusahaan = tbl_point.kd_perusahaan','LEFT');
        $this->db->where('perusahaan.kd_perusahaan',$kd_perusahaan);
        $this->db->group_by('perusahaan.kd_perusahaan,
			perusahaan.nm_perusahaan,
			tbl_point.bulan,
			tbl_point.tahun');
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
}
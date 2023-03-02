<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_peg_model extends CI_Model
{
    public function get_profil_pegawai_dashboard($nip,$tahun,$bulan){
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
    
    public function get_peg_kpi_perbulan($nip,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        
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
        $this->db->where("appraisal.tahun",$tahun);
        $this->db->where("appraisal.bulan",$bulan);
        $this->db->where('appraisal.nip', $nip);
       
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_peg_kpi_pertahun($nip,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select("appraisal.nip,
                            appraisal.bulan,
                            appraisal.tahun,
                            pegawai.nama,
                            pg.nama as nm_atasan,
                            departemen.nm_departemen,
                            jabatan.nm_jabatan,
                            appraisal.point");
        $this->db->from('appraisal');
        $this->db->join('pegawai','pegawai.nip=appraisal.nip','LEFT');
        $this->db->join('pegawai pg','pg.nip=appraisal.nip_atasan','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=appraisal.kd_departemen','LEFT');
        $this->db->join('jabatan','jabatan.kd_jabatan=appraisal.kd_jabatan','LEFT');
        $this->db->where("appraisal.tahun ",$tahun);
        $this->db->where('appraisal.nip', $nip);
        $this->db->order_by("appraisal.tahun DESC,appraisal.bulan DESC");
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_peg_kpi_rekap_setahun($nip,$tahun,$bulan){
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
    public function get_peg_kpi_rekap_setahun_linechart($nip,$tahun,$bulan){
     
        
        $query = $this->get_peg_kpi_rekap_setahun($nip,$tahun,$bulan);
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut = 0;
        $temp_nip="";
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
            $Data['legend'][$row->nip]= $row->nama;
            $Data['color'][$row->nip]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->nip]["code"] =$row->nip;
            $Data['data_grafik'][$row->nip]["nama"] =$row->nama;
            $Data['data_grafik'][$row->nip]["score"][$row->tahun.$bulan] =$row->score_point;
        }
        return $Data;
    }
    public function get_peg_kpi_rekap_pertahun($nip,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $thnAwal=$tahun-10;
        $thnAkhir=$tahun;
        
        $this->db->select('appraisal.nip,
                            pegawai.nama,
                            appraisal.tahun,
                            avg(appraisal.point) as score_point');
        $this->db->from('appraisal');
        $this->db->join('pegawai','appraisal.nip=pegawai.nip','left');
        $this->db->where("appraisal.tahun between '$thnAwal' and '$thnAkhir'",NULL);
        $this->db->where('appraisal.nip', $nip);
        $this->db->group_by("appraisal.nip,
                            pegawai.nama,
                            appraisal.tahun");
       
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_peg_kpi_rekap_pertahun_linechart($nip,$tahun){
     
        
        $query = $this->get_peg_kpi_rekap_pertahun($nip,$tahun);
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut = 0;
        $temp_nip="";
        foreach($query->result() as $row){
            if($temp_nip!=$row->nip){
                $temp_nip=$row->nip;
                $NoUrut++;
            }
            $Data['bulan'][$row->tahun]= substr($row->tahun,2);
            $Data['legend'][$row->nip]= $row->nama;
            $Data['color'][$row->nip]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->nip]["code"] =$row->nip;
            $Data['data_grafik'][$row->nip]["nama"] =$row->nama;
            $Data['data_grafik'][$row->nip]["score"][$row->tahun] =$row->score_point;
        }
        return $Data;
    }
    public function get_dept_radar_chart_perbulan($kd_perusahaan,$tahun,$bulan){
     
        
        $query = $this->get_dept_kpi_perbulan($kd_perusahaan, $tahun, $bulan);
//        echo $this->db->last_query();
//        die();
        $Data["Label"]='';
        $Data["Value"]='';
        //$Data["Color"]='';
        foreach($query->result() as $row){
            $Data["Label"] .="'".$row->nm_departemen."',";
            $Data["Value"] .=$row->kpi_dept.",";
//            $Data["Color"] .="'".$this->rand_color()."',";
        }
        return $Data;
    }
    public function get_dept_kpi_rekap_setahun($kd_perusahaan,$tahun,$kd_departemen=NULL){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($kd_departemen!="" and $kd_departemen!=NULL){
            $this->db->where('departemen_result.kd_departemen', $kd_departemen);
        }
        $this->db->select('departemen_result.kd_departemen,
                            departemen.nm_departemen,
                            departemen_result.bulan,
                            departemen_result.tahun,
                            sum(departemen_result.score_kpi) kpi_dept');
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->where('departemen_result.tahun', $tahun);
        $this->db->where('departemen.kd_perusahaan', $kd_perusahaan);
        $this->db->group_by('departemen_result.bulan,
			departemen_result.tahun,
 			departemen_result.kd_departemen,
			departemen.nm_departemen');
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    
    public function get_dept_kpi_detail_perbulan($kd_perusahaan,$tahun,$bulan,$kd_departemen=NULL){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $this->db->select('departemen_result.kd_departemen,
				sum(departemen_result.score_kpi) kpi_dept');
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->where('departemen_result.tahun', $tahun);
        $this->db->where('departemen_result.bulan', $bulan);
        $this->db->where('departemen.kd_perusahaan', $kd_perusahaan);
        if($kd_departemen!="" and $kd_departemen!=NULL){
            $this->db->where('departemen_result.kd_departemen', $kd_departemen);
        }
        $this->db->group_by('departemen_result.kd_departemen');
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('departemen_result.kd_dr,
                        departemen_result.bulan,
                        departemen_result.tahun,
                        departemen_result.kd_departemen,
                        departemen_result.kd_measurement,
                        round(departemen_result.weightage_bd,2)weightage_bd,
                        round(departemen_result.weightage_kpi,2)weightage_kpi,
                        departemen_result.target,
                        round(departemen_result.score_bd,2)score_bd,
                        round(departemen_result.score_kpi,2)score_kpi,
                        departemen_result.actual,
                        round(departemen_result.result,2)result,
                        round(departemen_result.resultvsbobot,2)resultvsbobot,
                        round(departemen_result.point_result,2)point_result,
                        round(departemen_result.point_result,2)gross_result,
                        departemen_result.type,
                        departemen_result.unit,
                        departemen_result.period,
			departemen.nm_departemen,
			measurement.nm_measurement,
			tbl_kpi.kpi_dept');
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->join('measurement','departemen_result.kd_measurement = measurement.kd_measurement','LEFT');
        $this->db->join('('.$where_clause.')tbl_kpi','departemen_result.kd_departemen = tbl_kpi.kd_departemen','LEFT');
        $this->db->where('departemen_result.tahun', $tahun);
        $this->db->where('departemen_result.bulan', $bulan);
        $this->db->where('departemen.kd_perusahaan', $kd_perusahaan);
        if($kd_departemen!="" and $kd_departemen!=NULL){
            $this->db->where('departemen_result.kd_departemen', $kd_departemen);
        }
        $this->db->order_by('departemen_result.kd_departemen');
       // $this->searching->SetSerching($DataSearch);
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_dept_kpi_perbulan_perdept($kd_departemen,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $this->db->select('departemen_result.*,
                            departemen.nm_departemen');
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen_result.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->where('departemen_result.tahun', $tahun);
        $this->db->where('departemen_result.bulan', $bulan);
        $this->db->where('departemen_result.kd_departemen', $kd_departemen);
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    
    public function get_pegawai_kpi_dept_perbulan($kd_departemen,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        
        $this->db->select('appraisal.kd_appraisal,
			appraisal.bulan,
			appraisal.tahun,
			appraisal.nip,
			pegawai.nama,
			appraisal.kd_departemen,
			departemen.nm_departemen,
			appraisal.kd_jabatan,
			jabatan.nm_jabatan,
			appraisal.`status`,
			appraisal.point,
			appraisal_detail.kd_measurement,
			measurement.nm_measurement,
			round(appraisal_detail.weightage_bd,2)weightage_bd,
			round(appraisal_detail.weightage_kpi,2)weightage_kpi,
			round(appraisal_detail.weightage_bd_dept,2)weightage_bd_dept,
			appraisal_detail.target,
			round(appraisal_detail.score_bd,2)score_bd,
			round(appraisal_detail.score_kpi,2)score_kpi,
			appraisal_detail.actual,
			round(appraisal_detail.result,2)result,
			round(appraisal_detail.point_result,2)point_result,
			round(appraisal_detail.point_result,2)gross_result,
			appraisal_detail.`type`,
			appraisal_detail.unit,
			appraisal_detail.period,
			case
				when round((appraisal_detail.result*appraisal_detail.weightage_bd*4),2)>4 then 4
				else round((appraisal_detail.result*appraisal_detail.weightage_bd*4),2)
			end as score_result');
        $this->db->from('appraisal');
        $this->db->join('appraisal_detail','appraisal.kd_appraisal = appraisal_detail.kd_appraisal','LEFT');
        $this->db->join('pegawai','appraisal.nip = pegawai.nip','LEFT');
        $this->db->join('departemen','appraisal.kd_departemen = departemen.kd_departemen','LEFT');
        $this->db->join('jabatan','appraisal.kd_jabatan = jabatan.kd_jabatan','LEFT');
        $this->db->join('measurement','appraisal_detail.kd_measurement = measurement.kd_measurement','LEFT');
        $this->db->where('appraisal.tahun', $tahun);
        $this->db->where('appraisal.bulan', $bulan);
        $this->db->where('appraisal.kd_departemen', $kd_departemen);
        $this->db->order_by('pegawai.nama');
       // $this->searching->SetSerching($DataSearch);
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    
    protected function list_warna($no){
        $list_warna[1]="#00c5dc";//accent
        $list_warna[2]="#ffb822";//warning
        $list_warna[3]="#f4516c";//danger
        $list_warna[4]="#5867dd";//primary
        $list_warna[5]="#34bfa3";//success
        $list_warna[6]="#36a3f7";//info
        if(isset($list_warna[$no])){
            return $list_warna[$no];
        }else{
            return $this->rand_color();
        }
        
    }
    function rand_color() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
    
}

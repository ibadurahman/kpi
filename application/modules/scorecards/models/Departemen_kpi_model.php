<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Departemen_kpi_model extends CI_Model
{
    public function get_measurement_remaining_bobot($kd_perusahaan,$tahun="",$remaining_only=false){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('departemen_kpi.kd_measurement,ifnull(sum(departemen_kpi.weightage_bd),0) as weightage_bd');
        $this->db->from('departemen_kpi');
        $this->db->where('departemen_kpi.tahun', $tahun);
        $this->db->group_by('departemen_kpi.kd_measurement');
        $where_clause = $this->db->get_compiled_select();
        
        
        $this->db->select("measurement.*,business_driver.nm_bd,ifnull(tbl_kpi.weightage_bd,0)weightage_bd, (100 - ifnull(tbl_kpi.weightage_bd,0)) as remaining_pesen ");
        $this->db->from('measurement');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('perspective','perspective.kd_perspective=business_driver.kd_perspective','LEFT');
        $this->db->join('('.$where_clause.') tbl_kpi','measurement.kd_measurement = tbl_kpi.kd_measurement','LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->order_by('measurement.kd_bd,measurement.kd_measurement');
        
        if($remaining_only==TRUE)
        {
            $this->db->where('(100 - ifnull(tbl_kpi.weightage_bd,0)) >','0');
            
        }
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_measurement_remaining_bobot2($kd_perusahaan,$kd_departemen,$tahun=""){
        if($tahun==""){
            $tahun=date("Y");
        }
        $sql = "select tbl_remaining_persen.kd_measurement,
			measurement.kd_ms,
			measurement.nm_measurement,
			measurement.kd_bd,
			measurement.`type`,
			measurement.unit,
			measurement.period,
			business_driver.nm_bd,
			tbl_remaining_persen.remaining_pesen
                from(
                select tbl_persen.kd_measurement, sum(tbl_persen.remaining_pesen) as remaining_pesen
                from(
                        SELECT `measurement`.kd_measurement, ifnull(tbl_kpi.weightage_bd, 0)weightage_bd, (100 - ifnull(tbl_kpi.weightage_bd, 0)) as remaining_pesen 
                        FROM `measurement` 
                        LEFT JOIN `business_driver` ON `business_driver`.`kd_bd`=`measurement`.`kd_bd` 
                        LEFT JOIN `perspective` ON `perspective`.`kd_perspective`=`business_driver`.`kd_perspective` 
                        LEFT JOIN (SELECT `departemen_kpi`.`kd_measurement`, ifnull(sum(departemen_kpi.weightage_bd), 0) as weightage_bd FROM `departemen_kpi` WHERE `departemen_kpi`.`tahun` = ? GROUP BY `departemen_kpi`.`kd_measurement`) tbl_kpi ON `measurement`.`kd_measurement` = `tbl_kpi`.`kd_measurement`
                         WHERE `perspective`.`kd_perusahaan` = ? AND (100 - ifnull(tbl_kpi.weightage_bd,0)) > '0' 
                         union all
                        SELECT departemen_kpi.kd_measurement,
                                                departemen_kpi.weightage_bd,
                                                departemen_kpi.weightage_bd as weightage_use
                        FROM `departemen_kpi` 
                        LEFT JOIN `measurement` ON `departemen_kpi`.`kd_measurement`=`measurement`.`kd_measurement` 
                        WHERE `departemen_kpi`.`kd_departemen` = ? AND `departemen_kpi`.`tahun` = ?
                ) as tbl_persen
                group by tbl_persen.kd_measurement
                ) as tbl_remaining_persen
                LEFT JOIN `measurement` ON  tbl_remaining_persen.kd_measurement = measurement.kd_measurement
                LEFT JOIN `business_driver` ON `business_driver`.`kd_bd`=`measurement`.`kd_bd` 
                LEFT JOIN `perspective` ON `perspective`.`kd_perspective`=`business_driver`.`kd_perspective`
                order by measurement.kd_bd,measurement.kd_measurement ";
        $bind=[$tahun,$kd_perusahaan,$kd_departemen,$tahun];
        $query=$this->db->query($sql,$bind);
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_measurement_search_multi($kd_measurement,$tahun=""){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('departemen_kpi.kd_measurement,ifnull(sum(departemen_kpi.weightage_bd),0) as weightage_bd');
        $this->db->from('departemen_kpi');
        $this->db->where('departemen_kpi.tahun', $tahun);
        $this->db->group_by('departemen_kpi.kd_measurement');
        $where_clause = $this->db->get_compiled_select();
        
        
        $this->db->select("measurement.*,business_driver.nm_bd,ifnull(tbl_kpi.weightage_bd,0)weightage_bd, (100 - ifnull(tbl_kpi.weightage_bd,0)) as remaining_pesen ");
        $this->db->from('measurement');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('perspective','perspective.kd_perspective=business_driver.kd_perspective','LEFT');
        $this->db->join('('.$where_clause.') tbl_kpi','measurement.kd_measurement = tbl_kpi.kd_measurement','LEFT');
        $this->db->where_in('measurement.kd_measurement', $kd_measurement);
        $this->db->order_by('measurement.kd_bd,measurement.kd_measurement');
        
        
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_measurement_search_multi2($kd_measurement,$tahun=""){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select("measurement.*,business_driver.nm_bd");
        $this->db->from('measurement');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('perspective','perspective.kd_perspective=business_driver.kd_perspective','LEFT');
        $this->db->where_in('measurement.kd_measurement', $kd_measurement);
        $this->db->order_by('measurement.kd_bd,measurement.kd_measurement');
        
        
        $query=$this->db->get();
    //    echo $this->db->last_query();
    //    die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
        
//        $this->db->select('departemen_kpi.kd_measurement,ifnull(sum(departemen_kpi.weightage_bd),0) as weightage_bd');
//        $this->db->from('departemen_kpi');
//        $this->db->where('departemen_kpi.tahun', $tahun);
//        $this->db->group_by('departemen_kpi.kd_measurement');
//        $where_clause = $this->db->get_compiled_select();
//        
//        
//        $this->db->select("measurement.*,business_driver.nm_bd,ifnull(tbl_kpi.weightage_bd,0)weightage_bd, (100 - ifnull(tbl_kpi.weightage_bd,0)) as remaining_pesen ");
//        $this->db->from('measurement');
//        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
//        $this->db->join('perspective','perspective.kd_perspective=business_driver.kd_perspective','LEFT');
//        $this->db->join('('.$where_clause.') tbl_kpi','measurement.kd_measurement = tbl_kpi.kd_measurement','LEFT');
//        $this->db->where_in('measurement.kd_measurement', $kd_measurement);
//        $this->db->order_by('measurement.kd_bd,measurement.kd_measurement');
        
        
//        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_departemen_kpi_by_kd_departemen($kd_departemen,$tahun=''){
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
        $this->db->order_by('measurement.kd_bd,measurement.kd_measurement');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_departemen_kpi_by_code_perusahaan($kd_bds,$kd_perusahaan){
        
        $this->db->select("departemen_kpi.*,perspective.nm_perspective");
        $this->db->from('departemen_kpi');
        $this->db->join('perspective','perspective.kd_perspective=departemen_kpi.kd_perspective','LEFT');
        $this->db->where('departemen_kpi.kd_bds',$kd_bds);
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function insert_departemen_kpi($data){
       $this->db->insert('departemen_kpi',$data);
       return $this->db->insert_id();
    }
    
    public function update_departemen_kpi($kd_bd,$data){
        $this->db->where('kd_bd',$kd_bd);
        $this->db->update('departemen_kpi',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Departemen_kpi');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function delete_departemen_kpi($kd_dk){
       $this->db->where('kd_dk',$kd_dk);
       $this->db->delete('departemen_kpi');
    }
    public function delete_departemen_kpi_kd_departemen($kd_departemen,$tahun){
       $this->db->where('kd_departemen',$kd_departemen);
       $this->db->where('tahun',$tahun);
       $this->db->delete('departemen_kpi');
    }
    public function delete_departemen_kpi_kd_measurement($kd_measurement,$tahun){
       $this->db->where('kd_measurement',$kd_measurement);
       $this->db->where('tahun',$tahun);
       $this->db->delete('departemen_kpi');
    }
    public function get_departemen_all_departemen_kpi($kd_perusahaan){
        $this->db->where('departemen.kd_perusahaan',$kd_perusahaan);
        return $this->db->get('departemen');
    }
    public function get_departemen_code_departemen_kpi($kd_departemen){
        $this->db->where('departemen.kd_departemen',$kd_departemen);
        return $this->db->get('departemen');
    }
    public function insert_copy_bobot_departemen_kpi($kd_departemen,$thn_berjalan,$thn_lalu,$user,$tgl_input){
        $sql="INSERT INTO `departemen_kpi` (`kd_dk`, `kd_measurement`,kd_departemen, `weightage_bd`, `weightage_bd_persen`, `weightage_kpi`, `weightage_kpi_persen`, `tahun`, `status`, `user_input`, `tgl_input`) 
                select concat(?,departemen_kpi.kd_departemen,departemen_kpi.kd_measurement) as kode,
                                        departemen_kpi.kd_measurement,
                                        departemen_kpi.kd_departemen,
                                        departemen_kpi.weightage_bd,
                                        departemen_kpi.weightage_bd_persen,
                                        departemen_kpi.weightage_kpi,
                                        departemen_kpi.weightage_kpi_persen,
                                        ? as tahun,
                                        '1' as `status`,
                                        ? as user_input,
                                        ? as tgl_input
                from departemen_kpi
                where departemen_kpi.tahun = ? and departemen_kpi.kd_departemen = ?";
        $bind=[$thn_berjalan,$thn_berjalan,$user,$tgl_input,$thn_lalu,$kd_departemen];
       // $this->searching->SetSerching($DataSearch);
        return $this->db->query($sql,$bind);
    }
    public function get_departemen_kpi_by_kd_measurement($kd_measurement,$tahun=''){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('departemen_kpi.kd_measurement, sum(departemen_kpi.weightage_bd) as Tot_bobot_bd');
        $this->db->from('departemen_kpi');
        $this->db->where('departemen_kpi.tahun', $tahun);
        $this->db->group_by('departemen_kpi.kd_measurement');
        $where_clause = $this->db->get_compiled_select();
        
        
        $this->db->select("departemen_kpi.*,
                            departemen.nm_departemen,
                            measurement.nm_measurement,
                            measurement.kd_ms,
                            business_driver.kd_bd, 
                            business_driver.nm_bd,
                            dkpitb.Tot_bobot_bd");
        $this->db->from('departemen_kpi');
        $this->db->join('measurement','departemen_kpi.kd_measurement=measurement.kd_measurement','LEFT');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('departemen','departemen.kd_departemen=departemen_kpi.kd_departemen','LEFT');
        $this->db->join('('.$where_clause.') as dkpitb','dkpitb.kd_measurement=measurement.kd_measurement','LEFT');
        $this->db->where('departemen_kpi.kd_measurement',$kd_measurement);
        $this->db->where('departemen_kpi.tahun', $tahun);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_departemen_result_kd_departemen_monthly($kd_departemen,$bulan,$tahun){
     
        
        $this->db->select("departemen_result.kd_departemen,
                            round((departemen_result.score_kpi),2) score_kpi_point",FALSE);
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen.kd_departemen = departemen_result.kd_departemen');
        $this->db->where('departemen_result.bulan',$bulan);
        $this->db->where('departemen_result.tahun',$tahun);
        $this->db->where('departemen_result.kd_departemen',$kd_departemen);
        $query = $this->db->get();
        
        return $query;
    }
    public function get_departemen_result_kd_departemen_yearly($kd_departemen,$tahun){
     
        
        $this->db->select("departemen_result.kd_departemen,departemen_result.tahun,
                            round(avg(departemen_result.score_kpi),2) score_kpi_point",FALSE);
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen.kd_departemen = departemen_result.kd_departemen');
        $this->db->where('departemen_result.tahun',$tahun);
        $this->db->where('departemen_result.kd_departemen',$kd_departemen);
        $this->db->group_by("departemen_result.kd_departemen,departemen_result.tahun");
        $query = $this->db->get();
        
        return $query;
    }
    public function get_departemen_result_history_kd_departemen($kd_departemen,$bulan,$tahun){
     
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        
        $this->db->select("departemen_result.kd_departemen,
                            departemen.nm_departemen,
                            departemen_result.tahun,
                            departemen_result.bulan,
                            (departemen_result.score_kpi)score_kpi_point",FALSE);
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen.kd_departemen = departemen_result.kd_departemen');
        $this->db->where('departemen_result.kd_departemen',$kd_departemen);
        $this->db->where("concat(departemen_result.tahun,if(departemen_result.bulan<10,concat('0',departemen_result.bulan),departemen_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        
        $this->db->order_by("departemen_result.tahun DESC, departemen_result.bulan DESC");

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_departemen_result_history_kd_departemen_yearly($kd_departemen,$tahun){
     
        $thnAwal=$tahun-10;
        $PeriodeAkhir=$tahun;
        $PeriodeAwal=$thnAwal;
        
        $this->db->select("departemen_result.kd_departemen,
                            departemen.nm_departemen,
                            departemen_result.tahun,
                            round(avg(departemen_result.score_kpi),2)score_kpi_point",FALSE);
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen.kd_departemen = departemen_result.kd_departemen');
        $this->db->where('departemen_result.kd_departemen',$kd_departemen);
        $this->db->where("departemen_result.tahun between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $this->db->group_by("departemen_result.kd_departemen,
                            departemen.nm_departemen,
                            departemen_result.tahun");
        $this->db->order_by("departemen_result.tahun DESC");

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_departemen_result_chart_monthly_kd_departemen($kd_departemen,$bulan,$tahun){
     
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        
        $this->db->select("departemen_result.kd_departemen,
                            departemen.nm_departemen,
                            departemen_result.tahun,
                            departemen_result.bulan,
                            (departemen_result.score_kpi)score_kpi_point",FALSE);
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen.kd_departemen = departemen_result.kd_departemen');
        $this->db->where('departemen_result.kd_departemen',$kd_departemen);
        $this->db->where("concat(departemen_result.tahun,if(departemen_result.bulan<10,concat('0',departemen_result.bulan),departemen_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $this->db->order_by("departemen_result.kd_departemen,departemen_result.tahun ASC, departemen_result.bulan ASC");

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut=0;
        $temp_dept="";
        foreach($query->result() as $row){
            if($temp_dept!=$row->kd_departemen){
                $temp_dept=$row->kd_departemen;
                $NoUrut++;
            }
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
            $Data['bulan'][$row->tahun.$bulan]= getNamaBulanMin($row->bulan)." ".substr($row->tahun,2);
            $Data['legend'][$row->kd_departemen]= $row->nm_departemen;
            $Data['color'][$row->kd_departemen]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_departemen]["code"] =$row->kd_departemen;
            $Data['data_grafik'][$row->kd_departemen]["nama"] =$row->nm_departemen;
            $Data['data_grafik'][$row->kd_departemen]["score"][$row->tahun.$row->bulan] =$row->score_kpi_point;
        }
        return $Data;
    }
    public function get_departemen_result_chart_yearly_kd_departemen($kd_departemen,$tahun){
     
        $thnAwal=$tahun-10;
        $PeriodeAkhir=$tahun;
        $PeriodeAwal=$thnAwal;
        
        $this->db->select("departemen_result.kd_departemen,
                            departemen.nm_departemen,
                            departemen_result.tahun,
                            round(avg(departemen_result.score_kpi),2)score_kpi_point",FALSE);
        $this->db->from('departemen_result');
        $this->db->join('departemen','departemen.kd_departemen = departemen_result.kd_departemen');
        $this->db->where('departemen_result.kd_departemen',$kd_departemen);
        $this->db->where("departemen_result.tahun between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $this->db->group_by("departemen_result.kd_departemen,
                            departemen.nm_departemen,
                            departemen_result.tahun");
        $this->db->order_by("departemen_result.kd_departemen,departemen_result.tahun ASC");

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut=0;
        $temp_dept="";
        foreach($query->result() as $row){
            if($temp_dept!=$row->kd_departemen){
                $temp_dept=$row->kd_departemen;
                $NoUrut++;
            }
            $Data['bulan'][$row->tahun]=substr($row->tahun,2);
            $Data['legend'][$row->kd_departemen]= $row->nm_departemen;
            $Data['color'][$row->kd_departemen]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_departemen]["code"] =$row->kd_departemen;
            $Data['data_grafik'][$row->kd_departemen]["nama"] =$row->nm_departemen;
            $Data['data_grafik'][$row->kd_departemen]["score"][$row->tahun] =$row->score_kpi_point;
        }
        return $Data;
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

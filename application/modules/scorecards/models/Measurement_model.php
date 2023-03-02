<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Measurement_model extends CI_Model
{
    
    public function get_measurement_all($kd_perusahaan,$tahun="",$Limit=NULL,$Offset=NULL){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select("measurement.*,
                            business_driver.nm_bd,
                            perspective.nm_perspective,
                            ifnull(round((mb.weightage/total_bobot.total_weightage)*100,2),0)weightage,
                            ifnull(round((total_bobot.total_weightage/total_bobot.total_weightage)*100,2),0)total_persen");
        $this->db->from('measurement');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('perspective','perspective.kd_perspective=business_driver.kd_perspective','LEFT');
        $this->db->join('(select * from measurement_bobot where tahun = '.$tahun.') as mb','mb.kd_measurement=measurement.kd_measurement','LEFT');
        $this->db->join('(select measurement.kd_bd, sum(measurement_bobot.weightage) as total_weightage
                        from measurement_bobot
                        INNER JOIN measurement ON measurement_bobot.kd_measurement = measurement.kd_measurement
                        where measurement_bobot.tahun = '.$tahun.'
                        group by measurement.kd_bd) as total_bobot','total_bobot.kd_bd=business_driver.kd_bd','LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->order_by('measurement.kd_bd, measurement.kd_measurement');
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_measurement_all_perusahaan($kd_perusahaan,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("measurement.*,perusahaan.nm_perusahaan, level.nm_level");
        $this->db->from('measurement');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=measurement.kd_perusahaan','LEFT');
        $this->db->join('level','measurement.kd_level=level.kd_level','LEFT');
        $this->db->where('measurement.kd_perusahaan',$kd_perusahaan);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_measurement_by_code($kd_measurement,$tahun=''){
        if($tahun==""){
            $tahun=date("Y");
        }
         $this->db->select('measurement.kd_bd, sum(measurement_bobot.weightage) as total_weightage');
        $this->db->from('measurement_bobot');
        $this->db->join('measurement','measurement_bobot.kd_measurement = measurement.kd_measurement','LEFT');
        $this->db->where('measurement_bobot.tahun', $tahun);
        $this->db->group_by('measurement.kd_bd');
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('departemen_kpi.kd_measurement, count(departemen_kpi.kd_dk) as total_data');
        $this->db->from('departemen_kpi');
        $this->db->group_by('departemen_kpi.kd_measurement');
        $where_clause2 = $this->db->get_compiled_select();
        
        $this->db->select("measurement.*,
                            ifnull(tbl_ms_used.total_data,0)total_data,
                            business_driver.nm_bd,
                            perspective.nm_perspective,
                            ifnull(round((mb.weightage/msbt.total_weightage)*100,2),0)weightage,
                            ifnull(round((msbt.total_weightage/msbt.total_weightage)*100,2),0)total_persen");
        $this->db->from('measurement');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('perspective','perspective.kd_perspective=business_driver.kd_perspective','LEFT');
        $this->db->join('(select * from measurement_bobot where tahun = '.$tahun.') as mb','mb.kd_measurement=measurement.kd_measurement','LEFT');
        $this->db->join('('.$where_clause.') as msbt','msbt.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('('.$where_clause2.') as tbl_ms_used','tbl_ms_used.kd_measurement=measurement.kd_measurement','LEFT');
        $this->db->where('measurement.kd_measurement',$kd_measurement);
        $this->db->order_by('business_driver.kd_bd, measurement.kd_measurement');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    
    public function get_measurement_all_by_code_perusahaan($kd_ms,$kd_perusahaan){
       
        $this->db->select("measurement.*,business_driver.nm_bd,perspective.nm_perspective");
        $this->db->from('measurement');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('perspective','perspective.kd_perspective=business_driver.kd_perspective','LEFT');
        $this->db->where('measurement.kd_ms',$kd_ms);
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->order_by('measurement.kd_bd, measurement.kd_measurement');
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_measurement_all_by_business_driver($kd_bd,$tahun=""){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select("measurement.*,
                            business_driver.kd_bds,
                            business_driver.nm_bd,
                            perspective.nm_perspective,
                            ifnull(mb.weightage,0)weightage,
                            ifnull(round((mb.weightage/total_bobot.total_weightage)*100,2),0)bobot,
                            ifnull(round((total_bobot.total_weightage/total_bobot.total_weightage)*100,2),0)tot_bobot");
        $this->db->from('measurement');
        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
        $this->db->join('perspective','perspective.kd_perspective=business_driver.kd_perspective','LEFT');
        $this->db->join('(select * from measurement_bobot where tahun = '.$tahun.') as mb','mb.kd_measurement=measurement.kd_measurement','LEFT');
        $this->db->join('(select measurement.kd_bd, sum(measurement_bobot.weightage) as total_weightage
                        from measurement_bobot
                        INNER JOIN measurement ON measurement_bobot.kd_measurement = measurement.kd_measurement
                        where measurement_bobot.tahun = '.$tahun.'
                        group by measurement.kd_bd) as total_bobot','total_bobot.kd_bd=business_driver.kd_bd','LEFT');
        $this->db->where('business_driver.kd_bd',$kd_bd);
        $this->db->order_by('measurement.kd_bd, measurement.kd_measurement');
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_measurement_bobot_by_tahun($tahun){
        
        $this->db->select("measurement_bobot.*");
        $this->db->from('measurement_bobot');
        $this->db->where('measurement_bobot.tahun',$tahun);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_measurement_target_by_code($kd_measurement,$tahun=''){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select("measurement_target.*,measurement_target_d.bulan,ifnull(measurement_target_d.target,0) as target");
        $this->db->from('measurement_target');
        $this->db->join('measurement_target_d','measurement_target.kd_mt=measurement_target_d.kd_mt','LEFT');
        $this->db->where('measurement_target.kd_measurement',$kd_measurement);
        $this->db->where('measurement_target.tahun',$tahun);
        $this->db->order_by('measurement_target.kd_measurement, measurement_target_d.bulan');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_measurement_target_by_bulan_tahun($kd_measurement,$bulan='',$tahun=''){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $this->db->select("measurement_target.*,measurement_target_d.bulan,ifnull(measurement_target_d.target,0) as target");
        $this->db->from('measurement_target');
        $this->db->join('measurement_target_d','measurement_target.kd_mt=measurement_target_d.kd_mt','LEFT');
        $this->db->where('measurement_target.kd_measurement',$kd_measurement);
        $this->db->where('measurement_target.tahun',$tahun);
        $this->db->where('measurement_target.bulan',$bulan);
        $this->db->order_by('measurement_target.kd_measurement, measurement_target_d.bulan');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_measurement_target_by_code_mt($kd_mt){
        $this->db->select("measurement_target.*,measurement_target_d.bulan as bulan_target,ifnull(measurement_target_d.target,0) as target,measurement.nm_measurement,measurement.kd_ms");
        $this->db->from('measurement_target');
        $this->db->join('measurement_target_d','measurement_target.kd_mt=measurement_target_d.kd_mt','LEFT');
        $this->db->join('measurement','measurement_target.kd_measurement=measurement.kd_measurement','LEFT');
//        $this->db->join('business_driver','business_driver.kd_bd=measurement.kd_bd','LEFT');
//        $this->db->join('perspective','perspective.kd_perspective=business_driver.kd_perspective','LEFT');
        $this->db->where('measurement_target.kd_mt',$kd_mt);
        $this->db->order_by('measurement_target.kd_measurement, measurement_target_d.bulan');
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function insert_measurement($data){
       $this->db->insert('measurement',$data);
       return $this->db->insert_id();
    }
    
    public function insert_measurement_bobot($data){
       $this->db->insert('measurement_bobot',$data);
       return $this->db->insert_id();
    }
    public function insert_measurement_target($data){
       $this->db->insert('measurement_target',$data);
       return $this->db->insert_id();
    }
    public function insert_measurement_target_d_batch($data){
       $this->db->insert_batch('measurement_target_d',$data);
    }
    public function update_measurement($kd_measurement,$data){
        $this->db->where('kd_measurement',$kd_measurement);
        $this->db->update('measurement',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Measurement');
//        echo $sql."---".$kd_measurement;
//        die();
    }
    public function delete_measurement($kd_measurement){
       $this->db->where('kd_measurement',$kd_measurement);
       $this->db->delete('measurement');
    }
    public function delete_measurement_bobot($kd_bd,$tahun){
       $this->db->select('kd_measurement');
        $this->db->from('measurement');
        $this->db->where('measurement.kd_bd', $kd_bd);
        $where_clause = $this->db->get_compiled_select();

       $this->db->where('tahun',$tahun);
       $this->db->where('kd_measurement IN ('.$where_clause.')',NULL,FALSE);
       $this->db->delete('measurement_bobot');
    }
    public function delete_measurement_target($kd_mt){
       $this->db->where('kd_mt',$kd_mt);
       $this->db->delete('measurement_target');
    }
    public function delete_measurement_target_d_kd_mt($kd_mt){
       $this->db->where('kd_mt',$kd_mt);
       $this->db->delete('measurement_target_d');
    }
    public function get_measurement_bobot_list_tahun(){
        
        $sql="select distinct measurement_bobot.tahun from measurement_bobot";
       // $this->searching->SetSerching($DataSearch);
        return $this->db->query($sql);
    }
    public function get_business_driver_all_measurement($kd_perusahaan){
        $this->db->select('business_driver.*');
        $this->db->from('business_driver');
        $this->db->join('perspective','perspective.kd_perspective = business_driver.kd_perspective');
        $this->db->where('perspective.kd_perusahaan', $kd_perusahaan);
        return $this->db->get('');
    }
    public function insert_copy_measurement_bobot($kd_bd,$thn_berjalan,$thn_lalu,$user,$tgl_input){
        $sql="INSERT INTO `measurement_bobot` (`kd_mb`, `kd_measurement`, `weightage`, `weightage_persen`, `tahun`, `status`, `user_input`, `tgl_input`) 
                select concat(measurement_bobot.kd_measurement,?) as kode,
                                        measurement_bobot.kd_measurement,
                                        measurement_bobot.weightage,
                                        measurement_bobot.weightage_persen,
                                        ? as tahun,
                                        '1' as `status`,
                                        ? as user_input,
                                        ? as tgl_input
                from measurement_bobot
                INNER JOIN measurement ON measurement_bobot.kd_measurement = measurement.kd_measurement
                where measurement_bobot.tahun = ? and measurement.kd_bd = ?";
        $bind=[$thn_berjalan,$thn_berjalan,$user,$tgl_input,$thn_lalu,$kd_bd];
       // $this->searching->SetSerching($DataSearch);
        return $this->db->query($sql,$bind);
    }
    
    public function get_measurement_result_kd_measurement_monthly($kd_measurement,$bulan,$tahun){
     
        
        $this->db->select("measurement_result.kd_measurement,
                            ifnull(measurement_result.result,0)result, 
                            measurement_result.point_result",FALSE);
        $this->db->from('measurement_result');
        $this->db->join('measurement','measurement.kd_measurement = measurement_result.kd_measurement');
        $this->db->where('measurement_result.bulan',$bulan);
        $this->db->where('measurement_result.tahun',$tahun);
        $this->db->where('measurement_result.kd_measurement',$kd_measurement);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_measurement_result_kd_measurement_yearly($kd_measurement,$tahun){
     
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('measurement_result.kd_mr,
                            measurement_result.kd_measurement,
                            measurement_result.point_result');
        $this->db->from('measurement_result');
        $this->db->where('measurement_result.tahun', $tahun);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("measurement.kd_measurement,measurement.kd_ms,measurement.nm_measurement,ifnull(round(avg(tbl_ms.point_result),2),0)point_result");
        $this->db->from('measurement');
        $this->db->join('('.$where_clause.') tbl_ms','measurement.kd_measurement = tbl_ms.kd_measurement','LEFT');
        $this->db->where('measurement.kd_measurement',$kd_measurement);
        $this->db->group_by("measurement.kd_measurement,measurement.kd_ms,measurement.nm_measurement");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_measurement_result_history_kd_measurement($kd_measurement,$bulan,$tahun){
     
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        
        $this->db->select("measurement_result.kd_measurement,
                            measurement.kd_ms,
                            measurement.nm_measurement,
                            measurement_result.tahun,
                            measurement_result.bulan,
                            measurement_result.result,
                            ifnull(measurement_result.point_result,0)point_result",FALSE);
        $this->db->from('measurement_result');
        $this->db->join('measurement','measurement.kd_measurement = measurement_result.kd_measurement');
        $this->db->where('measurement_result.kd_measurement',$kd_measurement);
        $this->db->where("concat(measurement_result.tahun,if(measurement_result.bulan<10,concat('0',measurement_result.bulan),measurement_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $this->db->order_by("measurement_result.tahun DESC, measurement_result.bulan DESC");

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_measurement_result_history_kd_measurement_yearly($kd_measurement,$tahun){
     
        if($tahun==""){
            $tahun=date("Y");
        }
        $ThnAwal= $tahun - 10;
        $ThnAkhir= $tahun;
        $this->db->select('measurement.kd_measurement, 
				measurement.kd_ms, 
				measurement.nm_measurement,
				measurement_result.tahun,
                                round(avg(measurement_result.result),2) as result,
				round(avg(measurement_result.point_result),2) as point_result');
        $this->db->from('measurement');
        $this->db->join('measurement_result','measurement.kd_measurement = measurement_result.kd_measurement','LEFT');
        $this->db->where("measurement_result.tahun between '$ThnAwal' and '$ThnAkhir'", NULL);
        $this->db->where('measurement_result.kd_measurement', $kd_measurement);
        $this->db->group_by("measurement.kd_measurement, 
				measurement.kd_ms, 
				measurement.nm_measurement,
				measurement_result.tahun");
        $this->db->order_by("measurement_result.tahun DESC");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_measurement_result_chart_monthly_kd_measurement($kd_measurement,$bulan,$tahun){
     
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        
        $this->db->select("measurement_result.kd_measurement,
                            measurement.kd_ms,
                            measurement.nm_measurement,
                            measurement_result.tahun,
                            measurement_result.bulan,
                            ifnull(measurement_result.point_result,0)point_result",FALSE);
        $this->db->from('measurement_result');
        $this->db->join('measurement','measurement.kd_measurement = measurement_result.kd_measurement');
        $this->db->where('measurement.kd_measurement',$kd_measurement);
        $this->db->where("concat(measurement_result.tahun,if(measurement_result.bulan<10,concat('0',measurement_result.bulan),measurement_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $this->db->order_by("measurement_result.kd_measurement,measurement_result.tahun ASC, measurement_result.bulan ASC");

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut=0;
        $temp_ms="";
        foreach($query->result() as $row){
            if($temp_ms!=$row->kd_measurement){
                $temp_ms=$row->kd_measurement;
                $NoUrut++;
            }
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
            $Data['bulan'][$row->tahun.$bulan]= getNamaBulanMin($row->bulan)." ".substr($row->tahun,2);
            $Data['legend'][$row->kd_measurement]= $row->nm_measurement;
            $Data['color'][$row->kd_measurement]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_measurement]["code"] =$row->kd_ms;
            $Data['data_grafik'][$row->kd_measurement]["nama"] =$row->nm_measurement;
            $Data['data_grafik'][$row->kd_measurement]["score"][$row->tahun.$row->bulan] =$row->point_result;
        }
        return $Data;
    }
    public function get_measurement_result_chart_yearly_kd_measurement($kd_measurement,$tahun){
     
        if($tahun==""){
            $tahun=date("Y");
        }
        $ThnAwal= $tahun - 10;
        $ThnAkhir= $tahun;
        $this->db->select('measurement.kd_measurement, 
				measurement.kd_ms, 
				measurement.nm_measurement,
				measurement_result.tahun,
				round(avg(measurement_result.point_result),2) as point_result');
        $this->db->from('measurement');
        $this->db->join('measurement_result','measurement.kd_measurement = measurement_result.kd_measurement','LEFT');
        $this->db->where("measurement_result.tahun between '$ThnAwal' and '$ThnAkhir'", NULL);
        $this->db->where('measurement_result.kd_measurement', $kd_measurement);
        $this->db->group_by("measurement.kd_measurement, 
				measurement.kd_ms, 
				measurement.nm_measurement,
				measurement_result.tahun");
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut=0;
        $temp_ms="";
        foreach($query->result() as $row){
            if($temp_ms!=$row->kd_measurement){
                $temp_ms=$row->kd_measurement;
                $NoUrut++;
            }
            $Data['bulan'][$row->tahun]= substr($row->tahun,2);
            $Data['legend'][$row->kd_measurement]= $row->nm_measurement;
            $Data['color'][$row->kd_measurement]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_measurement]["code"] =$row->kd_measurement;
            $Data['data_grafik'][$row->kd_measurement]["nama"] =$row->nm_measurement;
            $Data['data_grafik'][$row->kd_measurement]["score"][$row->tahun] =$row->point_result;
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
    public function create_kd_mesurement(){
        $thn=date('y');
        $this->db->select("measurement.kd_ms");
        $this->db->from('measurement');
        $this->db->where('SUBSTRING(measurement.kd_ms,3,2)',$thn);
        $this->db->order_by('measurement.kd_ms DESC');
        $this->db->limit(1);
        $query = $this->db->get();
//         echo $this->db->last_query();
//        die();       
        $no_urut=1;
        $kode="";
        if($query->num_rows()>0){
            foreach($query->result() as $row){
                $kode=$row->kd_ms;
            }
            $nomor = substr($kode, 4);
            $no_urut=$nomor+1;
        }
        $kd_urut="";
        if(strlen($no_urut)==1){
            $kd_urut="00".$no_urut;
        }else if(strlen($no_urut)==2){
            $kd_urut="0".$no_urut;
        }else if(strlen($no_urut)>2){
            $kd_urut=$no_urut;
        }
        $kd_ms="MS".$thn.$kd_urut;
        return $kd_ms;
    }
}

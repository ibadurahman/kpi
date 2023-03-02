<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_driver_model extends CI_Model
{
    public function get_business_driver_all($kd_perusahaan,$tahun="",$Limit=NULL,$Offset=NULL){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select("business_driver.*,perspective.kd_ps,perspective.nm_perspective,ifnull(round((bdb.weightage/total_bobot.total_weightage)*100,2),0)weightage,ifnull(round((total_bobot.total_weightage/total_bobot.total_weightage)*100,2),0)total_persen");
        $this->db->from('business_driver');
        $this->db->join('perspective','perspective.kd_perspective=business_driver.kd_perspective','LEFT');
        $this->db->join('(select * from business_driver_bobot where tahun = '.$tahun.') as bdb','bdb.kd_bd=business_driver.kd_bd','LEFT');
        $this->db->join('(select business_driver.kd_perspective, sum(business_driver_bobot.weightage) as total_weightage
                        from business_driver_bobot
                        INNER JOIN business_driver ON business_driver_bobot.kd_bd = business_driver.kd_bd
                        where business_driver_bobot.tahun = '.$tahun.'
                        group by business_driver.kd_perspective) as total_bobot','total_bobot.kd_perspective=perspective.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->order_by('perspective.kd_perspective, business_driver.kd_bd');
        $this->db->limit($Limit, $Offset);
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_business_driver_all_perusahaan($kd_perusahaan,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("business_driver.*,perusahaan.nm_perusahaan, level.nm_level");
        $this->db->from('business_driver');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=business_driver.kd_perusahaan','LEFT');
        $this->db->join('level','business_driver.kd_level=level.kd_level','LEFT');
        $this->db->where('business_driver.kd_perusahaan',$kd_perusahaan);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_business_driver_by_code($kd_bd,$tahun=''){
        if($tahun==""){
            $tahun=date("Y");
        }
         $this->db->select('business_driver.kd_perspective, sum(business_driver_bobot.weightage) as total_weightage');
        $this->db->from('business_driver_bobot');
        $this->db->join('business_driver','business_driver_bobot.kd_bd = business_driver.kd_bd','LEFT');
        $this->db->where('business_driver_bobot.tahun', $tahun);
        $this->db->group_by('business_driver.kd_perspective');
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('measurement.kd_bd, count(measurement.kd_measurement) as total_data');
        $this->db->from('measurement');
        $this->db->group_by('measurement.kd_bd');
        $where_clause2 = $this->db->get_compiled_select();
        
        $this->db->select("business_driver.*,
                            ifnull(tbl_bd_used.total_data,0)total_data,
                            perspective.kd_ps,
                            perspective.nm_perspective,ifnull(round((bdb.weightage/bdbt.total_weightage)*100,2),0)weightage,
                            ifnull(round((bdbt.total_weightage/bdbt.total_weightage)*100,2),0)total_persen");
        $this->db->from('business_driver');
        $this->db->join('perspective','perspective.kd_perspective=business_driver.kd_perspective','LEFT');
        $this->db->join('(select * from business_driver_bobot where tahun = '.$tahun.') as bdb','bdb.kd_bd=business_driver.kd_bd','LEFT');
        $this->db->join('('.$where_clause.') as bdbt','bdbt.kd_perspective=business_driver.kd_perspective','LEFT');
        $this->db->join('('.$where_clause2.') as tbl_bd_used','tbl_bd_used.kd_bd=business_driver.kd_bd','LEFT');
        $this->db->where('business_driver.kd_bd',$kd_bd);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_business_driver_by_code_perusahaan($kd_bds,$kd_perusahaan){
        
        $this->db->select("business_driver.*,perspective.nm_perspective");
        $this->db->from('business_driver');
        $this->db->join('perspective','perspective.kd_perspective=business_driver.kd_perspective','LEFT');
        $this->db->where('business_driver.kd_bds',$kd_bds);
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_business_driver_by_perspective($kd_perspective,$tahun=""){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select("business_driver.*,
                            perspective.kd_ps,
                            perspective.nm_perspective,
                            ifnull(bdb.weightage,0)weightage,
                            ,ifnull(round((bdb.weightage/total_bobot.total_weightage)*100,2),0)bobot,
                            ifnull(round((total_bobot.total_weightage/total_bobot.total_weightage)*100,2),0)tot_bobot");
        $this->db->from('business_driver');
        $this->db->join('perspective','perspective.kd_perspective=business_driver.kd_perspective','LEFT');
        $this->db->join('(select * from business_driver_bobot where tahun = '.$tahun.') as bdb','bdb.kd_bd=business_driver.kd_bd','LEFT');
        $this->db->join('(select business_driver.kd_perspective, sum(business_driver_bobot.weightage) as total_weightage
                        from business_driver_bobot
                        INNER JOIN business_driver ON business_driver_bobot.kd_bd = business_driver.kd_bd
                        where business_driver_bobot.tahun = '.$tahun.'
                        group by business_driver.kd_perspective) as total_bobot','total_bobot.kd_perspective=perspective.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perspective',$kd_perspective);
        $this->db->order_by('perspective.kd_perspective, business_driver.kd_bd');
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_business_driver_bobot_by_tahun($tahun){
        
        $this->db->select("business_driver_bobot.*");
        $this->db->from('business_driver_bobot');
        $this->db->where('business_driver_bobot.tahun',$tahun);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function insert_business_driver($data){
       $this->db->insert('business_driver',$data);
       return $this->db->insert_id();
    }
    
    public function insert_business_driver_bobot($data){
       $this->db->insert('business_driver_bobot',$data);
       return $this->db->insert_id();
    }
    public function update_business_driver($kd_bd,$data){
        $this->db->where('kd_bd',$kd_bd);
        $this->db->update('business_driver',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function delete_business_driver($kd_bd){
       $this->db->where('kd_bd',$kd_bd);
       $this->db->delete('business_driver');
    }
    public function delete_business_driver_bobot($kd_perspective,$tahun){
       $this->db->select('kd_bd');
        $this->db->from('business_driver');
        $this->db->where('business_driver.kd_perspective', $kd_perspective);
        $where_clause = $this->db->get_compiled_select();

       $this->db->where('tahun',$tahun);
       $this->db->where('kd_bd IN ('.$where_clause.')',NULL,FALSE);
       $this->db->delete('business_driver_bobot');
    }
    public function get_business_driver_bobot_list_tahun(){
        
        $sql="select distinct business_driver_bobot.tahun from business_driver_bobot";
       // $this->searching->SetSerching($DataSearch);
        return $this->db->query($sql);
    }
    public function get_perspective_all_business_driver($kd_perusahaan){
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        return $this->db->get('perspective');
    }
    public function insert_copy_business_driver_bobot($kd_perspective,$thn_berjalan,$thn_lalu,$user,$tgl_input){
        $sql="INSERT INTO `business_driver_bobot` (`kd_bdb`, `kd_bd`, `weightage`, `weightage_persen`, `tahun`, `status`, `user_input`, `tgl_input`) 
                select concat(business_driver_bobot.kd_bd,?) as kode,
                                        business_driver_bobot.kd_bd,
                                        business_driver_bobot.weightage,
                                        business_driver_bobot.weightage_persen,
                                        ? as tahun,
                                        '1' as `status`,
                                        ? as user_input,
                                        ? as tgl_input
                from business_driver_bobot
                INNER JOIN business_driver ON business_driver_bobot.kd_bd = business_driver.kd_bd
                where business_driver_bobot.tahun = ? and business_driver.kd_perspective = ?";
        $bind=[$thn_berjalan,$thn_berjalan,$user,$tgl_input,$thn_lalu,$kd_perspective];
       // $this->searching->SetSerching($DataSearch);
        return $this->db->query($sql,$bind);
    }
    
    public function get_business_driver_result_kd_bd_monthly($kd_bd,$bulan,$tahun){
     
        
        $this->db->select("business_driver_result.kd_bd,
                            business_driver_result.result,
                            business_driver_result.point_result",FALSE);
        $this->db->from('business_driver_result');
        $this->db->join('business_driver','business_driver.kd_bd = business_driver_result.kd_bd');
        $this->db->where('business_driver_result.bulan',$bulan);
        $this->db->where('business_driver_result.tahun',$tahun);
        $this->db->where('business_driver_result.kd_bd',$kd_bd);
        $query = $this->db->get();
        
        return $query;
    }
    public function get_business_driver_result_kd_bd_yearly($kd_bd,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('business_driver_result.kd_bdr,
                            business_driver_result.kd_bd,
                            business_driver_result.point_result');
        $this->db->from('business_driver_result');
        $this->db->where('business_driver_result.tahun', $tahun);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("business_driver.kd_bd,business_driver.kd_bds,business_driver.nm_bd,ifnull(round(avg(tbl_bd.point_result),2),0)point_result");
        $this->db->from('business_driver');
        $this->db->join('('.$where_clause.') tbl_bd','business_driver.kd_bd = tbl_bd.kd_bd','LEFT');
        $this->db->where('business_driver.kd_bd',$kd_bd);
        $this->db->group_by("business_driver.kd_bd,business_driver.kd_bds,business_driver.nm_bd");
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
        
    }
    public function get_business_driver_result_history_kd_perspective($kd_bd,$bulan,$tahun){
     
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        
        $this->db->select("business_driver_result.kd_bd,
                            business_driver.kd_bds,
                            business_driver.nm_bd,
                            business_driver_result.tahun,
                            business_driver_result.bulan,
                            business_driver_result.result,
                            business_driver_result.point_result",FALSE);
        $this->db->from('business_driver_result');
        $this->db->join('business_driver','business_driver.kd_bd = business_driver_result.kd_bd');
        $this->db->where('business_driver_result.kd_bd',$kd_bd);
        $this->db->where("concat(business_driver_result.tahun,if(business_driver_result.bulan<10,concat('0',business_driver_result.bulan),business_driver_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $this->db->order_by("business_driver_result.tahun DESC, business_driver_result.bulan DESC");

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_business_driver_result_history_kd_perspective_yearly($kd_bd,$tahun){
     
        if($tahun==""){
            $tahun=date("Y");
        }
        $ThnAwal= $tahun - 10;
        $ThnAkhir= $tahun;
        $this->db->select('business_driver.kd_bd, 
				business_driver.kd_bds, 
				business_driver.nm_bd,
				business_driver_result.tahun,
                                round(avg(business_driver_result.result),2) as result,
				round(avg(business_driver_result.point_result),2) as point_result');
        $this->db->from('business_driver');
        $this->db->join('business_driver_result','business_driver.kd_bd = business_driver_result.kd_bd','LEFT');
        $this->db->where("business_driver_result.tahun between '$ThnAwal' and '$ThnAkhir'", NULL);
        $this->db->where('business_driver_result.kd_bd', $kd_bd);
        $this->db->group_by("business_driver.kd_bd, 
				business_driver.kd_bds, 
				business_driver.nm_bd,
				business_driver_result.tahun");
        $this->db->order_by("business_driver_result.tahun DESC");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_business_driver_result_chart_monthly_kd_bd($kd_bd,$bulan,$tahun){
     
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        
        $this->db->select("business_driver_result.kd_bd,
                            business_driver.kd_bds,
                            business_driver.nm_bd,
                            business_driver_result.tahun,
                            business_driver_result.bulan,
                            business_driver_result.point_result",FALSE);
        $this->db->from('business_driver_result');
        $this->db->join('business_driver','business_driver.kd_bd = business_driver_result.kd_bd');
        $this->db->where('business_driver.kd_bd',$kd_bd);
        $this->db->where("concat(business_driver_result.tahun,if(business_driver_result.bulan<10,concat('0',business_driver_result.bulan),business_driver_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $this->db->order_by("business_driver_result.kd_bd");

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut=0;
        $temp_bd="";
        foreach($query->result() as $row){
            if($temp_bd!=$row->kd_bd){
                $temp_bd=$row->kd_bd;
                $NoUrut++;
            }
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
            $Data['bulan'][$row->tahun.$bulan]= getNamaBulanMin($row->bulan)." ".substr($row->tahun,2);
            $Data['legend'][$row->kd_bd]= $row->nm_bd;
            $Data['color'][$row->kd_bd]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_bd]["code"] =$row->kd_bds;
            $Data['data_grafik'][$row->kd_bd]["nama"] =$row->nm_bd;
            $Data['data_grafik'][$row->kd_bd]["score"][$row->tahun.$bulan] =$row->point_result;
        }
        return $Data;
    }
    public function get_business_driver_result_chart_yearly_kd_bd($kd_bd,$tahun){
     
        if($tahun==""){
            $tahun=date("Y");
        }
        $ThnAwal= $tahun - 10;
        $ThnAkhir= $tahun;
        $this->db->select('business_driver.kd_bd, 
				business_driver.kd_bds, 
				business_driver.nm_bd,
				business_driver_result.tahun,
				round(avg(business_driver_result.point_result),2) as point_result');
        $this->db->from('business_driver');
        $this->db->join('business_driver_result','business_driver.kd_bd = business_driver_result.kd_bd','LEFT');
        $this->db->where("business_driver_result.tahun between '$ThnAwal' and '$ThnAkhir'", NULL);
        $this->db->where('business_driver_result.kd_bd', $kd_bd);
        $this->db->group_by("business_driver_result.tahun,business_driver.kd_bd, 
				business_driver.kd_bds, 
				business_driver.nm_bd
				");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut=0;
        $temp_bd="";
        foreach($query->result() as $row){
            if($temp_bd!=$row->kd_bd){
                $temp_bd=$row->kd_bd;
                $NoUrut++;
            }
            $Data['bulan'][$row->tahun]= substr($row->tahun,2);
            $Data['legend'][$row->kd_bd]= $row->nm_bd;
            $Data['color'][$row->kd_bd]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_bd]["code"] =$row->kd_bd;
            $Data['data_grafik'][$row->kd_bd]["nama"] =$row->nm_bd;
            $Data['data_grafik'][$row->kd_bd]["score"][$row->tahun] =$row->point_result;
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
    
    public function create_kd_bd($kd_perspective,$kd_ps){
        $this->db->select("business_driver.kd_bds");
        $this->db->from('business_driver');
        $this->db->where('business_driver.kd_perspective',$kd_perspective);
        $this->db->order_by('business_driver.kd_bds DESC');
        $this->db->limit(1);
        $query = $this->db->get();
//         echo $this->db->last_query();
//        die();       
        $no_urut=1;
        $kode="";
        if($query->num_rows()>0){
            foreach($query->result() as $row){
                $kode=$row->kd_bds;
            }
            $length= strlen($kd_ps);
            $nomor = substr($kode, $length);
            
            $no_urut=$nomor+1;
        }
        $kd_bd=$kd_ps.$no_urut;
        return $kd_bd;
    }
}

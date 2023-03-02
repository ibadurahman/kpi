<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perspective_model extends CI_Model
{
    public function get_perspective_all($Limit=NULL,$Offset=NULL){
        
        $this->db->select("perspective.*");
        $this->db->from('perspective');
        $this->db->order_by('perspective.kd_perspective');
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_perspective_all_perusahaan($kd_perusahaan,$Limit=NULL,$Offset=NULL){
        
        $this->db->select("perspective.*,perusahaan.nm_perusahaan");
        $this->db->from('perspective');
        $this->db->join('perusahaan','perusahaan.kd_perusahaan=perspective.kd_perusahaan','LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_perspective_by_code($kd_perspective){
        $this->db->select('business_driver.kd_perspective, count(business_driver.kd_bd) as total_data');
        $this->db->from('business_driver');
        $this->db->group_by('business_driver.kd_perspective');
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("perspective.*,ifnull(tbl_used.total_data,0)total_data");
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') as tbl_used','tbl_used.kd_perspective=perspective.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perspective',$kd_perspective);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_perspective_by_code_perusahaan($kd_ps,$kd_perusahaan){
        
        $this->db->select("perspective.*");
        $this->db->from('perspective');
        $this->db->where('perspective.kd_ps',$kd_ps);
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    
    public function get_perspective_bobot_by_tahun($tahun,$kd_perusahaan){
        $this->db->select('SUM(perspective_bobot.weightage) as total_weightage');
        $this->db->from('perspective_bobot');
        $this->db->join('perspective','perspective_bobot.kd_perspective=perspective.kd_perspective','LEFT');
        $this->db->where('perspective_bobot.tahun', $tahun);
        $this->db->where('perspective.kd_perusahaan', $kd_perusahaan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("perspective_bobot.*,perspective.nm_perspective,round((ifnull(perspective_bobot.weightage,0)/tbl_total_bobot.total_weightage)*100,2) bobot");
        $this->db->from(["(".$where_clause.") as tbl_total_bobot",'perspective_bobot']);
        $this->db->join('perspective','perspective_bobot.kd_perspective=perspective.kd_perspective','LEFT');
        $this->db->where('perspective_bobot.tahun',$tahun);
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->order_by('perspective_bobot.kd_perspective');
        $result=$this->db->get();
//        echo $this->db->last_query();
       // $this->searching->SetSerching($DataSearch);
        return $result;
    }
    public function insert_perspective($data){
       $this->db->insert('perspective',$data);
       return $this->db->insert_id();
    }
    
    public function insert_perspective_bobot($data){
       $this->db->insert('perspective_bobot',$data);
       return $this->db->insert_id();
    }
    public function update_perspective($kd_perspective,$data){
        $this->db->where('kd_perspective',$kd_perspective);
        $this->db->update('perspective',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function update_perspective_bobot($kd_pb,$data){
        $this->db->where('kd_pb',$kd_pb);
        $this->db->update('perspective_bobot',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
    public function delete_perspective($kd_perspective){
       $this->db->where('kd_perspective',$kd_perspective);
       $this->db->delete('perspective');
    }
    public function delete_perspective_bobot($tahun,$kd_perusahaan){
        $this->db->select('perspective.kd_perspective');
        $this->db->from('perspective');
        $this->db->where('perspective.kd_perusahaan', $kd_perusahaan);
        $where_clause = $this->db->get_compiled_select();
        
       $this->db->where('tahun',$tahun);
       $this->db->where('kd_perspective IN ('.$where_clause.')',NULL,FALSE);
       $this->db->delete('perspective_bobot');
    }
    
    public function get_jabatan_all_perspective(){
        
        return $this->db->get('jabatan');
    }
    public function get_departemen_all_perspective(){
        
        return $this->db->get('departemen');
    }
    
    public function get_perusahaan_all_perspective(){
        
        return $this->db->get('perusahaan');
    }
    public function get_perspective_bobot_list_tahun($kd_perspective,$tahun,$kd_perusahaan){
        $this->db->select('SUM(perspective_bobot.weightage) as total_weightage');
        $this->db->from('perspective_bobot');
        $this->db->join('perspective','perspective_bobot.kd_perspective=perspective.kd_perspective','LEFT');
        $this->db->where('perspective_bobot.tahun', $tahun);
        $this->db->where('perspective.kd_perusahaan', $kd_perusahaan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("perspective_bobot.*,perspective.nm_perspective,round((ifnull(perspective_bobot.weightage,0)/tbl_total_bobot.total_weightage)*100,2) bobot");
        $this->db->from(["(".$where_clause.") as tbl_total_bobot",'perspective_bobot']);
        $this->db->join('perspective','perspective_bobot.kd_perspective=perspective.kd_perspective','LEFT');
        $this->db->where('perspective_bobot.tahun',$tahun);
        $this->db->where('perspective_bobot.kd_perspective',$kd_perspective);
        $this->db->order_by('perspective_bobot.kd_perspective');
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function insert_copy_bobot($thn_berjalan,$thn_lalu,$user,$tgl_input, $kd_perusahaan){
        $sql="INSERT INTO `perspective_bobot` (`kd_pb`, `kd_perspective`, `weightage`, `weightage_persen`, `tahun`, `status`, `user_input`, `tgl_input`) 
                select concat(perspective_bobot.kd_perspective,?) as kode,
                                        perspective_bobot.kd_perspective,
                                        perspective_bobot.weightage,
                                        perspective_bobot.weightage_persen,
                                        ? as tahun,
                                        '1' as `status`,
                                        ? as user_input,
                                        ? as tgl_input
                from perspective_bobot
                INNER JOIN perspective ON perspective.kd_perspective = perspective_bobot.kd_perspective
                where perspective_bobot.tahun = ? and perspective.kd_perusahaan = ?";
        $bind=[$thn_berjalan,$thn_berjalan,$user,$tgl_input,$thn_lalu,$kd_perusahaan];
       // $this->searching->SetSerching($DataSearch);
       $query = $this->db->query($sql,$bind);
    //    echo $this->db->last_query();die;
        return $query;
    }
    public function get_perspective_result_kd_perspective_monthly($kd_perspective,$bulan,$tahun){
     
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $this->db->select('perspective_result.kd_pr,
                            perspective_result.kd_perspective,
                            perspective_result.point_result');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $this->db->where('perspective_result.bulan', $bulan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("perspective.kd_perspective,perspective.kd_ps,perspective.nm_perspective,ifnull(tbl_ps.point_result,0) point_result ");
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') tbl_ps','perspective.kd_perspective = tbl_ps.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perspective',$kd_perspective);
        $query = $this->db->get();
        
        return $query;
    }
    public function get_perspective_result_kd_perspective_yearly($kd_perspective,$tahun){
     
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('perspective_result.kd_pr,
                            perspective_result.kd_perspective,
                            perspective_result.point_result');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("perspective.kd_perspective,perspective.kd_ps,perspective.nm_perspective,ifnull(round(avg(tbl_ps.point_result),2),0)point_result");
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') tbl_ps','perspective.kd_perspective = tbl_ps.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perspective',$kd_perspective);
        $this->db->group_by("perspective.kd_perspective,perspective.kd_ps,perspective.nm_perspective");
        $query = $this->db->get();
        
        return $query;
    }
    public function get_perspective_result_history_kd_perspective($kd_perspective,$bulan,$tahun){
     
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        
        $this->db->select("perspective_result.kd_perspective,
                            perspective.kd_ps,
                            perspective.nm_perspective,
                            perspective_result.tahun,
                            perspective_result.bulan,
                            perspective_result.result,
                            perspective_result.point_result",FALSE);
        $this->db->from('perspective_result');
        $this->db->join('perspective','perspective.kd_perspective = perspective_result.kd_perspective');
        $this->db->where('perspective_result.kd_perspective',$kd_perspective);
        $this->db->where("concat(perspective_result.tahun,if(perspective_result.bulan<10,concat('0',perspective_result.bulan),perspective_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $this->db->order_by("perspective_result.tahun DESC, perspective_result.bulan DESC");

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_perspective_result_history_kd_perspective_yearly($kd_perspective,$tahun){
     
        if($tahun==""){
            $tahun=date("Y");
        }
        $ThnAwal= $tahun - 10;
        $ThnAkhir= $tahun;
        $this->db->select('perspective.kd_perspective, 
				perspective.kd_ps, 
				perspective.kd_perusahaan, 
				perspective.nm_perspective,
				perspective_result.tahun,
                                round(avg(perspective_result.result),2) as result,
				round(avg(perspective_result.point_result),2) as point_result');
        $this->db->from('perspective');
        $this->db->join('perspective_result','perspective.kd_perspective = perspective_result.kd_perspective','LEFT');
        $this->db->where("perspective_result.tahun between '$ThnAwal' and '$ThnAkhir'", NULL);
        $this->db->where('perspective_result.kd_perspective', $kd_perspective);
        $this->db->group_by("perspective_result.tahun,
                perspective.kd_perspective, 
				perspective.kd_ps, 
				perspective.kd_perusahaan, 
				perspective.nm_perspective");
                $this->db->order_by("perspective_result.tahun DESC");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        return $query;
    }
    public function get_perspective_result_chart($kd_perusahaan,$tahun){
     
        
        $this->db->select("perspective_result.kd_perspective,avg(perspective_result.score) score",FALSE);
        $this->db->from('perspective_result');
        $this->db->join('perspective','perspective.kd_perspective = perspective_result.kd_perspective');
        $this->db->where('perspective_result.tahun',$tahun);
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->group_by("perspective_result.kd_perspective");
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("perspective.kd_perspective,perspective.kd_ps,round(ifnull(tbl_result.score,0)*4,2) score",FALSE);
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') as tbl_result',"tbl_result.kd_perspective = perspective.kd_perspective",'LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data["Label"]='';
        $Data["Value"]='';
        //$Data["Color"]='';
        foreach($query->result() as $row){
            $Data["Label"] .="'".$row->kd_ps."',";
            $Data["Value"] .=$row->score.",";
//            $Data["Color"] .="'".$this->rand_color()."',";
        }
        return $Data;
    }
    public function get_perspective_result_radar_monthly($kd_perusahaan,$tahun,$bulan){
     
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('perspective_result.kd_pr,
                            perspective_result.kd_perspective,
                            round(perspective_result.point_result,2) as gross_point,
                            perspective_result.weightage,
                            round(perspective_result.score,2) as point_perspective');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $this->db->where('perspective_result.bulan', $bulan);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select('perspective_result.kd_perspective,
                            round(avg(perspective_result.point_result),2) as gross_point,
                            round(avg(perspective_result.score),2) as point_perspective');
        $this->db->from('perspective_result');
        $this->db->where('perspective_result.tahun', $tahun);
        $this->db->group_by('perspective_result.kd_perspective');
        $where_clause2 = $this->db->get_compiled_select();

        $this->db->select("perspective.kd_perspective,
			perspective.kd_ps,
                        perspective.kd_perusahaan,
			perspective.nm_perspective,
			ifnull(point_bulan.weightage,0) as weightage,
			ifnull(point_bulan.gross_point,0) as gross_point,
			ifnull(point_bulan.point_perspective,0) as point,
			ifnull(point_tahun.gross_point,0) as gross_point_tahun,
			ifnull(point_tahun.point_perspective,0) as point_tahun",false);
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') point_bulan','perspective.kd_perspective = point_bulan.kd_perspective','LEFT');
        $this->db->join('('.$where_clause2.') point_tahun','perspective.kd_perspective = point_tahun.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data["Label"]='';
        $Data["Value"]='';
        //$Data["Color"]='';
        foreach($query->result() as $row){
            $Data["Label"] .="'".$row->kd_ps."',";
            $Data["Value"] .=$row->gross_point.",";
//            $Data["Color"] .="'".$this->rand_color()."',";
        }
        return $Data;
    }
    public function get_perspective_result_radar_yearly($kd_perusahaan,$tahun){
     
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select('perspective_result.kd_perspective,
                            group_concat(perspective_result.weightage) weightage,
                            perspective_result.tahun,
                            round(avg(perspective_result.point_result),2) as gross_point,
                            round(avg(perspective_result.score),2) as point_perspective');
        $this->db->from('perspective_result');
        $this->db->where("perspective_result.tahun", $tahun);
        $this->db->group_by('perspective_result.tahun,perspective_result.kd_perspective');
        $where_clause = $this->db->get_compiled_select();

        $this->db->select("perspective.kd_perspective,
			perspective.kd_ps,
                        perspective.kd_perusahaan,
			perspective.nm_perspective,
                        point_bulan.tahun,
			ifnull(point_bulan.weightage,0) as weightage,
			ifnull(point_bulan.gross_point,0) as gross_point,
			ifnull(point_bulan.point_perspective,0) as point",false);
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') point_bulan','perspective.kd_perspective = point_bulan.kd_perspective','LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data["Label"]='';
        $Data["Value"]='';
        //$Data["Color"]='';
        foreach($query->result() as $row){
            $Data["Label"] .="'".$row->kd_ps."',";
            $Data["Value"] .=$row->gross_point.",";
//            $Data["Color"] .="'".$this->rand_color()."',";
        }
        return $Data;
    }
    public function get_perspective_result_chart_monthly($kd_perusahaan,$bulan,$tahun){
     
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        $TglAwal=$thnAwal."-".$bulan."-".$bulan;
        $this->db->select("perspective_result.kd_perspective,
                            perspective_result.tahun,
                            perspective_result.bulan,
                            (sum(perspective_result.point_result)) as score",FALSE);
        $this->db->from('perspective_result');
        $this->db->join('perspective','perspective.kd_perspective = perspective_result.kd_perspective');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->where("concat(perspective_result.tahun,if(perspective_result.bulan<10,concat('0',perspective_result.bulan),perspective_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $this->db->group_by("perspective_result.kd_perspective,perspective_result.tahun,perspective_result.bulan");
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("perspective.kd_perspective,
                            perspective.kd_ps,
                            tbl_result.bulan,
                            tbl_result.tahun,
                            perspective.nm_perspective,
                            tbl_result.score",FALSE);
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') as tbl_result',"tbl_result.kd_perspective = perspective.kd_perspective",'LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->order_by("perspective.kd_perspective,tbl_result.tahun,tbl_result.bulan");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut=0;
        $temp_ps="";
        foreach($query->result() as $row){
            if($temp_ps!=$row->kd_perspective){
                $temp_ps=$row->kd_perspective;
                $NoUrut++;
            }
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
            $Data['bulan'][$row->tahun.$bulan]= getNamaBulanMin($row->bulan)." ".substr($row->tahun,2);
            $Data['legend'][$row->kd_perspective]= $row->nm_perspective;
            $Data['color'][$row->kd_perspective]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_perspective]["code"] =$row->kd_ps;
            $Data['data_grafik'][$row->kd_perspective]["nama"] =$row->nm_perspective;
            $Data['data_grafik'][$row->kd_perspective]["score"][$row->tahun.$bulan] =$row->score;
        }
//        var_dump($Data);
        //die();
        return $Data;
    }
    
    public function get_perspective_bar_chart_tahun($kd_perusahaan,$tahun){
     
        $thnAwal=$tahun-10;
        
        $this->db->select("perspective_result.kd_perspective,
                            perspective_result.tahun,
                            round(avg(perspective_result.point_result),2) as score",FALSE);
        $this->db->from('perspective_result');
        $this->db->join('perspective','perspective.kd_perspective = perspective_result.kd_perspective');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->where("perspective_result.tahun between '$thnAwal' and '$tahun'",NULL);
        $this->db->group_by("perspective_result.kd_perspective,perspective_result.tahun");
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("perspective.kd_perspective,
                            perspective.kd_ps,
                            tbl_result.tahun,
                            perspective.nm_perspective,
                            tbl_result.score",FALSE);
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') as tbl_result',"tbl_result.kd_perspective = perspective.kd_perspective",'LEFT');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $this->db->order_by("perspective.kd_perspective,tbl_result.tahun");
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut = 0;
        $temp_ps="";
        foreach($query->result() as $row){
            if($temp_ps!=$row->kd_perspective){
                $temp_ps=$row->kd_perspective;
                $NoUrut++;
            }
            
            $Data['bulan'][$row->tahun]= substr($row->tahun,2);
            $Data['legend'][$row->kd_perspective]= $row->nm_perspective;
            $Data['color'][$row->kd_perspective]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_perspective]["code"] =$row->kd_ps;
            $Data['data_grafik'][$row->kd_perspective]["nama"] =$row->nm_perspective;
            $Data['data_grafik'][$row->kd_perspective]["score"][$row->tahun] =$row->score;
            
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
    public function get_perspective_result_chart_monthly_kd_perspective($kd_perspective,$bulan,$tahun){
     
        $thnAwal=$tahun-1;
        $PeriodeAkhir=$tahun.$bulan;
        $PeriodeAwal=$thnAwal.$bulan;
        
        $this->db->select("perspective_result.kd_perspective,
                            perspective_result.tahun,
                            perspective_result.bulan,
                            round(((perspective_result.result)),2) as result_point",FALSE);
        $this->db->from('perspective_result');
        $this->db->join('perspective','perspective.kd_perspective = perspective_result.kd_perspective');
        $this->db->where('perspective.kd_perspective',$kd_perspective);
        $this->db->where("concat(perspective_result.tahun,if(perspective_result.bulan<10,concat('0',perspective_result.bulan),perspective_result.bulan)) between '$PeriodeAwal' and '$PeriodeAkhir'",NULL);
        $where_clause = $this->db->get_compiled_select();
        
        $this->db->select("perspective.kd_perspective,
                            perspective.kd_ps,
                            tbl_result.bulan,
                            tbl_result.tahun,
                            perspective.nm_perspective,ifnull(tbl_result.result_point,0) result_point",FALSE);
        $this->db->from('perspective');
        $this->db->join('('.$where_clause.') as tbl_result',"tbl_result.kd_perspective = perspective.kd_perspective",'LEFT');
        $this->db->where('perspective.kd_perspective',$kd_perspective);

        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut=0;
        $temp_ps="";
        foreach($query->result() as $row){
            if($temp_ps!=$row->kd_perspective){
                $temp_ps=$row->kd_perspective;
                $NoUrut++;
            }
            if(strlen($row->bulan)<2){
                $bulan="0".$row->bulan;
            }else{
                $bulan=$row->bulan;
            }
            $Data['bulan'][$row->tahun.$bulan]= getNamaBulanMin($row->bulan)." ".substr($row->tahun,2);
            $Data['legend'][$row->kd_perspective]= $row->nm_perspective;
            $Data['color'][$row->kd_perspective]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_perspective]["code"] =$row->kd_ps;
            $Data['data_grafik'][$row->kd_perspective]["nama"] =$row->nm_perspective;
            $Data['data_grafik'][$row->kd_perspective]["score"][$row->tahun.$bulan] =$row->result_point;
        }
        return $Data;
    }
    public function get_perspective_result_chart_yearly_kd_perspective($kd_perspective,$tahun){
     
        if($tahun==""){
            $tahun=date("Y");
        }
        $ThnAwal= $tahun - 10;
        $ThnAkhir= $tahun;
        $this->db->select('perspective.kd_perspective, 
				perspective.kd_ps, 
				perspective.kd_perusahaan, 
				perspective.nm_perspective,
				perspective_result.tahun,
				round(avg(perspective_result.point_result),2) as point_result');
        $this->db->from('perspective');
        $this->db->join('perspective_result','perspective.kd_perspective = perspective_result.kd_perspective','LEFT');
        $this->db->where("perspective_result.tahun between '$ThnAwal' and '$ThnAkhir'", NULL);
        $this->db->where('perspective_result.kd_perspective', $kd_perspective);
        $this->db->group_by("perspective.kd_perspective, 
				perspective.kd_ps, 
				perspective.kd_perusahaan, 
				perspective.nm_perspective,
                                perspective_result.tahun");
        $query=$this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data["bulan"]=array();
        $Data["legend"]=array();
        $Data["color"]=array();
        $Data["data_grafik"]=array();
        //$Data["Color"]='';
        $NoUrut=0;
        $temp_ps="";
        foreach($query->result() as $row){
            if($temp_ps!=$row->kd_perspective){
                $temp_ps=$row->kd_perspective;
                $NoUrut++;
            }
            $Data['bulan'][$row->tahun]= substr($row->tahun,2);
            $Data['legend'][$row->kd_perspective]= $row->nm_perspective;
            $Data['color'][$row->kd_perspective]= $this->list_warna($NoUrut);
            $Data['data_grafik'][$row->kd_perspective]["code"] =$row->kd_perspective;
            $Data['data_grafik'][$row->kd_perspective]["nama"] =$row->nm_perspective;
            $Data['data_grafik'][$row->kd_perspective]["score"][$row->tahun] =$row->point_result;
        }
        return $Data;
    }
}

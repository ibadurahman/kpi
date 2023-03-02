<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model
{
    
    public function get_perusahaan_all_home($Limit=NULL,$Offset=NULL){
        
        $this->db->select("perusahaan.*");
        $this->db->from('perusahaan');
        $this->db->limit($Limit, $Offset);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_perusahaan_by_code_home($kd_perusahaan){
        
        $this->db->select("perusahaan.*");
        $this->db->from('perusahaan');
        $this->db->where('perusahaan.kd_perusahaan',$kd_perusahaan);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_pegawai_by_userid_home($user_id){
        
        $this->db->select("pegawai.*");
        $this->db->from('pegawai');
        $this->db->join('users',"pegawai.nip=users.nip","right");
        $this->db->where('users.id',$user_id);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_jml_pegawai($kd_perusahaan,$DataTahun){
        
        $this->db->select("sum(case when pegawai.`status`=1 then 1 else 0 end) total,
			sum(case when pegawai.`status`=1 and year(pegawai.tgl_masuk)=$DataTahun then 1 else 0 end) tot_masuk,
			sum(case when pegawai.`status`=2 and year(pegawai.tgl_keluar)=$DataTahun then 1 else 0 end) tot_keluar",FALSE);
        $this->db->from('pegawai');
        $this->db->where('pegawai.kd_perusahaan',$kd_perusahaan);
        
       // $this->searching->SetSerching($DataSearch);
        return $this->db->get();
    }
    public function get_perspective_by_kd_perusahaan_home($kd_perusahaan){
        
        $this->db->select("perspective.*");
        $this->db->from('perspective');
        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_perspective_result_chart($kd_perusahaan,$tahun,$bulan){
     
        
//        $this->db->select("perspective_result.kd_perspective,avg(perspective_result.score) score",FALSE);
//        $this->db->from('perspective_result');
//        $this->db->join('perspective','perspective.kd_perspective = perspective_result.kd_perspective');
//        $this->db->where('perspective_result.tahun',$tahun);
//        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
//        $this->db->group_by("perspective_result.kd_perspective");
//        $where_clause = $this->db->get_compiled_select();
//        
//        $this->db->select("perspective.kd_perspective,perspective.kd_ps,round(ifnull(tbl_result.score,0)*4,2) score",FALSE);
//        $this->db->from('perspective');
//        $this->db->join('('.$where_clause.') as tbl_result',"tbl_result.kd_perspective = perspective.kd_perspective",'LEFT');
//        $this->db->where('perspective.kd_perusahaan',$kd_perusahaan);
//        $query = $this->db->get();
        
        $this->db->select('perspective_result.kd_pr,
                            perspective_result.kd_perspective,
                            round(perspective_result.point_result,2) as gross_point,
                            perspective_result.weightage,
                            round(perspective_result.score,2)as point_perspective');
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
        
        
        $query=$this->db->get();
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
        $query=$this->db->get();
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
//        $sql="SELECT tbl_ps.kd_perspective, 
//			tbl_ps.kd_ps, 
//			tbl_result.bulan, 
//			tbl_result.tahun, 
//			tbl_ps.nm_perspective, 
//			ifnull(tbl_result.score,0)score,
//			tbl_ps.period,
//			tbl_ps.bln
//                FROM (
//                        select perspective.kd_perspective,
//                                                perspective.kd_ps,
//                                                perspective.nm_perspective,
//                                                perspective.kd_perusahaan,
//                                                tbl_period.period,
//                                                tbl_period.bln
//                        from perspective,
//                        (select date_format(data_tgl.tgl,'%Y%m') period, date_format(data_tgl.tgl,'%Y-%m') as bln
//                        from(
//                                select ? as tgl,0 as jml
//                                union
//                                select date_add( ? , interval tbl_bln.m MONTH) as tgl, tbl_bln.m
//                                        from(
//                                                select @rownum:=@rownum+1 as m from
//                                                (select 1 union select 2 union select 3) t1,
//                                                (select 1 union select 2 ) t2,
//                                                (select 1 union select 2 ) t3,
//                                                (select @rownum:=0) t0
//                                        )tbl_bln
//                                )data_tgl
//                        )tbl_period
//                        where perspective.kd_perusahaan= ?
//                ) tbl_ps
//                LEFT JOIN (
//                        SELECT perspective_result.kd_perspective, 
//                                                perspective_result.tahun, 
//                                                perspective_result.bulan, 
//                                                (sum(perspective_result.point_result)) as score,
//                                                concat( perspective_result.tahun,if(length(perspective_result.bulan)<2,concat('0',perspective_result.bulan),perspective_result.bulan)) as period 
//                        FROM `perspective_result` 
//                        JOIN `perspective` ON `perspective`.`kd_perspective` = `perspective_result`.`kd_perspective` 
//                        WHERE `perspective`.`kd_perusahaan` = ? 
//                        AND concat(perspective_result.tahun,if(perspective_result.bulan < 10,concat('0',perspective_result.bulan),perspective_result.bulan)) between ? and ? 
//                        GROUP BY `perspective_result`.`kd_perspective`, `perspective_result`.`tahun`, `perspective_result`.`bulan`
//                ) as tbl_result ON tbl_result.kd_perspective = tbl_ps.kd_perspective and tbl_ps.period = tbl_result.period
//                WHERE `tbl_ps`.`kd_perusahaan` = ? 
//                ORDER BY `tbl_ps`.`kd_perspective`, `tbl_ps`.`period`";
//        $bind=[$TglAwal,$TglAwal,$kd_perusahaan,$kd_perusahaan,$PeriodeAwal,$PeriodeAkhir,$kd_perusahaan];
//        $query = $this->db->query($sql,$bind);
        
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
            if($temp_ps != $row->kd_perspective){
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
            $Data['data_grafik'][$row->kd_perspective]["score"][$row->tahun.$row->bulan] =$row->score;
//            $period= explode("-", $row->bln);
//            $bulan=$period[1];
//            $tahun=$period[0];
//            
//            $Data['bulan'][$row->period]= getNamaBulanMin($bulan)." ".substr($tahun,2);
//            $Data['legend'][$row->kd_perspective]= $row->nm_perspective;
//            $Data['color'][$row->kd_perspective]= $this->list_warna($NoUrut);
//            $Data['data_grafik'][$row->kd_perspective]["code"] =$row->kd_ps;
//            $Data['data_grafik'][$row->kd_perspective]["nama"] =$row->nm_perspective;
//            $Data['data_grafik'][$row->kd_perspective]["score"][$row->period] =$row->score;
            //$NoUrut++;
        }
        return $Data;
    }
    
    public function get_perspective_result_chart_yearly($kd_perusahaan,$tahun){
     
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
        $list_warna[2]="#34bfa3";//success
        $list_warna[3]="#ffb822";//warning
        $list_warna[4]="#f4516c";//danger
        $list_warna[5]="#5867dd";//primary
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
    public function insert_notifikasi_appraisal($bulan,$tahun,$ket){
        $nm_bln= getNamaBulanMin($bulan);
        $periode = $nm_bln." ".$tahun;
        $link='scorecards/Appraisal/index/'.$tahun."/".$bulan;
        $sql="INSERT INTO `notifikasi` (`kd_notifikasi`, `nip`, `pesan`, `link`, `tipe`, `status`,`status_admin`, `tgl_input`) 
                select uuid_short(),
                    pegawai.nip,
                    concat(CONCAT(pegawai.nama,'( ',pegawai.nip,' ) '), ' appraisal ',?,' ',?) as Keterangan,
                    ? as Link,
                    'ALRT' as tipe,
                    0,0,
                    now()
                from pegawai
                where pegawai.nip not in (select nip from appraisal where appraisal.bulan=? and appraisal.tahun=?)
                and pegawai.nip not in (select notifikasi.nip
                                            from notifikasi
                                            where notifikasi.tipe='ALRT' and date_format(notifikasi.tgl_input,'%Y-%m-%d') between 
                                                    date_add(now(),INTERVAL -7 day) and date_format(now(),'%Y-%m-%d'))
                and pegawai.`status`=1 ";
        $bind=array($periode,$ket,$link,$bulan,$tahun);
       $query = $this->db->query($sql,$bind);
//       echo $this->db->last_query();
//        die();
       return $query;
    }
    public function get_notifikasi($report_to=""){
        
        $this->db->select("notifikasi.*");
        $this->db->from('notifikasi');
        $this->db->join('pegawai','pegawai.nip=notifikasi.nip','LEFT');
        if($report_to!=""){
            $this->db->where('pegawai.nip',$report_to);
            $this->db->or_where('pegawai.report_to',$report_to);
            $this->db->order_by('notifikasi.status asc');
        }else{
            $this->db->order_by('notifikasi.status_admin asc, notifikasi.tgl_input desc');
        }
        
        $this->db->limit(10);
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        return $query;
    }
    public function get_notifikasi_total($report_to=""){
        
        if($report_to!=""){
            $this->db->select("count(notifikasi.kd_notifikasi)as tot_notifikasi");
            $this->db->from('notifikasi');
            $this->db->join('pegawai','pegawai.nip=notifikasi.nip','LEFT');
            $this->db->where('pegawai.nip',$report_to);
            $this->db->or_where('pegawai.report_to',$report_to);
            $this->db->where('notifikasi.status',0);
        }else{
            $this->db->select("count(notifikasi.kd_notifikasi)as tot_notifikasi");
            $this->db->from('notifikasi');
            $this->db->join('pegawai','pegawai.nip=notifikasi.nip','LEFT');
            $this->db->where('notifikasi.status_admin',0);
        }
        $query = $this->db->get();
//        echo $this->db->last_query();
//        die();
       // $this->searching->SetSerching($DataSearch);
        $JmlData=0;
        if($query->num_rows()>0){
            $JmlData=$query->row()->tot_notifikasi;
        }
        return $JmlData;
    }
    public function get_bottom_score($kd_perusahaan,$bulan,$tahun){
        $tglAwal= $tahun."-".$bulan."-01";
        $sql="select *
                from( select avg_score.*,
			pegawai.nama
                    from(
                        select score_bulan.nip,
                                round(avg(score_bulan.score),2) as score_avg
                        from(
                                select appraisal.nip,
                                        appraisal.bulan,
                                        appraisal.tahun,
                                        appraisal_detail.kd_appraisal, 
                                        sum(appraisal_detail.score_kpi) as score
                                from appraisal
                                INNER JOIN appraisal_detail ON appraisal.kd_appraisal = appraisal_detail.kd_appraisal
                                INNER JOIN pegawai ON pegawai.nip = appraisal.nip
                                where pegawai.kd_perusahaan=? and appraisal.tahun = ? and (pegawai.`status`=1 or (pegawai.`status`=2 and pegawai.tgl_keluar > date_format(?,'%Y-%m-%d')))
                                group by appraisal.nip,appraisal.bulan,appraisal.tahun,appraisal_detail.kd_appraisal
                        ) as score_bulan
                        group by score_bulan.nip
                    )as avg_score
                    LEFT JOIN pegawai ON avg_score.nip=pegawai.nip
                    order by avg_score.score_avg ASC
                    limit 10
                ) as data_bottom_score
                order by score_avg DESC";
        $bind=array($kd_perusahaan,$tahun,$tglAwal);
       $query = $this->db->query($sql,$bind);
//       echo $this->db->last_query();
//        die();
       return $query;
    }
    public function get_top_score($kd_perusahaan,$bulan,$tahun){
        $tglAwal= $tahun."-".$bulan."-01";
        $sql="select avg_score.*,
			pegawai.nama
                from(
                        select score_bulan.nip,
                                round(avg(score_bulan.score),2) as score_avg
                        from(
                                select appraisal.nip,
                                        appraisal.bulan,
                                        appraisal.tahun,
                                        appraisal_detail.kd_appraisal, 
                                        sum(appraisal_detail.score_kpi) as score
                                from appraisal
                                INNER JOIN appraisal_detail ON appraisal.kd_appraisal = appraisal_detail.kd_appraisal
                                INNER JOIN pegawai ON pegawai.nip = appraisal.nip
                                where pegawai.kd_perusahaan=? and appraisal.tahun = ? and (pegawai.`status`=1 or (pegawai.`status`=2 and pegawai.tgl_keluar > date_format(?,'%Y-%m-%d')))
                                group by appraisal.nip,appraisal.bulan,appraisal.tahun,appraisal_detail.kd_appraisal
                        ) as score_bulan
                        group by score_bulan.nip
                )as avg_score
                LEFT JOIN pegawai ON avg_score.nip=pegawai.nip
                order by avg_score.score_avg DESC
                limit 10 ";
        $bind=array($kd_perusahaan,$tahun,$tglAwal);
       $query = $this->db->query($sql,$bind);
//       echo $this->db->last_query();
//        die();
       return $query;
    }
    public function get_subordinate($kd_perusahaan,$nip,$tahun,$bulan=""){
        $addSql="";
        $addSql2="";
        if($bulan!=""){
            $addSql=" AND data_appraisal.bulan = '".$bulan."' ";
            $addSql2=" where (tbl_bulan_pegawai.bulan = '".$bulan."') ";
        }
        $sql="select pegawai.*,departemen.nm_departemen,jabatan.nm_jabatan,data_jml_kpi.jml_data_kpi,
        pg.nama as report_to_nama,data_appraisal.bulan,data_appraisal.tahun,
        data_appraisal.kd_appraisal, data_appraisal.status as stat_appraisal, data_appraisal.point
  from pegawai
  left join departemen on departemen.kd_departemen=pegawai.kd_departemen
  left join jabatan on jabatan.kd_jabatan=pegawai.kd_jabatan
  left join pegawai pg on pg.nip=pegawai.report_to
  left join (
      select tbl_appraisal.kd_appraisal,
              tbl_appraisal.status,
              tbl_appraisal.point,
              tbl_bulan_pegawai.nip,
              case
                  when tbl_appraisal.bulan is null then tbl_bulan_pegawai.bulan
                  else tbl_appraisal.bulan
              end as bulan,
              case
                  when tbl_appraisal.tahun is null then ?
                  else tbl_appraisal.tahun
              end as tahun
      from (
              select tbl_bulan.bulan,pegawai.nip
              from(SELECT 1 bulan 
                      UNION SELECT 2 
                      UNION SELECT 3 
                      UNION SELECT 4
                      UNION SELECT 5
                      UNION SELECT 6
                      UNION SELECT 7
                      UNION SELECT 8
                      UNION SELECT 9
                      UNION SELECT 10
                      UNION SELECT 11
                      UNION SELECT 12
                  ) as tbl_bulan,pegawai 
              where pegawai.kd_perusahaan = ? and pegawai.`status` = 1
          ) tbl_bulan_pegawai
      LEFT JOIN (
                      select kd_appraisal, status, nip, bulan,tahun,point from appraisal where  tahun = ?
      )tbl_appraisal ON tbl_bulan_pegawai.bulan = tbl_appraisal.bulan and tbl_bulan_pegawai.nip = tbl_appraisal.nip
      ".$addSql2."
  ) as data_appraisal on pegawai.nip = data_appraisal.nip
  left join (
              SELECT count(pegawai_kpi.kd_pk) as jml_data_kpi, nip FROM pegawai_kpi group by nip
  ) as data_jml_kpi on pegawai.nip = data_jml_kpi.nip
  where pegawai.status = 1 and (pegawai.report_to= ? ) AND pegawai.kd_perusahaan = ? AND data_appraisal.tahun = ?
   ".$addSql;
        $bind=array($tahun,$kd_perusahaan,$tahun,$nip,$kd_perusahaan,$tahun);
       $query = $this->db->query($sql,$bind);
//       echo $this->db->last_query();
//        die();
       return $query;
    }
    public function update_notifikasi_home($kd_notifikasi,$data){
        $this->db->where('kd_notifikasi',$kd_notifikasi);
        $this->db->update('notifikasi',$data);
//       $sql = $this->db->set($this->DataDatabase)->get_compiled_update('Business_driver');
//        echo $sql."---".$kd_bd;
//        die();
    }
}

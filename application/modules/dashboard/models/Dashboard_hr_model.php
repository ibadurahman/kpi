<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_hr_model extends CI_Model
{
    public function get_dashboard_hr_jml_peg($kd_perusahaan,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $Period=$tahun.$bulan;
        $this->db->select("sum(
                                    case when pegawai.jenis_kelamin='L' then 1
                                    else 0
                                    end
                            )as jml_pegawai_l,
                            sum(
                                    case when pegawai.jenis_kelamin='P' then 1
                                    else 0
                                    end
                            )as jml_pegawai_p");
        $this->db->from('pegawai');
        $this->db->group_start();
            $this->db->group_start();
                $this->db->where('pegawai.status',1);
                $this->db->where("date_format(pegawai.tgl_masuk,'%Y%m')<=",$Period);
            $this->db->group_end();
            $this->db->or_group_start();
                $this->db->where('pegawai.status',2);
                $this->db->group_start();
                    $this->db->where("date_format(pegawai.tgl_masuk,'%Y%m')<=",$Period);
                    $this->db->where("date_format(pegawai.tgl_keluar,'%Y%m')>=",$Period);
                $this->db->group_end();
            $this->db->group_end();
        $this->db->group_end();
//        $this->db->where("((pegawai.status = 1 and date_format(pegawai.tgl_masuk,'%Y%m')<='$Period') or 
//		(pegawai.status = 2 and (date_format(pegawai.tgl_masuk,'%Y%m')<='$Period' and '$Period'<=date_format(pegawai.tgl_keluar,'%Y%m'))))",NULL);
        $this->db->where('pegawai.kd_perusahaan',$kd_perusahaan);
        $query= $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data=array();
        //$Data["Color"]='';
        if($query->num_rows()>0){
            $row=$query->row();
            $Data['detail']['L']["label"]= "L";
            $Data['detail']['L']["value"]= $row->jml_pegawai_l;
            $Data['detail']['L']["color_code"]= "#00c5dc";
            $Data['detail']['L']["color"]= "accent";
            
            $Data['detail']['P']["label"]= "P";
            $Data['detail']['P']["value"]= $row->jml_pegawai_p;
            $Data['detail']['P']["color_code"]= "#ffb822";
            $Data['detail']['P']["color"]= "warning";
            
            $Data['total']=$row->jml_pegawai_l+$row->jml_pegawai_p;
        }
        return $Data;
    }
    public function get_dashboard_hr_kelompok_umur($kd_perusahaan,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $Period=$tahun.$bulan;
        $this->db->select("sum(
			case when TIMESTAMPDIFF(YEAR, pegawai.dob, CURDATE()) < 21 then 1
			else 0
			end
		 ) as '<21',
		 sum(
			case when TIMESTAMPDIFF(YEAR, pegawai.dob, CURDATE()) between 21 and 30 then 1
			else 0
			end
		 ) as '21-30',
		 sum(
			case when TIMESTAMPDIFF(YEAR, pegawai.dob, CURDATE()) between 31 and 40 then 1
			else 0
			end
		 ) as '31-40',
		 sum(
			case when TIMESTAMPDIFF(YEAR, pegawai.dob, CURDATE()) between 41 and 50 then 1
			else 0
			end
		 ) as '41-50',
		 sum(
			case when TIMESTAMPDIFF(YEAR, pegawai.dob, CURDATE()) between 51 and 60 then 1
			else 0
			end
		 ) as '51-60',
		 sum(
			case when TIMESTAMPDIFF(YEAR, pegawai.dob, CURDATE()) > 60 then 1
			else 0
			end
		 ) as '>60'");
        $this->db->from('pegawai');
        $this->db->group_start();
            $this->db->group_start();
                $this->db->where('pegawai.status',1);
                $this->db->where("date_format(pegawai.tgl_masuk,'%Y%m')<=",$Period);
            $this->db->group_end();
            $this->db->or_group_start();
                $this->db->where('pegawai.status',2);
                $this->db->group_start();
                    $this->db->where("date_format(pegawai.tgl_masuk,'%Y%m')<=",$Period);
                    $this->db->where("date_format(pegawai.tgl_keluar,'%Y%m')>=",$Period);
                $this->db->group_end();
            $this->db->group_end();
        $this->db->group_end();
//        $this->db->where("((pegawai.status = 1 and date_format(pegawai.tgl_masuk,'%Y%m')<='$Period') or 
//		(pegawai.status = 2 and (date_format(pegawai.tgl_masuk,'%Y%m')<='$Period' and '$Period'<=date_format(pegawai.tgl_keluar,'%Y%m'))))",NULL);
        $this->db->where('pegawai.kd_perusahaan',$kd_perusahaan);
        $query= $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data=array();
        //$Data["Color"]='';
        if($query->num_rows()>0){
            $row=$query->row_array();
            $Data['<21']["label"]= "<21";
            $Data['<21']["value"]= $row["<21"];
            $Data['<21']["color_code"]= "#00c5dc";
            $Data['<21']["color"]= "accent";
            
            $Data['21-30']["label"]= "21-30";
            $Data['21-30']["value"]= $row["21-30"];
            $Data['21-30']["color_code"]= "#5867dd";
            $Data['21-30']["color"]= "primary";
            
            $Data['31-40']["label"]= "31-40";
            $Data['31-40']["value"]= $row["31-40"];
            $Data['31-40']["color_code"]= "#34bfa3";
            $Data['31-40']["color"]= "success";
            
            $Data['41-50']["label"]= "41-50";
            $Data['41-50']["value"]= $row["41-50"];
            $Data['41-50']["color_code"]= "#36a3f7";
            $Data['41-50']["color"]= "info";
            
            $Data['51-60']["label"]= "51-60";
            $Data['51-60']["value"]= $row["51-60"];
            $Data['51-60']["color_code"]= "#ffb822";
            $Data['51-60']["color"]= "warning";
            
            $Data['>60']["label"]= ">60";
            $Data['>60']["value"]= $row[">60"];
            $Data['>60']["color_code"]= "#f4516c";
            $Data['>60']["color"]= "danger";
        }
        return $Data;
    }
    public function get_dashboard_hr_jml_peg_dept($kd_perusahaan,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        if($bulan==""){
            $bulan=date("m");
        }
        $Period=$tahun.$bulan;
        $this->db->select("count(pegawai.nip) as jml_peg, pegawai.kd_departemen, departemen.nm_departemen");
        $this->db->from('pegawai');
        $this->db->join("departemen","pegawai.kd_departemen = departemen.kd_departemen","LEFT");
        $this->db->group_start();
            $this->db->group_start();
                $this->db->where('pegawai.status',1);
                $this->db->where("date_format(pegawai.tgl_masuk,'%Y%m')<=",$Period);
            $this->db->group_end();
            $this->db->or_group_start();
                $this->db->where('pegawai.status',2);
                $this->db->group_start();
                    $this->db->where("date_format(pegawai.tgl_masuk,'%Y%m')<=",$Period);
                    $this->db->where("date_format(pegawai.tgl_keluar,'%Y%m')>=",$Period);
                $this->db->group_end();
            $this->db->group_end();
        $this->db->group_end();
//        $this->db->where("((pegawai.status = 1 and date_format(pegawai.tgl_masuk,'%Y%m')<='$Period') or 
//		(pegawai.status = 2 and (date_format(pegawai.tgl_masuk,'%Y%m')<='$Period' and '$Period'<=date_format(pegawai.tgl_keluar,'%Y%m'))))",NULL);
        $this->db->where('pegawai.kd_perusahaan',$kd_perusahaan);
        $this->db->group_by("pegawai.kd_departemen, departemen.nm_departemen");
        $query= $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data=array();
        //$Data["Color"]='';
        $no=1;
        foreach ($query->result() as $row){
            $Data[$no]["label"]= $row->nm_departemen;
            $Data[$no]["value"]= $row->jml_peg;
            $Data[$no]["color_code"]= $this->list_warna($no);
            
            $no++;
        }
        return $Data;
    }
    public function get_dashboard_hr_jml_peg_period($kd_perusahaan,$tahun,$bulan=""){
        if($tahun==""){
            $tahun=date("Y");
        }
        $thnSebelumnya=$tahun-1;
        if($bulan==""){
            $bulan=date("m");
        }
        $Period1=$thnSebelumnya."-".$bulan."-".$bulan;
        $Period2=$tahun."-".$bulan."-".$bulan;
        $sql="select tbl_data.bln as period,
                            count(tbl_data.nip) as jml_pegawai,
                            sum(if(tbl_data.jenis_kelamin='L',1,0)) as jml_l,
                            sum(if(tbl_data.jenis_kelamin='P',1,0)) as jml_p
            from(
            select pegawai.nip, pegawai.nama, pegawai.jenis_kelamin, pegawai.tgl_masuk, pegawai.tgl_keluar,data_bln.n,data_bln.bln
            from pegawai,
            (
                    select date_format(data_tgl.tgl,'%Y%m') n, date_format(data_tgl.tgl,'%Y-%m') as bln
                    from(
                    select ? as tgl,0 as jml
                    union
                    select date_add( ? , interval tbl_bln.m MONTH) as tgl, tbl_bln.m
                            from(
                                    select @rownum:=@rownum+1 as m from
                                    (select 1 union select 2 union select 3) t1,
                                    (select 1 union select 2 ) t2,
                                    (select 1 union select 2 ) t3,
                                    (select @rownum:=0) t0
                            )tbl_bln
                    )data_tgl
            )data_bln
            where ((pegawai.status = 1 and date_format(pegawai.tgl_masuk,'%Y%m')<=data_bln.n) or 
                            (pegawai.status = 2 and (date_format(pegawai.tgl_masuk,'%Y%m')<=data_bln.n and data_bln.n<=date_format(pegawai.tgl_keluar,'%Y%m'))))
                            and pegawai.kd_perusahaan = ?
            )tbl_data
            group by tbl_data.bln";
        $bind=[$Period1,$Period1,$kd_perusahaan];
        $query= $this->db->query($sql,$bind);
//        echo $this->db->last_query();
//        die();
        $Data=array();
        //$Data["Color"]='';
        $no=1;
        foreach ($query->result() as $row){
            $period= explode("-",$row->period);
            $Data['bulan'][$period[0].$period[1]]= getNamaBulanMin($period[1])." ".substr($period[0],2);
            $Data['legend']['L']= 'M';
            $Data['legend']['P']= 'F';
            $Data['color']['L']= "#00c5dc";
            $Data['color']['P']= "#ffb822";
            $Data['value']['L'][$period[0].$period[1]]= $row->jml_l;
            $Data['value']['P'][$period[0].$period[1]]= $row->jml_p;
            
        }
        return $Data;
    }
    public function get_dashboard_hr_turn_over_period($kd_perusahaan,$tahun,$bulan=""){
        if($tahun==""){
            $tahun=date("Y");
        }
        $thnSebelumnya=$tahun-1;
        if($bulan==""){
            $bulan=date("m");
        }
        $PeriodTglAwal=$thnSebelumnya."-".$bulan."-".$bulan;
        $Period1=$thnSebelumnya.$bulan;
        $Period2=$tahun.$bulan;
        $sql="select tbl_bln.bln as period, ifnull(peg_msk.jml_msk,0) as jml_msk, ifnull(peg_kel.jml_keluar,0) as jml_keluar
                from (
                        select date_format(data_tgl.tgl,'%Y%m') n, date_format(data_tgl.tgl,'%Y-%m') as bln
                from(
                        select ? as tgl,0 as jml
                        union
                        select date_add( ? , interval tbl_bln.m MONTH) as tgl, tbl_bln.m
                                from(
                                        select @rownum:=@rownum+1 as m from
                                        (select 1 union select 2 union select 3) t1,
                                        (select 1 union select 2 ) t2,
                                        (select 1 union select 2 ) t3,
                                        (select @rownum:=0) t0
                                )tbl_bln
                        )data_tgl
                )tbl_bln LEFT JOIN (
                        select date_format(pegawai.tgl_masuk,'%Y%m') as bln, count(pegawai.nip) as jml_msk
                        from pegawai
                        where pegawai.kd_perusahaan = ? and date_format(pegawai.tgl_masuk,'%Y%m') between ? and ? 
                        group by date_format(pegawai.tgl_masuk,'%Y%m')
                )peg_msk ON tbl_bln.n=peg_msk.bln
                LEFT JOIN (
                        select date_format(pegawai.tgl_keluar,'%Y%m') as bln, count(pegawai.nip) as jml_keluar
                        from pegawai
                        where pegawai.kd_perusahaan = ? and date_format(pegawai.tgl_keluar,'%Y%m') between ? and ? 
                        group by date_format(pegawai.tgl_keluar,'%Y%m')
                )peg_kel ON tbl_bln.n=peg_kel.bln";
        $bind=[$PeriodTglAwal,$PeriodTglAwal,$kd_perusahaan,$Period1,$Period2,$kd_perusahaan,$Period1,$Period2];
        $query= $this->db->query($sql,$bind);
//        echo $this->db->last_query();
//        die();
        
        $Data=array();
        //$Data["Color"]='';
        $no=1;
        foreach ($query->result() as $row){
            $period= explode("-",$row->period);
            $Data['bulan'][$period[0].$period[1]]= getNamaBulanMin($period[1])." ".substr($period[0],2);
            $Data['legend']['H']= 'Employees Hired';
            $Data['legend']['L']= 'Employees Left';
            $Data['color']['H']= "#00c5dc";
            $Data['color']['L']= "#ffb822";
            $Data['value']['H'][$period[0].$period[1]]= $row->jml_msk;
            $Data['value']['L'][$period[0].$period[1]]= $row->jml_keluar*(-1);
            
        }
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

    public function get_dashboard_jml_hire_left_by_year($kd_perusahaan,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $sql="SELECT * 
                FROM (
                    select count(pegawai.nip) as jml_msk
                    from pegawai
                    where pegawai.kd_perusahaan = ? and YEAR(pegawai.tgl_masuk) = ? 
                )TblJmlMasuk,
                (
                    select count(pegawai.nip) as jml_keluar
                    from pegawai
                    where pegawai.kd_perusahaan = ? and YEAR(pegawai.tgl_keluar) = ? 
                )tblJmlKeluar";
        $bind=[$kd_perusahaan,$tahun,$kd_perusahaan,$tahun];
        $query= $this->db->query($sql,$bind);
//        echo $this->db->last_query();
//        die();
        $Data=array();
        //$Data["Color"]='';
        $no=1;
        foreach ($query->result() as $row){
            $Data["hire"]= $row->jml_msk;
            $Data["left"]= $row->jml_keluar;
            
            $no++;
        }
        return $Data;
    }
    public function get_dashboard_kpi_peg_detail($kd_perusahaan,$tahun,$bulan){
        if($tahun==""){
            $tahun=date("Y");
        }
        $thnSebelumnya=$tahun-1;
        if($bulan==""){
            $bulan=date("m");
        }
        $this->db->select("appraisal.bulan,
                        appraisal.tahun,
                        appraisal.nip,
                        pegawai.nama,
                        appraisal.point");
        $this->db->from('appraisal');
        $this->db->join('pegawai',"appraisal.nip = pegawai.nip","LEFT ");
        $this->db->join('departemen',"departemen.kd_departemen = appraisal.kd_departemen","LEFT ");
        $this->db->where('appraisal.bulan',$bulan);
        $this->db->where('appraisal.tahun',$tahun);
        $this->db->where('departemen.kd_perusahaan',$kd_perusahaan);
        $this->db->order_by('appraisal.point ASC');
        $query= $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data=array();
        //$Data["Color"]='';
        $no=0;
        foreach ($query->result() as $row){
            $Data['category'][$no]= $row->nama;
            $Data['value'][$no]= $row->point;
            $no++;
        }
        // for($i=0;$i<=20;$i++){
        //     $Data['category'][$i]= 'Margono';
        //     $Data['value'][$i]= '3.50';
        // }
        return $Data;
    }
    public function get_dashboard_kpi_peg_detail_yearly($kd_perusahaan,$tahun){
        if($tahun==""){
            $tahun=date("Y");
        }
        $this->db->select("appraisal.tahun,
                        appraisal.nip,
                        pegawai.nama,
                        avg(appraisal.point) as point");
        $this->db->from('appraisal');
        $this->db->join('pegawai',"appraisal.nip = pegawai.nip","LEFT ");
        $this->db->join('departemen',"departemen.kd_departemen = appraisal.kd_departemen","LEFT ");
        $this->db->where('appraisal.tahun',$tahun);
        $this->db->where('departemen.kd_perusahaan',$kd_perusahaan);
        $this->db->group_by('appraisal.tahun,
                            appraisal.nip,
                            pegawai.nama');
        $this->db->order_by('appraisal.point ASC');
        $query= $this->db->get();
//        echo $this->db->last_query();
//        die();
        $Data=array();
        //$Data["Color"]='';
        $no=0;
        foreach ($query->result() as $row){
            $Data['category'][$no]= $row->nama;
            $Data['value'][$no]= $row->point;
            $no++;
        }
        // for($i=0;$i<=20;$i++){
        //     $Data['category'][$i]= 'Margono';
        //     $Data['value'][$i]= '3.50';
        // }
        return $Data;
    }
}

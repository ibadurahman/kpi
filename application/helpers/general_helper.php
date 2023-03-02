<?php
defined('BASEPATH') OR exit('No direct script access allowed');


if ( ! function_exists('get_value_array'))
{
	/**
	 * loop data dari database
	 *
	 * Creates the opening portion of the form.
	 *
	 * @param	string	Data dari database
	 * @param	string	value untuk key array
	 * @param	string	value untuk value array
         * @param	bool	status untuk nilai awal kosong bila nlainya true
         * @param	bool	status untuk pilihan all data    bila nlainya true
	 * @return	array
	 */
	function get_value_array($Data, $Key = '', $Value = '',$EmptyVal=FALSE,$AddLast='', $AllVal=FALSE)
	{
            $return=array();
            if($EmptyVal==TRUE){
                $return[''] = '';
            }
            if($AllVal==TRUE){
                $return['ALL'] = 'ALL';
            }
            if(isset($Data)){
                foreach($Data->result_array() as $row){
                    $Caption='';
                    // ini berfungsi untuk memunculkan value lebih dari satu.. contoh hasil key => 001|A100|Test
                    if(is_array($Value)){
                        $ListValue=array();
                        foreach ($Value as $x){
                            if($row[$x]!=NULL and $row[$x]!="" ){
                                $ListValue[]=$row[$x];
                            }
                        }
                        $ValueAll=  implode(" - ", $ListValue);
                        $Caption = $ValueAll;
                    }else if($Value!=""){
                        if($row[$Value]!=NULL and $row[$Value]!="" ){
                            $Caption = $row[$Value];
                        }
                    }
                    // ini berfungsi untuk memunculkan key lebih dari satu.. contoh hasil key => 001|A100|Test
                    if(is_array($Key)){
                        $ListKey=array();
                        foreach ($Key as $z){
                            if($row[$z]!=NULL and $row[$z]!="" ){
                                $ListKey[]=$row[$z];
                            }
                        }
                        $KeyAll=  implode("|", $ListKey);
                        $return[$KeyAll] = $Caption;
                    }else if($Key!=""){
                        if($row[$Key]!=NULL and $row[$Key]!="" ){
                            $return[$row[$Key]] = $Caption;
                        }
                    }else if($Key=="" and $Caption!=""){
                       if($Caption!=NULL and $Caption!="" ){
                            $return[] = $Caption;
                        }
                    }
                }
            }
            if(is_array($AddLast)){
                foreach ($AddLast as $k=>$v){
                    $return[$k] = $v;
                }
            }
            return $return;
	}
}
if ( ! function_exists('get_value_option_select'))
{
	
        function get_value_option_select($Data, $Key, $Value,$EmptyVal=FALSE, $AddLast='', $AllVal=FALSE)
	{
            $return=array();
            if($EmptyVal==TRUE){
                echo "<option value=''></option>\n";
            }
            if($AllVal==TRUE){
                $return['ALL'] = 'ALL';
            }
            if(isset($Data)){
                foreach($Data->result_array() as $row){
                    $Caption='';
                    // ini berfungsi untuk memunculkan value lebih dari satu.. contoh hasil key => 001|A100|Test
                    if(is_array($Value)){
                        $ListValue=array();
                        foreach ($Value as $x){
                            if($row[$x]!=NULL and $row[$x]!="" ){
                                $ListValue[]=$row[$x];
                            }
                        }
                        $ValueAll=  implode(" ", $ListValue);
                        $Caption = $ValueAll;
                    }else if($Value!=""){
                        if($row[$Value]!=NULL and $row[$Value]!="" ){
                            $Caption = $row[$Value];
                        }
                    }
                    // ini berfungsi untuk memunculkan key lebih dari satu.. contoh hasil key => 001|A100|Test
                    if(is_array($Key)){
                        $ListKey=array();
                        foreach ($Key as $z){
                            if($row[$z]!=NULL and $row[$z]!="" ){
                                $ListKey[]=$row[$z];
                            }
                        }
                        $KeyAll=  implode("|", $ListKey);
//                        $return[$KeyAll] = $row[$Value];
                        echo "<option value='".$KeyAll."'>".$Caption."</option>\n";
                        
                    }else if($Key!=""){
                        if($row[$Key]!=NULL and $row[$Key]!="" ){
//                            $return[$row[$Key]] = $row[$Value];
                            echo "<option value='".$row[$Key]."'>".$Caption."</option>\n";
                        }
                    }
                }
            }
            if(is_array($AddLast)){
                foreach ($AddLast as $k=>$v){
                    echo "<option value='".$k."'>".$v."</option>\n";
                }
            }
	}
}
if ( ! function_exists('find_key_value'))
{
	
    function find_key_value($array, $key, $val)
    {
        foreach ($array as $item)
        {
           if (is_array($item))
           {
               find_key_value($item, $key, $val);
           }

            if (isset($item[$key]) && $item[$key] == $val) return true;
        }

        return false;
    }
}
if ( ! function_exists('Check_ArrayUnique'))
{
	
    function Check_ArrayUnique($arr){
        
        if(is_array($arr)){
            if(count(array_unique($arr))<count($arr))
            {
                return false;
            }
            else
            {
                return true;
            }
        }else{
            return true;
        }


    }
}
if ( ! function_exists('create_checkbox_list'))
{
	
    function create_checkbox_list($CekAkses,$NoUrut,$Value){
        $Data=  $CekAkses;
        $Checkbox='';
        if($Data['StatusCreate']==1){
            $Checkbox="<input name='checkData[]' value='".$Value."' id='checkData".$NoUrut."' class='CheckDataAll' type='checkbox'>";
        }
        return $Checkbox;
    }
}
if ( ! function_exists('create_button_list'))
{
	
    function create_button_list($CekAkses,$URIView='',$URIEdit='',$URIDelete=''){
        $Akses=  $CekAkses;
  
        //$Link[]="<div class='btn-group' role='group' aria-label='button action'>";
        $Link=array();
        if($URIView!=""){
            $Link[]=create_button('tag tag-primary round', 'fa fa-file-text-o', $URIView, 1,'View');
        }
        if($URIEdit!=""){
            $Link[]=create_button('tag tag-success round edit-data', 'fa fa-pencil-square-o', $URIEdit, $Akses['Modify'],'Edit');
        }
        if($URIDelete!=""){
            $Link[]= create_button_dataId('tag tag-danger round delete-data', 'fa fa-trash-o', $URIDelete, $Akses['Create'],'Delete');
        }
        return implode(" ", $Link);
    }
}
if ( ! function_exists('create_button'))
{
	
    function create_button($ClassButton,$Icon,$Uri,$CekAkses,$Title, $atribute=array()){
        $atr="";
        foreach($atribute as $key=>$value){
            $atr .=$key."='".$value."' ";
        }
        
        if($CekAkses==1){
            $Button="<a class='".$ClassButton."' href='". site_url($Uri)."' title='". $Title."' ".$atr."><i class='".$Icon."' ></i></a>";
        }else{
            $Button="";
        }
        //$Link[]="</div>";
        return $Button;
    }
    function create_button_text($ClassButton,$Uri,$CekAkses,$Title){
        
        if($CekAkses==1){
            $Button="<a class='".$ClassButton."' href='". site_url($Uri)."' title='". $Title."'>".$Title."</a>";
        }else{
            $Button="";
        }
        //$Link[]="</div>";
        return $Button;
    }
}
if ( ! function_exists('create_button_dataId'))
{
	
    function create_button_dataId($ClassButton,$Icon,$Id,$CekAkses,$Title, $attribute=array()){
        $addAtribute="";
        foreach($attribute as $key=>$val)
        {
            $addAtribute .=$key."='".$val."' ";
        }
        if($CekAkses==1){
            $Button="<a class='".$ClassButton."' href='#' data-id='". $Id."' title='". $Title."' ".$addAtribute."><i class='".$Icon."'></i></a>";
        }else{
            $Button="";
        }
        //$Link[]="</div>";
        return $Button;
    }
}
if ( ! function_exists('convert_date'))
{
	
	function convert_date($date=NULL)
	{
                if(trim($date) == "" or trim($date) == NULL or trim($date)=="0000-00-00" or trim($date)=="00-00-0000") return "";
		else if(trim($date) == "- -") return "";
		else if(trim($date) == "--") return "";
		$a = explode("-",$date);
                if($a[0]=='1900' or $a[2]=='1900')return "";
		$newdate =  $a[2]."-".$a[1]."-".$a[0];
		return $newdate;
	}
}
if ( ! function_exists('convert_datetime'))
{
	
	function convert_datetime($date=NULL)
	{
                if(trim($date) == "" or trim($date) == NULL) return "";
		
		$a = explode(" ",$date);
                $a[0]=  convert_date($a[0]);
                $newdate=  implode(" ", $a);
		return $newdate;
	}
}
if ( ! function_exists('convert_date_name'))
{
	
	function convert_date_name($date=NULL)
	{
                if(trim($date) == "" or trim($date) == NULL) return "";
		else if(trim($date) == "- -") return "";
		else if(trim($date) == "--") return "";
		$a = explode("-",$date);
                if($a[0]=='1900' or $a[2]=='1900')return "";
                $NamaBulan=  getNamaBulan($a[1]);
                if(strlen($a[0])>2){
                    $newdate =  $a[2]." ".$NamaBulan." ".$a[0];
                }else{
                    $newdate =  $a[0]." ".$NamaBulan." ".$a[2];
                }
		return $newdate;
	}
}
if ( ! function_exists('money_to_number_id'))
{
	
	function money_to_number_id($money)
	{
            $MoneyBaru=preg_replace("/[^0-9-,]/", "", $money);
            $MoneyBaru2=preg_replace("/[,]/", ".", $MoneyBaru);
            return $MoneyBaru2;
	}
}
if ( ! function_exists('money_to_number'))
{
	
	function money_to_number($money)
	{
            $MoneyBaru=preg_replace("/[^0-9-.]/", "", $money);
            return $MoneyBaru;
	}
}
if ( ! function_exists('number_to_money'))
{
	
	function number_to_money($number)
	{
            if($number!=""){
                $numberBaru=number_format($number,0,",",".");
            }else{
                $numberBaru=0;
            }
            return $numberBaru;
	}
}
if ( ! function_exists('line_with_arguments'))
{
    function line_with_arguments($line, $swap)
    {
        return str_replace('%s', $swap, $line);
    }
}
if ( ! function_exists('encrypt_url'))
{
	
	function encrypt_url($String)
	{
            
            $En=  base64_encode($String);
            $EnUrl=  urlencode($En);
            return $EnUrl;
	}
}
if ( ! function_exists('decrypt_url'))
{
	
	function decrypt_url($String)
	{
            $DeUrl=  urldecode($String);
            $De=  base64_decode($DeUrl);
            return $De;
	}
}
if ( ! function_exists('full_path'))
{
	
	function full_path($Path)
	{
            // First step: Get full path
                $cur_file=str_replace('\\','/',$Path);
                // Second step: Remove the root path
                $cur_file=preg_replace('/(.*?)\/var\/public_html/','',$cur_file);
            return $cur_file;
	}
}

if ( ! function_exists('ListJenisKelamin'))
{
	
	function ListJenisKelamin(){
            $DataTipe['']='';
            $DataTipe['L']='Male';
            $DataTipe['P']='Female';

            return $DataTipe;
        }
}
if ( ! function_exists('ListStatusNikah'))
{
	
	function ListStatusNikah(){
            $DataTipe['']='';     
	    $DataTipe['0']='Others';
            $DataTipe['1']='Single';
            $DataTipe['2']='Nikah';

            return $DataTipe;
        }
}
if ( ! function_exists('ListStatusAktif'))
{
	
	function ListStatusAktif(){
            $DataTipe['']='';
            $DataTipe['0']='Inactive';
            $DataTipe['1']='Active';

            return $DataTipe;
        }
}
if ( ! function_exists('ListTahun'))
{
	
	function ListTahun(){
            $begin_year = date("Y")-50;
            $curr_year = date("Y")+10;
            $Tahun['']='';
            while($begin_year!=$curr_year){
                $Tahun[$begin_year]=$begin_year;
                $begin_year++;
            }

            return $Tahun;
        }
}
if ( ! function_exists('ListTahunBerjalan'))
{
	
	function ListTahunBerjalan($Thn=""){
            $ThnAwalApps=($Thn!="")?$Thn:date("Y");
            $begin_year = $ThnAwalApps;
            $curr_year = date("Y")+2;
            $Tahun['']='';
            if($begin_year!=$curr_year)
            {
                while($begin_year!=$curr_year){
                    $Tahun[$begin_year]=$begin_year;
                    $begin_year++;
                }
            }else{
                $Tahun[$begin_year]=$begin_year;
            }
            return $Tahun;
        }
}
if ( ! function_exists('ListBulan'))
{
	
	function ListBulan(){
            $DataTipe['']='';
            $DataTipe['01']='January';
            $DataTipe['02']='February';
            $DataTipe['03']='March';
            $DataTipe['04']='April';
            $DataTipe['05']='May';
            $DataTipe['06']='June';
            $DataTipe['07']='July';
            $DataTipe['08']='August';
            $DataTipe['09']='September';
            $DataTipe['10']='October';
            $DataTipe['11']='November';
            $DataTipe['12']='December';

            return $DataTipe;
        }
}
if ( ! function_exists('getNamaBulan'))
{
	
	function getNamaBulan($Bulan){
		switch ($Bulan){
                        case "1" : $Bulan2 = "January";break;
			case "01" : $Bulan2 = "January";break;
			case "2" : $Bulan2 = "February";break;
			case "02" : $Bulan2 = "February";break;
			case "3" : $Bulan2 = "March";break;
			case "03" : $Bulan2 = "March";break;
			case "4" : $Bulan2 = "April";break;
			case "04" : $Bulan2 = "April";break;
			case "5" : $Bulan2 = "May";break;
			case "05" : $Bulan2 = "May";break;
			case "6" : $Bulan2 = "June";break;
			case "06" : $Bulan2 = "June";break;
			case "7" : $Bulan2 = "July";break;
			case "07" : $Bulan2 = "July";break;
			case "8" : $Bulan2 = "August";break;
			case "08" : $Bulan2 = "August";break;
			case "9" : $Bulan2 = "September";break;
			case "09" : $Bulan2 = "September";break;
			case "10" : $Bulan2 = "October";break;
			case "11" : $Bulan2 = "November";break;
			case "12" : $Bulan2 = "December";break;
                        default :$Bulan2 = "";break;
	}
            return $Bulan2;
        }
}
if ( ! function_exists('getNamaBulanMin'))
{
	
	function getNamaBulanMin($Bulan){
		switch ($Bulan){
                        case "1" : $Bulan2 = "Jan";break;
			case "01" : $Bulan2 = "Jan";break;
			case "2" : $Bulan2 = "Feb";break;
			case "02" : $Bulan2 = "Feb";break;
			case "3" : $Bulan2 = "Mar";break;
			case "03" : $Bulan2 = "Mar";break;
			case "4" : $Bulan2 = "Apr";break;
			case "04" : $Bulan2 = "Apr";break;
			case "5" : $Bulan2 = "May";break;
			case "05" : $Bulan2 = "May";break;
			case "6" : $Bulan2 = "Jun";break;
			case "06" : $Bulan2 = "Jun";break;
			case "7" : $Bulan2 = "Jul";break;
			case "07" : $Bulan2 = "Jul";break;
			case "8" : $Bulan2 = "Aug";break;
			case "08" : $Bulan2 = "Aug";break;
			case "9" : $Bulan2 = "Sep";break;
			case "09" : $Bulan2 = "Sep";break;
			case "10" : $Bulan2 = "Oct";break;
			case "11" : $Bulan2 = "Nov";break;
			case "12" : $Bulan2 = "Dec";break;
                        default :$Bulan2 = "";break;
	}
            return $Bulan2;
        }
}
if ( ! function_exists('getAlertError'))
{
	
	function getAlertError($msg){
		$Alert='<div class="alert alert-danger alert-dismissible fade show" role="alert">'.$msg.'</div>';
            return $Alert;
        }
}
if ( ! function_exists('in_array_r'))
{
    function in_array_r($item , $array){
        return preg_match('/"'.preg_quote($item, '/').'"/i' , json_encode($array));
    }
}



if ( ! function_exists('formatTimeString'))
{
    function formatTimeString($timeStamp) {
        $str_time = date("Y-m-d H:i:sP", $timeStamp);
        $time = strtotime($str_time);
        $d = new DateTime($str_time);

        $weekDays = ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', ' May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];

        if ($time > strtotime('-2 minutes')) {
          return 'Just now';
        } elseif ($time > strtotime('-59 minutes')) {
          $min_diff = floor((strtotime('now') - $time) / 60);
          return $min_diff . ' min' . (($min_diff != 1) ? "s" : "") . ' ago';
        } elseif ($time > strtotime('-23 hours')) {
          $hour_diff = floor((strtotime('now') - $time) / (60 * 60));
          return $hour_diff . ' hour' . (($hour_diff != 1) ? "s" : "") . ' ago';
        } elseif ($time > strtotime('today')) {
          return $d->format('G:i');
        } elseif ($time > strtotime('yesterday')) {
          return 'Yesterday at ' . $d->format('G:i');
        } elseif ($time > strtotime('this week')) {
          return $weekDays[$d->format('N') - 1] . ' at ' . $d->format('G:i');
        } else {
          return $d->format('j') . ' ' . $months[$d->format('n') - 1] .
          (($d->format('Y') != date("Y")) ? $d->format(' Y') : "") .
          ' at ' . $d->format('G:i');
        }
    }
}

if ( ! function_exists('ListPeriod'))
{
	
	function ListPeriod(){
            $DataTipe['']='';
            $DataTipe['m']='Monthly';
            $DataTipe['y']='Yearly';

            return $DataTipe;
        }
}
if ( ! function_exists('split_daterange'))
{
	/*
         * param date => data range tanggal
         * StatInputDB => status return value yg akan diterima, 1 = utk perubahan format tanggal, 0= Format tanggal tidak berubah
         * return array
         */
	function split_daterange($date=NULL,$StatInputDB = 1)
	{
                if(trim($date) == "" or trim($date) == NULL) return "";
		$data=array();
		$a = explode(" - ",$date);
                $date1= str_replace('/','-',$a[0]);
                $date2=  str_replace('/','-',$a[1]);
                if($StatInputDB==1){
                    $data[0]=convert_date($date1);
                    $data[1]=convert_date($date2);
                }else{
                    $data[0]=$date1;
                    $data[1]=$date2;
                }
		return $data;
	}
}
if ( ! function_exists('implode_daterange'))
{
	/*
         * function untuk menyatukan data range bila data tanggal terpisah
         * param date1 => data tanggal awal range
         * param date2 => data tanggal akhir range
         * $StatConvert => status return value yg akan diterima, 1 = utk perubahan format tanggal, 0= Format tanggal tidak berubah
         * return string
         */
	function implode_daterange($date1=NULL,$date2=NULL,$StatConvert = 1)
	{
                if(trim($date1) == "" or trim($date1) == NULL) return "";
                if(trim($date2) == "" or trim($date2) == NULL) return "";
		$data=array();
                if($StatConvert==1){
                    $date1=convert_date($date1);
                    $date2=convert_date($date2);
                }
                $data[0]= str_replace('-','/',$date1);
                $data[1]=  str_replace('-','/',$date2);
		return implode(" - ", $data);
	}
}
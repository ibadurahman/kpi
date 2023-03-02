<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('ListPeriodAll'))
{
	
	function ListPeriodAll(){
            $DataTipe['']='';
            $DataTipe['m']='Monthly';
            $DataTipe['y']='Yearly';
            //$DataTipe['q']='quarterly';
            $DataTipe['ytd']='year to date';

            return $DataTipe;
        }
}
if ( ! function_exists('ListType'))
{
	
	function ListType(){
            $DataTipe['']='';
            $DataTipe['min']='min';
            $DataTipe['max']='max';

            return $DataTipe;
        }
}
if ( ! function_exists('ListUnit'))
{
	
	function ListUnit(){
            $DataTipe['']='';
            $DataTipe['p']='Persentage';
            $DataTipe['c']='Currency';
            $DataTipe['n']='Number';
            $DataTipe['d']='Day';

            return $DataTipe;
        }
}
if ( ! function_exists('ListUnitSimbol'))
{
	
	function ListUnitSimbol(){
            $DataTipe['']='';
            $DataTipe['p']='%';
            $DataTipe['c']='';
            $DataTipe['n']='';
            $DataTipe['d']='';

            return $DataTipe;
        }
}
if ( ! function_exists('ListAggregation'))
{
	
	function ListAggregation(){
            $DataTipe['']='';
            $DataTipe['SUM']='SUM';
            $DataTipe['AVG']='AVG';

            return $DataTipe;
        }
}
if ( ! function_exists('ListStatCalculate'))
{
	
	function ListStatCalculate(){
            $DataTipe['']='';
            $DataTipe['0']='Value';
            $DataTipe['1']='Percentage';

            return $DataTipe;
        }
}
if ( ! function_exists('ListOperator'))
{
	
	function ListOperator(){
            $DataTipe['']='';
            $DataTipe['1']='<';
            $DataTipe['2']='<=';
            $DataTipe['3']='=';
            $DataTipe['4']='>=';
            $DataTipe['5']='>';

            return $DataTipe;
        }
}

if ( ! function_exists('CekOperator'))
{
	
	function CekOperator($tipeOpr,$result,$val,$score){
            $hasil=0;
            if($tipeOpr==1 and $result < $val){
                $hasil=$score;
            }else if ($tipeOpr==2 and $result <= $val){
                $hasil=$score;
            }else if ($tipeOpr==3 and $result == $val){
                $hasil=$score;
            }else if ($tipeOpr==4 and $result >= $val){
                $hasil=$score;
            }else if ($tipeOpr==5 and $result > $val){
                $hasil=$score;
            }
            // echo $tipeOpr."--".$result."--".$val."--".$score."--".$hasil;
            return $hasil;
        }
}
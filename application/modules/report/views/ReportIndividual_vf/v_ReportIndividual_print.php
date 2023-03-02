<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$DataRow=$DataAppraisal->row();
?>
<table width="680" border="1" cellpadding="5"  >
    <thead>
            <tr>
                <th height="20" colspan="2" style="background-color: #00c5dc; color: white;"><?php echo $this->lang->line('input_section1');?></th>
            </tr>
    </thead>
    <tbody>
        <tr>
            <td width="200"> <?php echo $this->lang->line("bulan");?> </td>
            <td width="480"><?php echo getNamaBulan($DataRow->bulan)." ".$DataRow->tahun;?></td>
        </tr>
        <tr>
            <td><?php echo $this->lang->line("nama");?></td>
            <td><?php echo ucwords(strtolower($DataRow->nama));?></td>
        </tr>
        <tr>
            <td><?php echo $this->lang->line("kd_departemen");?></td>
            <td><?php echo $DataRow->nm_departemen;?></td>
        </tr>
        <tr>
            <td><?php echo $this->lang->line("kd_jabatan");?></td>
            <td><?php echo $DataRow->nm_jabatan;?></td>
        </tr>
        <tr>
            <td><?php echo $this->lang->line("report_to");?></td>
            <td><?php echo ucwords(strtolower($DataRow->nm_atasan));?></td>
        </tr>
        <tr>
            <td><?php echo $this->lang->line("remark");?></td>
            <td><?php echo $DataRow->remark;?></td>
        </tr>
    </tbody>
</table>
<br/>
<br/>
<table border="1" width="680" cellpadding="5">
    <thead>
            <tr style="background-color: #00c5dc; color: white;">
                <th width="280"><?php echo $this->lang->line("kd_measurement");?></th>
                <th width="100"><?php echo $this->lang->line("kd_bd");?></th>
                <th width="100"><?php echo $this->lang->line("score_kpi2");?></th>
                <th width="100"><?php echo $this->lang->line("weightage_kpi2");?></th>
                <th width="100"><?php echo $this->lang->line("score");?></th>
            </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        $TotalScore=0;
        foreach($DataAppraisal->result() as $row)
        {
        ?>
        <tr>
            <td width="280" >
                <?php echo $row->nm_measurement;?>
            </td>	
            <td width="100"  align="center">
                <?php echo $row->kd_bds;?>
            </td>			
            <td  width="100"  align="right">
                <?php 
                $ScoreAwal= $row->point_result;
                echo $ScoreAwal;
                ?>
            </td>
            <td  width="100" align="right">
                <?php 
                $bobotKPI= $row->weightage_kpi*100;
                echo $bobotKPI."%"
                ?>
            </td>
            <td  width="100" align="right">
                <?php 
                $Score= number_format($row->score_kpi,2);
                echo $Score;
                ?>
            </td>
        </tr>
        <?php
                $TotalScore=$TotalScore+$Score;
                $i++;
            }
        ?>
        <tr>
            <td width="580" align="right" colspan="4" style="font-weight: bold"><?php echo $this->lang->line("score_total");?></td>
            <td width="100" align="right" style="font-weight: bold"><?php echo number_format($TotalScore,2);?></td>
        </tr>
    </tbody>
</table>
<br/>
<h4 class="m-form__heading-title"><?php echo $this->lang->line('detail_perhitungan'); ?></h4>
<hr/>
<?php
foreach($DataAppraisal->result() as $row)
{
?>
<br/>
<h5 class="m-form__heading-title"><?php echo $row->nm_measurement;?></h5>
<table border="1" cellpadding="5" width="680">
    <thead>
            <tr style="background-color: #00c5dc; color: white;">
                <th width="200" colspan="2" style="text-align: center;"><?php echo $this->lang->line("formula");?></th>
                <th width="140"><?php echo $this->lang->line("target");?></th>
                <th width="140"><?php echo $this->lang->line("actual");?></th>
                <th width="100"><?php echo $this->lang->line("targetvactual");?></th>
                <th width="100"><?php echo $this->lang->line("point_result");?></th>
            </tr>
    </thead>
    <tbody>
    <?php
    $formula=json_decode($row->formula,true);
    krsort($formula);
    $i=1;
    foreach($formula as $dataFormula){
        
    ?>
    <tr>
        <td width="100" align="center">
            <?php
                echo $dataFormula['score'];
            ?>
        </td>
        <td width="100" align="center">
            <?php
                $simbol=$ListOperator[$dataFormula['operator']];
                if($simbol=="<="){
                    //harus diberi sepasi, klo tidak akan error
                    $simbol="< =";
                }
                echo $simbol." ".$dataFormula['label'];
            
            ?>
        </td>
        <?php if($i==1){ ?>		
        <td width="140" align="right" rowspan="4">
            <?php echo $row->target_label;?>
        </td>
        <td width="140"  align="right" rowspan="4">
            <?php echo number_to_money($row->actual);?>
        </td>
        <td width="100"  align="right" rowspan="4">
            <?php 
                if($row->status_calculate == 1){
                    echo number_to_money($row->result)."%";
                }else{
                    echo number_to_money($row->result);
                }
                
            ?>
        </td>
        <td width="100"  align="right" rowspan="4">
            <?php echo $row->point_result;?>
        </td>
        <?php
        }
        ?>
    </tr>
    <?php
        $i++;
    }
    ?>
    </tbody>
</table>
<?php
    }
?>
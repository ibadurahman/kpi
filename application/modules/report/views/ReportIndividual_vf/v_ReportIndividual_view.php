<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$DataRow=$DataAppraisal->row();
?>
<div class="m-section__content " id="error_section_modal"></div>
<div class="m-form__section m-form__section--first data-print ">
<!--    <div class="m-form__heading">
            <h3 class="m-form__heading-title"><?php //echo $this->lang->line('nm_measurement'); ?></h3>
    </div>-->
    <div class="form-group m-form__group row">
        <div class="col-lg-12 m-form__group-sub  isi_input">
            <table class="table table-bordered table-hover m-table m-table--head-bg-accent">
                <thead>
                        <tr>
                                <th colspan="2"><?php echo $this->lang->line('input_section1');?></th>
                        </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $this->lang->line("bulan");?></td>
                        <td><?php echo getNamaBulan($DataRow->bulan)." ".$DataRow->tahun;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line("nama");?></td>
                        <td><?php echo $DataRow->nama;?></td>
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
                        <td><?php echo $DataRow->nm_atasan;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $this->lang->line("remark");?></td>
                        <td><?php echo $DataRow->remark;?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-12 m-form__group-sub  isi_input">
            <table class="table table-bordered table-hover m-table m-table--head-bg-accent">
                <thead>
                        <tr>
                            <th><?php echo $this->lang->line("kd_measurement");?></th>
                            <th><?php echo $this->lang->line("kd_bd");?></th>
                            <th><?php echo $this->lang->line("score_kpi2");?></th>
                            <th><?php echo $this->lang->line("weightage_kpi2");?></th>
                            <th><?php echo $this->lang->line("score");?></th>
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
                        <td width="400" >
                            <?php echo $row->nm_measurement;?>
                        </td>	
                        <td   align="center">
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
                        <td align="right" colspan="4" style="font-weight: bold"><?php echo $this->lang->line("score_total");?></td>
                        <td align="right" style="font-weight: bold"><?php echo number_format($TotalScore,2);?></td>
                    </tr>
<!--                    <tr>
                        <td align="right" colspan="4" style="font-weight: bold"><?php // echo $this->lang->line("result");?></td>
                        <td align="right" style="font-weight: bold">
                            <?php 
//                            $Result=round(($TotalScore/100)*4,2);
//                            if($Result>4){
//                                $Result=4.00;
//                                
//                            }
//                            echo $Result;
                            ?>
                        </td>
                    </tr>-->
                </tbody>
            </table>
        </div>
        
    </div>
    <div class="m-form__heading">
            <h4 class="m-form__heading-title"><?php echo $this->lang->line('detail_perhitungan'); ?></h4>
    </div>
    <hr/>
    <div class="form-group m-form__group row">
        <div class="col-lg-12 m-form__group-sub  isi_input">
        <?php
            foreach($DataAppraisal->result() as $row)
            {
        ?>
            <div class="m-form__heading">
                    <h5 class="m-form__heading-title"><?php echo $row->nm_measurement;?></h5>
            </div>
            <table class="table table-bordered table-hover m-table m-table--head-bg-primary">
                <thead>
                    <tr>
                        <th colspan="2" style="text-align: center;"><?php echo $this->lang->line("formula");?></th>
                        <th><?php echo $this->lang->line("target");?></th>
                        <th><?php echo $this->lang->line("actual");?></th>
                        <th><?php echo $this->lang->line("targetvactual");?></th>
                        <th><?php echo $this->lang->line("point_result");?></th>
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
                                echo $ListOperator[$dataFormula['operator']]." ".$dataFormula['label'];
                            
                            ?>
                        </td>
                        <?php if($i==1){ ?>		
                        <td width="200" align="right" rowspan="4">
                            <?php echo $row->target_label;?>
                        </td>
                        <td width="200"  align="right" rowspan="4">
                            <?php echo number_to_money($row->actual);?>
                        </td>
                        <td width="200"  align="right" rowspan="4">
                            <?php 
                                if($row->status_calculate == 1){
                                    echo number_to_money($row->result)."%";
                                }else{
                                    echo number_to_money($row->result);
                                }
                                
                            ?>
                        </td>
                        <td width="200"  align="right" rowspan="4">
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
        </div>
        
    </div>
</div>
<div class="printable"></div>
<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$DataRow=$DataKpiPegawai->row();
?>
<div class="m-section__content " id="error_section_modal"></div>
<div class="m-form__section m-form__section--first">
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
                        <td><?php echo getNamaBulan($DataBulan)." ".$DataTahun;?></td>
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
                </tbody>
            </table>
        </div>
        
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-12 m-form__group-sub  isi_input">
            <table class="table table-bordered table-hover m-table m-table--head-bg-accent">
                <thead>
                        <tr>
                            <th><?php echo $this->lang->line("kd_bd");?></th>
                            <th><?php echo $this->lang->line("kd_measurement");?></th>
                            <th><?php echo $this->lang->line("target");?></th>
                            <th><?php echo $this->lang->line("actual");?></th>
                        </tr>
                </thead>
                <tbody>
                    <?php
                    $i=1;
                    foreach($DataKpiPegawai->result() as $row)
                    {
                        // $persenKPIDepartemen=$ListKPIDepartemen[$row->kd_measurement];
                        $persen_kpi=round(($row->weightage_kpi/$row->Tot_bobot_kpi),2);
                        // $persen_bd=round(($row->weightage_bd/$row->Tot_bobot_bd),2);
                    ?>
                    <tr>
                        <td  class="p-1" align="center">
                            <?php echo $row->kd_bds;?>
                        </td>
                        <td width="300" class="p-1">
                            <?php echo $row->nm_measurement;?>
                        </td>				
                        <td width="300" class="p-1" align="right">
                            <?php //echo $row->type." ".number_to_money($row->target)." ".$ListUnitSimbol[$row->unit];?>
                            <?php echo $row->tipe_target." ".$row->target_label;?>
                        </td>
                        <td width="200" class="p-1">
                            <?php echo form_input(array(
                                                        'name'          => 'actual['.$i.']',
                                                        'id'            => 'actual'.$i,
                                                        'class'         => 'form-control',
                                                        'required'      => true,
                                                        'type'          => 'number',
                                                        'step'          => '.01'
                                                ),set_value('actual['.$i.']'));
                                    echo form_input(array(
                                                        'name'          => 'weightage_kpi['.$i.']',
                                                        'id'            => 'weightage_kpi'.$i,
                                                        'class'         => 'form-control',
                                                        'type'          => 'hidden'
                                                ),set_value('weightage_kpi['.$i.']',$persen_kpi));    
                                    // echo form_input(array(
                                    //                     'name'          => 'weightage_bd['.$i.']',
                                    //                     'id'            => 'weightage_bd'.$i,
                                    //                     'class'         => 'form-control',
                                    //                     'type'          => 'hidden'
                                    //             ),set_value('weightage_bd['.$i.']',$persen_bd));   
                                    // echo form_input(array(
                                    //                     'name'          => 'weightage_bd_dept['.$i.']',
                                    //                     'id'            => 'weightage_bd_dept'.$i,
                                    //                     'class'         => 'form-control',
                                    //                     'type'          => 'hidden'
                                    //             ),set_value('weightage_bd_dept['.$i.']',$persenKPIDepartemen));   
                                    echo form_input(array(
                                                        'name'          => 'kd_measurement['.$i.']',
                                                        'id'            => 'kd_measurement'.$i,
                                                        'class'         => 'form-control',
                                                        'type'          => 'hidden'
                                                ),set_value('kd_measurement['.$i.']',$row->kd_measurement));    
                                    echo form_input(array(
                                                        'name'          => 'target['.$i.']',
                                                        'id'            => 'target'.$i,
                                                        'class'         => 'form-control',
                                                        'type'          => 'hidden'
                                                ),set_value('target['.$i.']',$row->target_baru));      
                                    echo form_input(array(
                                                        'name'          => 'unit['.$i.']',
                                                        'id'            => 'unit'.$i,
                                                        'class'         => 'form-control',
                                                        'type'          => 'hidden'
                                                ),set_value('unit['.$i.']',$row->unit));      
                                    echo form_input(array(
                                                        'name'          => 'period['.$i.']',
                                                        'id'            => 'period'.$i,
                                                        'class'         => 'form-control',
                                                        'type'          => 'hidden'
                                                ),set_value('period['.$i.']',$row->period));  
                                    echo form_input(array(
                                                        'name'          => 'type['.$i.']',
                                                        'id'            => 'type'.$i,
                                                        'class'         => 'form-control',
                                                        'type'          => 'hidden'
                                                ),set_value('type['.$i.']',$row->tipe_target));  
                                    echo form_input(array(
                                                    'name'          => 'status_calculate['.$i.']',
                                                    'id'            => 'status_calculate'.$i,
                                                    'class'         => 'form-control',
                                                    'type'          => 'hidden'
                                            ),set_value('status_calculate['.$i.']',$row->status_calculate)); 
                                    echo form_input(array(
                                                'name'          => 'target_label['.$i.']',
                                                'id'            => 'target_label'.$i,
                                                'class'         => 'form-control',
                                                'type'          => 'hidden'
                                        ),set_value('target_label['.$i.']',$row->target_label));   
                                    echo form_input(array(
                                                'name'          => 'formula['.$i.']',
                                                'id'            => 'formula'.$i,
                                                'class'         => 'form-control',
                                                'type'          => 'hidden',
                                                'value'         => $row->formula
                                        ),set_value('formula['.$i.']'));   
                            ?>
                        </td>
                    </tr>
                    <?php
                            $i++;
                        }
                    ?>
                </tbody>
            </table>
        </div>
        
    </div>
    <div class="form-group m-form__group">
            <?php echo form_label($this->lang->line('remark'),'remark');?>
            <?php echo form_textarea(array(
                                        'name'          => 'remark',
                                        'id'            => 'remark',
                                        'class'         => 'form-control m-input',
                                        'placeholder'    => $this->lang->line('remark')
                                ),set_value('remark'));
                    echo form_hidden("kd_departemen",$DataRow->kd_dept_peg);  
                    echo form_hidden("kd_jabatan",$DataRow->kd_jabatan); 
                    echo form_hidden("report_to",$DataRow->report_to); 
                    echo form_hidden("bulan",$DataBulan);   
                    echo form_hidden("tahun",$DataTahun);              
            ?>
        <div class="error"></div>
    </div>
</div>
<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData=$DataMeasurementDept->row();
?>
<div class="m-form__heading">
	<h3 class="m-form__heading-title"><?php echo $this->lang->line('header_bobot_title')." ".$RowData->nm_measurement." (".$RowData->kd_measurement.")"; ?></h3>
</div>
<div class="form-group m-form__group">
	<?php echo form_label($this->lang->line('tahun')."<span class='m--font-danger'>*</span>",'tahun');?>
        <p class="form-control-static"><?php echo $Tahun; ?></p>
        <?php echo form_hidden("tahun",$Tahun);?>
        <div class="error"></div>
</div>
<div class="form-group m-form__group">
	<?php echo form_label($this->lang->line('weightage')."<span class='m--font-danger'>*</span>",'weightage');?>
    <div class="m-section__content " id="alert_error_section"></div>
        <table class="table table-bordered table-hover">
            <thead>
                    <tr>
                            <th>#</th>
                            <th width="100"><?php echo $this->lang->line('kd_departemen');?></th>
                            <th><?php echo $this->lang->line('nm_departemen');?></th>
                            <th width="150"><?php echo $this->lang->line('weightage_bd');?></th>
                            <th width="100"><?php echo "Total (%)";?></th>
                    </tr>
            </thead>
            <tbody>
                <?php
                $no=1;
                $Total=0;
                $Total_persen=0;
                foreach($DataMeasurementDept->result() as $row)
                {
                    $Total=$Total+$row->weightage_bd;
                    $persen=round(($row->weightage_bd/$row->Tot_bobot_bd)*100,2);
                    $Total_persen=$Total_persen+$persen;
                ?>
                    <tr>
                            <td scope="row"><?php echo $no; ?></td>
                            <td>
                                <?php echo form_input(array(
                                                            'name'          => 'kd_departemen[]',
                                                            'id'            => 'kd_departemen'.$no,
                                                            'class'         => 'form-control m-input ',
                                                            'placeholder'    => $this->lang->line('kd_departemen'),
                                                            'readonly'      => true
                                                    ),set_value('kd_departemen'.$no,$row->kd_departemen));
                                         
                                ?>
                                <div class="error"></div>
                            </td>
                            <td>
                                <?php echo form_input(array(
                                                            'name'          => 'nm_departemen[]',
                                                            'id'            => 'nm_departemen'.$no,
                                                            'class'         => 'form-control m-input',
                                                            'placeholder'    => $this->lang->line('nm_departemen'),
                                                            'readonly'      => true
                                                    ),set_value('nm_departemen'.$no,$row->nm_departemen));
                                ?>
                                <div class="error"></div>
                            </td>
                            <td>
                                <?php echo form_input(array(
                                                            'name'          => 'weightage_bd[]',
                                                            'id'            => 'weightage_bd'.$no,
                                                            'class'         => 'form-control m-input list-weightage',
                                                            'placeholder'    => $this->lang->line('weightage_bd'),
                                                            'type'  => 'number'
                                                    ),set_value('weightage_bd'.$no,$row->weightage_bd));
                                        echo form_input(array(
                                                            'name'          => 'weightage_kpi[]',
                                                            'id'            => 'weightage_kpi'.$no,
                                                            'class'         => 'form-control m-input',
                                                            'type'  => 'hidden'
                                                    ),set_value('weightage_kpi'.$no,$row->weightage_kpi));            
                                ?>
                                <div class="error"></div>
                            </td>
                            <td scope="row" align="right" id="<?php echo "bobot".$no; ?>"><?php echo $persen."%"; ?></td>
                    </tr>
                <?php 
                        $no++;
                    }
                ?>
                    <tr>
                        <td colspan="3" align="right"><b>Total</b></td>
                        <td id="total"><?php echo $Total; ?></td>
                        <td id="total_persen" align="right"><?php echo $Total_persen."%"; ?></td>
                        <?php echo form_input(array(
                                                            'name'          => 'total_bobot',
                                                            'id'            => 'total_bobot',
                                                            'type'  => 'hidden'
                                                    ),set_value('total_bobot',$Total_persen));
                                ?>
                    </tr>
            </tbody>
        </table>
</div>


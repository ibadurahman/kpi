<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData=$DataMeasurementPeg->row();
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
	<?php echo form_label($this->lang->line('weightage_bd')."<span class='m--font-danger'>*</span>",'weightage');?>
    <div class="m-section__content " id="alert_error_section"></div>
        <table class="table table-bordered table-hover">
            <thead>
                    <tr>
                            <th>#</th>
                            <th width="100"><?php echo $this->lang->line('nip');?></th>
                            <th><?php echo $this->lang->line('nama');?></th>
                            <th width="150"><?php echo $this->lang->line('weightage_bd');?></th>
                            <th width="100"><?php echo "Total (%)";?></th>
                    </tr>
            </thead>
            <tbody>
                <?php
                $no=1;
                $Total=0;
                $Total_persen=0;
                foreach($DataMeasurementPeg->result() as $row)
                {
                    $Total=$Total+$row->weightage_bd;
                    $persen=round(($row->weightage_bd/$row->Tot_bobot_bd)*100,2);
                    $Total_persen=$Total_persen+$persen;
                ?>
                    <tr>
                            <td scope="row"><?php echo $no; ?></td>
                            <td>
                                <?php echo form_input(array(
                                                            'name'          => 'nip[]',
                                                            'id'            => 'nip'.$no,
                                                            'class'         => 'form-control m-input ',
                                                            'placeholder'    => $this->lang->line('nip'),
                                                            'readonly'      => true
                                                    ),set_value('nip'.$no,$row->nip));
                                         
                                ?>
                                <div class="error"></div>
                            </td>
                            <td>
                                <?php echo form_input(array(
                                                            'name'          => 'nama[]',
                                                            'id'            => 'nama'.$no,
                                                            'class'         => 'form-control m-input',
                                                            'placeholder'    => $this->lang->line('nama'),
                                                            'readonly'      => true
                                                    ),set_value('nama'.$no,$row->nama));
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
                                        echo form_input(array(
                                                            'name'          => 'kd_pkd[]',
                                                            'id'            => 'kd_pkd'.$no,
                                                            'class'         => 'form-control m-input',
                                                            'type'  => 'hidden'
                                                    ),set_value('kd_pkd'.$no,$row->kd_pkd));               
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


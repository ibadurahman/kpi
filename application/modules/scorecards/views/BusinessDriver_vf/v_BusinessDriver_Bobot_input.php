<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData=$DataBusinessDriver->row();
?>
<div class="m-form__heading">
	<h3 class="m-form__heading-title"><?php echo $this->lang->line('header_bobot_title')." ".$RowData->nm_perspective." (".$RowData->kd_ps.")"; ?></h3>
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
                            <th width="100"><?php echo $this->lang->line('kd_bd');?></th>
                            <th><?php echo $this->lang->line('nm_bd');?></th>
                            <th width="150"><?php echo $this->lang->line('weightage');?></th>
                            <th width="100"><?php echo "Total (%)";?></th>
                    </tr>
            </thead>
            <tbody>
                <?php
                $no=1;
                $Total=0;
                $Total_persen=0;
                foreach($DataBusinessDriver->result() as $row)
                {
                    $Total=$Total+$row->weightage;
                    $Total_persen=$Total_persen+$row->bobot;
                ?>
                    <tr>
                            <td scope="row"><?php echo $no; ?></td>
                            <td>
                                <?php echo form_input(array(
                                                            'name'          => 'kd_bds[]',
                                                            'id'            => 'kd_bds'.$no,
                                                            'class'         => 'form-control m-input ',
                                                            'placeholder'    => $this->lang->line('kd_bds'),
                                                            'readonly'      => true
                                                    ),set_value('kd_bds'.$no,$row->kd_bds));
                                
                                        echo form_input(array(
                                                            'name'          => 'kd_bd[]',
                                                            'id'            => 'kd_bd'.$no,
                                                            'class'         => 'form-control m-input ',
                                                            'placeholder'    => $this->lang->line('kd_bd'),
                                                            'type'      => 'hidden'
                                                    ),set_value('kd_bd'.$no,$row->kd_bd));            
                                ?>
                                <div class="error"></div>
                            </td>
                            <td>
                                <?php echo form_input(array(
                                                            'name'          => 'nm_bd[]',
                                                            'id'            => 'nm_bd'.$no,
                                                            'class'         => 'form-control m-input',
                                                            'placeholder'    => $this->lang->line('nm_bd'),
                                                            'readonly'      => true
                                                    ),set_value('nm_bd'.$no,$row->nm_bd));
                                ?>
                                <div class="error"></div>
                            </td>
                            <td>
                                <?php echo form_input(array(
                                                            'name'          => 'weightage[]',
                                                            'id'            => 'weightage'.$no,
                                                            'class'         => 'form-control m-input list-weightage',
                                                            'placeholder'    => $this->lang->line('weightage'),
                                                            'type'  => 'number'
                                                    ),set_value('weightage'.$no,$row->weightage));
                                ?>
                                <div class="error"></div>
                            </td>
                            <td scope="row" align="right" id="<?php echo "bobot".$no; ?>"><?php echo $row->bobot."%"; ?></td>
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


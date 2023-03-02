<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData=$DataPerspective->row();
?>

<div class="form-group m-form__group m--margin-top-20">
	<?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('kd_perspective'),'kd_perspective');?>
        <?php echo form_input(array(
                                    'name'          => 'kd_perspective_baru',
                                    'id'            => 'kd_perspective_baru',
                                    'class'         => 'form-control m-input',
                                    'placeholder'    => $this->lang->line('kd_perspective')
                            ),set_value('kd_perspective',$RowData->kd_ps));
               echo form_hidden("kd_perspective",$RowData->kd_ps);        
        ?>
        <div class="error"></div>
</div>
<div class="form-group m-form__group m--margin-top-20">
	<?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('nm_perspective'),'nm_perspective');?>
        <?php echo form_input(array(
                                    'name'          => 'nm_perspective',
                                    'id'            => 'nm_perspective',
                                    'class'         => 'form-control m-input',
                                    'placeholder'    => $this->lang->line('nm_perspective')
                            ),set_value('nm_perspective',$RowData->nm_perspective));
        ?>
        <div class="error"></div>
</div>
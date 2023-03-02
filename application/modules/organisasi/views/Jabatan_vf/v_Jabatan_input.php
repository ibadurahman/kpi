<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>

<div class="form-group m-form__group m--margin-top-20">
	<?php echo form_label($this->lang->line('nm_jabatan')."<span class='m--font-danger'>*</span>",'nm_jabatan');?>
        <?php echo form_input(array(
                                    'name'          => 'nm_jabatan',
                                    'id'            => 'nm_jabatan',
                                    'class'         => 'form-control m-input',
                                    'placeholder'    => $this->lang->line('nm_jabatan')
                            ),set_value('nm_jabatan'));
        ?>
    <div class="error"></div>
</div>
<div class="form-group m-form__group m--margin-bottom-20">
        <?php echo form_label($this->lang->line('kd_level')."<span class='m--font-danger'>*</span>",'kd_level');?>
        <?php echo form_dropdown('kd_level', 
                                    $ListLevel, 
                                    set_value('kd_level'),
                                    "id='kd_level' style='width: 100%' class='select2 form-control m-select2' 
                                    data-placeholder='".$this->lang->line('kd_level')."'"); 

        ?>
    <div class="error"></div>
</div>
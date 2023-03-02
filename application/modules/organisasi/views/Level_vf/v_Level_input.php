<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>

<div class="form-group m-form__group m--margin-top-20">
	<?php echo form_label($this->lang->line('nm_level')."<span class='m--font-danger'>*</span>",'nm_level');?>
        <?php echo form_input(array(
                                    'name'          => 'nm_level',
                                    'id'            => 'nm_level',
                                    'class'         => 'form-control m-input',
                                    'placeholder'    => $this->lang->line('nm_level')
                            ),set_value('nm_level'));
        ?>
</div>
<div class="form-group m-form__group">
	<?php echo form_label($this->lang->line('level')."<span class='m--font-danger'>*</span>",'level');?>
        <?php echo form_input(array(
                                    'name'          => 'level',
                                    'id'            => 'level',
                                    'class'         => 'form-control m-input',
                                    'placeholder'    => $this->lang->line('level'),
                                    'type'         => 'number'
                            ),set_value('level'));
        ?>
</div>
<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>

<div class="form-group m-form__group m--margin-top-20">
	<?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('kd_perspective'),'kd_perspective');?>
        <?php echo form_input(array(
                                    'name'          => 'kd_perspective',
                                    'id'            => 'kd_perspective',
                                    'class'         => 'form-control m-input',
                                    'placeholder'    => $this->lang->line('kd_perspective')
                            ),set_value('kd_perspective'));
        ?>
        <div class="error"></div>
</div>
<div class="form-group m-form__group">
	<?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('nm_perspective'),'nm_perspective');?>
        <?php echo form_input(array(
                                    'name'          => 'nm_perspective',
                                    'id'            => 'nm_perspective',
                                    'class'         => 'form-control m-input',
                                    'placeholder'    => $this->lang->line('nm_perspective')
                            ),set_value('nm_perspective'));
        ?>
        <div class="error"></div>
</div>
<div class="form-group m-form__group">
	<label class="m-checkbox m-checkbox--success">
		<?php echo form_checkbox(array(
                                            'name'          => 'stat_bobot',
                                            'id'            => 'stat_bobot',
                                            'value'         => 1
                                    ),set_checkbox('stat_bobot'),TRUE);

                echo $this->lang->line('stat_bobot')." ".$DataTahun; ?>
		<span></span>
	</label>
</div>
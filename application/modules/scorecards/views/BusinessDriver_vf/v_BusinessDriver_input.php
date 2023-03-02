<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>

<div class="form-group m-form__group m--margin-bottom-20">
        <?php echo form_label($this->lang->line('kd_perspective')."<span class='m--font-danger'>*</span>",'kd_perspective');?>
        <?php echo form_dropdown('kd_perspective', 
                                    $ListPerspective, 
                                    set_value('kd_perspective'),
                                    "id='kd_perspective' style='width: 100%' class='select2 form-control m-select2' 
                                    data-placeholder='".$this->lang->line('kd_perspective')."'"); 

        ?>
    <div class="error"></div>
</div>
<!--<div class="form-group m-form__group m--margin-top-20">
	<?php //echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('kd_bd'),'kd_bd');?>
        <?php /*echo form_input(array(
                                    'name'          => 'kd_bd',
                                    'id'            => 'kd_bd',
                                    'class'         => 'form-control m-input',
                                    'placeholder'    => $this->lang->line('kd_bd')
                            ),set_value('kd_bd'));
         * 
         */
        ?>
        <div class="error"></div>
</div>-->
<div class="form-group m-form__group m--margin-top-20">
	<?php echo form_label("<span class='m--font-danger'>*</span>".$this->lang->line('nm_bd'),'nm_bd');?>
        <?php echo form_input(array(
                                    'name'          => 'nm_bd',
                                    'id'            => 'nm_bd',
                                    'class'         => 'form-control m-input',
                                    'placeholder'    => $this->lang->line('nm_bd')
                            ),set_value('nm_bd'));
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
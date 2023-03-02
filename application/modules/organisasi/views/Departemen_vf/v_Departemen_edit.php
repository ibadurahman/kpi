<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$RowData = $DataDepartemen->row();
?>

<div class="form-group m-form__group m--margin-top-20">
	<?php echo form_label($this->lang->line('nm_departemen')."<span class='m--font-danger'>*</span>",'nm_departemen');?>
        <?php echo form_input(array(
                                    'name'          => 'nm_departemen',
                                    'id'            => 'nm_departemen',
                                    'class'         => 'form-control m-input',
                                    'placeholder'    => $this->lang->line('nm_departemen')
                            ),set_value('nm_departemen',$RowData->nm_departemen));
        ?>
</div>
<?php 
$RowData = $DataDepartemen->row();
        
?>
<div class="form-group m-form__group m--margin-top-20">
	<?php echo form_label($this->lang->line('kd_departemen'),'kd_departemen',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $RowData->kd_departemen; ?></p>
</div>
<div class="form-group m-form__group">
	<?php echo form_label($this->lang->line('nm_departemen'),'nm_departemen',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $RowData->nm_departemen; ?></p>
</div>
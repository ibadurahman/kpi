<?php 
$RowData = $DataJabatan->row();
        
?>
<div class="form-group m-form__group m--margin-top-20">
	<?php echo form_label($this->lang->line('kd_jabatan'),'kd_jabatan',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $RowData->kd_jabatan; ?></p>
</div>
<div class="form-group m-form__group">
	<?php echo form_label($this->lang->line('nm_jabatan'),'nm_jabatan',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $RowData->nm_jabatan; ?></p>
</div>
<div class="form-group m-form__group m--margin-bottom-20">
	<?php echo form_label($this->lang->line('kd_level'),'kd_level',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $RowData->nm_level; ?></p>
</div>
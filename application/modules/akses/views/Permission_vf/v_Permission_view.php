<?php 
$RowData = $DataPermission->row();
        
?>
<div class="form-group m-form__group m--margin-top-20">
	<?php echo form_label($this->lang->line('kd_permission'),'kd_permission',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $RowData->kd_permission; ?></p>
</div>
<div class="form-group m-form__group">
	<?php echo form_label($this->lang->line('deskripsi'),'deskripsi',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $RowData->deskripsi; ?></p>
</div>
<div class="form-group m-form__group m--margin-bottom-20">
        <?php echo form_label($this->lang->line('kd_menu'),'kd_menu',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $RowData->menu; ?></p>
</div>
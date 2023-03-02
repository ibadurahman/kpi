<?php 
$RowData = $DataPerusahaan->row();
        
?>
<div class="form-group m-form__group m--margin-top-20">
	<?php echo form_label($this->lang->line('kd_perusahaan'),'kd_perusahaan',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $RowData->kd_perusahaan; ?></p>
</div>
<div class="form-group m-form__group">
	<?php echo form_label($this->lang->line('nm_perusahaan'),'nm_perusahaan',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $RowData->nm_perusahaan; ?></p>
</div>
<div class="form-group m-form__group">
        <?php echo form_label($this->lang->line('alamat'),'alamat',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $RowData->alamat; ?></p>
</div>
<div class="form-group m-form__group">
        <?php echo form_label($this->lang->line('telepon'),'telepon',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $RowData->telepon; ?></p>
</div>
<div class="form-group m-form__group">
        <?php echo form_label($this->lang->line('fax'),'fax',array("class"=>"m--font-boldest"));?>
        <p class="form-control-static"><?php echo $RowData->fax; ?></p>
</div>
<div class="form-group m-form__group m--margin-bottom-20">
    <div class="col-12">
        <?php 
                                            if($RowData->logo!=""){
                                                $LinkFoto= base_url('assets/upload/logo/'.$RowData->logo);
                                            }else{
                                                $LinkFoto= base_url('assets/img/NoImage.png');
                                            } 
                                        ?>
                                        <div id="image-holder"><img src="<?php echo $LinkFoto; ?>" class="thumb-image" style="height: 150px;"/></div>
    </div>
</div>